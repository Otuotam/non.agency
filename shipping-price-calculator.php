<?php
/*
Plugin Name: Shipping Price Calculator
Description: Plugin do obliczania ceny przesyłki na podstawie wymiarów paczki przekazanych do API - zadanie rekrutacyjne non.agency.
Version: 1.0
Author: Otu
*/

if (!defined('ABSPATH')) {
    exit;
}

//ładowanie klasy głównej pluginu
require_once plugin_dir_path(__FILE__) . 'includes/class-shipping-price-calculator.php';

//inicjalizacja pluginu
function spc_init() {
    $spc = new Shipping_Price_Calculator();
}
add_action('plugins_loaded', 'spc_init');
