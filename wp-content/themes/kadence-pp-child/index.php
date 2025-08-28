<?php
/**
 * The main template file for Kadence The Profit Platform Child Theme
 * 
 * This file is used when a more specific template can't be found
 * Falls back to parent theme's index.php
 * 
 * @package Kadence_PP_Child
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Load parent theme's index.php
get_template_part('index');