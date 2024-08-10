<?php

if (!defined('ABSPATH')) {
    exit;
}

class Shipping_Price_Calculator {

    public function __construct() {
        // Rejestracja shortcode
        add_shortcode('shipping_price_calculator', [$this, 'display_form']);

        // Rejestracja obsługi AJAX
        add_action('wp_ajax_calculate_shipping_price', [$this, 'calculate_shipping_price']);
        add_action('wp_ajax_nopriv_calculate_shipping_price', [$this, 'calculate_shipping_price']);

        // Rejestracja enqueue skryptów
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        // Dodanie strony ustawień w panelu administracyjnym
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    //wczytanie pliku z formularzem
    public function display_form() {
        $template_path = plugin_dir_path(__FILE__) . '../templates/form-shipping-price.php';
        if (file_exists($template_path)) {
            include $template_path;
        }
    }

    public function calculate_shipping_price() {
        $length = isset($_POST['length']) ? intval($_POST['length']) : null;
        $width = isset($_POST['width']) ? intval($_POST['width']) : null;
        $height = isset($_POST['height']) ? intval($_POST['height']) : null;
    
        $api_endpoint = get_option('spc_api_endpoint');
        $api_key = get_option('spc_api_key');
    
        if (empty($api_endpoint) || empty($api_key)){
            //wyślij błąd z błędną konfiguracją API - key lub endpoint 
            wp_send_json_error(
                [
                    'error' => 'invalid_config',
                    'message' => 'Nieprawidłowa konfiguracja API'
                ],
                400
            );
            wp_die();
        }

        if ($length <= 0 || $width <= 0 || $height <= 0 || !$length || !$width || !$height) {
            //wyślij błąd z nieprawidłowymi danymi wejściowymi
            wp_send_json_error(
                [
                    'error' => 'invalid_input',
                    'message' => 'Nieprawidłowe dane wejściowe'
                ],
                400
            );
            wp_die();
        }

        //ask api
        $response = wp_remote_post($api_endpoint, array(
            'body' => array(
                'api_key' => $api_key,
                'length' => $length,
                'width' => $width,
                'height' => $height
            )
        ));
        
        if (is_wp_error($response)) {
            //bład w komunikacji z api
            wp_send_json_error(
                [
                    'error' => 'api_connection',
                    'message' => 'Błąd w połączeniu z API'
                ],
                400
            );
            wp_die();
        }

        $body = wp_remote_retrieve_body($response); //pobiera body odpowiedzi http
        $data = json_decode($body, true); //dekoduje zawartość JSON z odpowiedzi

        if (!$data) {
            //sprawdzenie, czy odpowiedź jest w formacie JSON
            wp_send_json_error(
                [
                    'error' => 'invalid_response',
                    'message' => 'Niepoprawna odpowiedź z API'
                ],
                500
            );
            wp_die();
        }
        
        //sukces udało się odebrać dane
        wp_send_json_success(['shipping_cost' => $data['shipping_cost']]);

        wp_die();

    }
    
    
    //dodanie assetów js i css
    public function enqueue_scripts() {
        wp_enqueue_script('spc-calculator-js', plugin_dir_url(__FILE__) . '../assets/js/shipping-price-calculator.js', array('jquery'), null, true); //dodanie js
        wp_localize_script('spc-calculator-js', 'spc_ajax', array('ajax_url' => admin_url('admin-ajax.php'))); //utworzenie obiektu z przekazaniem do js

        wp_enqueue_style('spc-calculator-css', plugin_dir_url(__FILE__) . '../assets/css/shipping-price-calculator.css'); //dodanie css
    }

    //dodanie do menu admina
    public function add_admin_menu() {
        add_menu_page('Shipping Price Calculator', 'Shipping Price', 'manage_options', 'shipping-price-calculator', [$this, 'settings_page']); 
    }

    //wczytanie pliku z ustawieniami w panelu
    public function settings_page() {
        $template_path = plugin_dir_path(__FILE__) . '../templates/admin-settings-page.php';
        if (file_exists($template_path)) {
            include $template_path;
        }
    }

    //dodanie ustawień
    public function register_settings() {
        register_setting('spc_settings_group', 'spc_api_endpoint');
        register_setting('spc_settings_group', 'spc_api_key');
    }
}

?>
