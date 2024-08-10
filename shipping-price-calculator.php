<?php
/*
Plugin Name: Shipping Price Calculator
Description: Plugin do obliczania ceny przesyłki na podstawie wymiarów paczki.
Version: 1.0
Author: Twoje Imię
*/

if (!defined('ABSPATH')) {
    exit;
}

// Ładowanie klasy głównej pluginu
require_once plugin_dir_path(__FILE__) . 'includes/class-shipping-price-calculator.php';

// Inicjalizacja pluginu
function spc_init() {
    $spc = new Shipping_Price_Calculator();
}
add_action('plugins_loaded', 'spc_init');
