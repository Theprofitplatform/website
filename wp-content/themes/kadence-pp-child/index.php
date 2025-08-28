<?php
/**
 * The main template file
 * 
 * This file exists to make the child theme complete.
 * All actual templates are inherited from the parent Kadence theme.
 * 
 * @package Kadence_PP_Child
 * @version 1.0.2
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Load the parent theme's index template
get_template_part('index');
?>
