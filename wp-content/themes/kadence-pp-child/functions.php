<?php
/**
 * The Profit Platform - Kadence Child Theme Functions
 * 
 * Customizations for The Profit Platform digital marketing agency
 * 
 * @package Kadence_PP_Child
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

define('KADENCE_PP_CHILD_VERSION', '1.0.2');
define('KADENCE_PP_CHILD_PATH', get_stylesheet_directory());
define('KADENCE_PP_CHILD_URL', get_stylesheet_directory_uri());

/**
 * Enqueue parent and child theme styles
 */
function kadence_pp_child_enqueue_styles() {
    // Enqueue parent theme style
    wp_enqueue_style('kadence-style', get_template_directory_uri() . '/style.css');
    
    // Enqueue child theme style
    wp_enqueue_style('kadence-pp-child-style', 
        get_stylesheet_directory_uri() . '/style.css', 
        array('kadence-style'), 
        KADENCE_PP_CHILD_VERSION
    );
    
    // Enqueue custom CSS
    wp_enqueue_style('kadence-pp-child-custom', 
        get_stylesheet_directory_uri() . '/assets/css/custom.css', 
        array('kadence-pp-child-style'), 
        KADENCE_PP_CHILD_VERSION
    );
    
    // Enqueue Google Fonts
    wp_enqueue_style('kadence-pp-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap',
        false
    );
}
add_action('wp_enqueue_scripts', 'kadence_pp_child_enqueue_styles');

/**
 * Enqueue child theme scripts
 */
function kadence_pp_child_enqueue_scripts() {
    // Enqueue custom JavaScript
    wp_enqueue_script('kadence-pp-child-custom', 
        get_stylesheet_directory_uri() . '/assets/js/custom.js', 
        array('jquery'), 
        KADENCE_PP_CHILD_VERSION, 
        true
    );
    
    // Localize script for AJAX
    wp_localize_script('kadence-pp-child-custom', 'pp_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('pp_nonce'),
        'site_url' => home_url(),
    ));
}
add_action('wp_enqueue_scripts', 'kadence_pp_child_enqueue_scripts');

/**
 * Add theme support
 */
function kadence_pp_child_theme_support() {
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');
    
    // Add support for title tag
    add_theme_support('title-tag');
    
    // Add support for HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
}
add_action('after_setup_theme', 'kadence_pp_child_theme_support');

/**
 * Register custom post types for The Profit Platform
 */
function kadence_pp_register_post_types() {
    // Case Studies post type
    register_post_type('case_studies', array(
        'labels' => array(
            'name' => 'Case Studies',
            'singular_name' => 'Case Study',
            'menu_name' => 'Case Studies',
            'add_new' => 'Add Case Study',
            'add_new_item' => 'Add New Case Study',
            'edit_item' => 'Edit Case Study',
            'new_item' => 'New Case Study',
            'view_item' => 'View Case Study',
            'search_items' => 'Search Case Studies',
            'not_found' => 'No case studies found',
            'not_found_in_trash' => 'No case studies found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-chart-line',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true,
    ));
    
    // Testimonials post type
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',
            'menu_name' => 'Testimonials',
            'add_new' => 'Add Testimonial',
            'add_new_item' => 'Add New Testimonial',
            'edit_item' => 'Edit Testimonial',
            'new_item' => 'New Testimonial',
            'view_item' => 'View Testimonial',
            'search_items' => 'Search Testimonials',
            'not_found' => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-testimonial',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'kadence_pp_register_post_types');

/**
 * Add custom meta boxes
 */
function kadence_pp_add_meta_boxes() {
    // Case Study meta box
    add_meta_box(
        'case_study_details',
        'Case Study Details',
        'kadence_pp_case_study_meta_box_callback',
        'case_studies',
        'normal',
        'high'
    );
    
    // Testimonial meta box
    add_meta_box(
        'testimonial_details',
        'Client Details',
        'kadence_pp_testimonial_meta_box_callback',
        'testimonials',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kadence_pp_add_meta_boxes');

/**
 * Case Study meta box callback
 */
function kadence_pp_case_study_meta_box_callback($post) {
    wp_nonce_field('kadence_pp_case_study_nonce', 'kadence_pp_case_study_nonce');
    
    $client_name = get_post_meta($post->ID, '_pp_client_name', true);
    $industry = get_post_meta($post->ID, '_pp_industry', true);
    $challenge = get_post_meta($post->ID, '_pp_challenge', true);
    $solution = get_post_meta($post->ID, '_pp_solution', true);
    $results = get_post_meta($post->ID, '_pp_results', true);
    $roi = get_post_meta($post->ID, '_pp_roi', true);
    $timeline = get_post_meta($post->ID, '_pp_timeline', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="pp_client_name">Client Name</label></th>
            <td><input type="text" id="pp_client_name" name="pp_client_name" value="<?php echo esc_attr($client_name); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="pp_industry">Industry</label></th>
            <td><input type="text" id="pp_industry" name="pp_industry" value="<?php echo esc_attr($industry); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="pp_challenge">Challenge</label></th>
            <td><textarea id="pp_challenge" name="pp_challenge" rows="3" style="width: 100%;"><?php echo esc_textarea($challenge); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="pp_solution">Solution</label></th>
            <td><textarea id="pp_solution" name="pp_solution" rows="3" style="width: 100%;"><?php echo esc_textarea($solution); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="pp_results">Results</label></th>
            <td><textarea id="pp_results" name="pp_results" rows="3" style="width: 100%;"><?php echo esc_textarea($results); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="pp_roi">ROI Improvement</label></th>
            <td><input type="text" id="pp_roi" name="pp_roi" value="<?php echo esc_attr($roi); ?>" placeholder="e.g., 3.2x" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="pp_timeline">Timeline</label></th>
            <td><input type="text" id="pp_timeline" name="pp_timeline" value="<?php echo esc_attr($timeline); ?>" placeholder="e.g., 90 days" style="width: 100%;" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Testimonial meta box callback
 */
function kadence_pp_testimonial_meta_box_callback($post) {
    wp_nonce_field('kadence_pp_testimonial_nonce', 'kadence_pp_testimonial_nonce');
    
    $client_name = get_post_meta($post->ID, '_pp_testimonial_client_name', true);
    $client_title = get_post_meta($post->ID, '_pp_testimonial_client_title', true);
    $client_company = get_post_meta($post->ID, '_pp_testimonial_client_company', true);
    $rating = get_post_meta($post->ID, '_pp_testimonial_rating', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="pp_testimonial_client_name">Client Name</label></th>
            <td><input type="text" id="pp_testimonial_client_name" name="pp_testimonial_client_name" value="<?php echo esc_attr($client_name); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="pp_testimonial_client_title">Client Title</label></th>
            <td><input type="text" id="pp_testimonial_client_title" name="pp_testimonial_client_title" value="<?php echo esc_attr($client_title); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="pp_testimonial_client_company">Company</label></th>
            <td><input type="text" id="pp_testimonial_client_company" name="pp_testimonial_client_company" value="<?php echo esc_attr($client_company); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="pp_testimonial_rating">Rating</label></th>
            <td>
                <select id="pp_testimonial_rating" name="pp_testimonial_rating" style="width: 100%;">
                    <option value="">Select Rating</option>
                    <option value="5" <?php selected($rating, '5'); ?>>5 Stars</option>
                    <option value="4" <?php selected($rating, '4'); ?>>4 Stars</option>
                    <option value="3" <?php selected($rating, '3'); ?>>3 Stars</option>
                    <option value="2" <?php selected($rating, '2'); ?>>2 Stars</option>
                    <option value="1" <?php selected($rating, '1'); ?>>1 Star</option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save meta box data
 */
function kadence_pp_save_meta_boxes($post_id) {
    // Case Study meta
    if (isset($_POST['kadence_pp_case_study_nonce']) && wp_verify_nonce($_POST['kadence_pp_case_study_nonce'], 'kadence_pp_case_study_nonce')) {
        if (isset($_POST['pp_client_name'])) {
            update_post_meta($post_id, '_pp_client_name', sanitize_text_field($_POST['pp_client_name']));
        }
        if (isset($_POST['pp_industry'])) {
            update_post_meta($post_id, '_pp_industry', sanitize_text_field($_POST['pp_industry']));
        }
        if (isset($_POST['pp_challenge'])) {
            update_post_meta($post_id, '_pp_challenge', sanitize_textarea_field($_POST['pp_challenge']));
        }
        if (isset($_POST['pp_solution'])) {
            update_post_meta($post_id, '_pp_solution', sanitize_textarea_field($_POST['pp_solution']));
        }
        if (isset($_POST['pp_results'])) {
            update_post_meta($post_id, '_pp_results', sanitize_textarea_field($_POST['pp_results']));
        }
        if (isset($_POST['pp_roi'])) {
            update_post_meta($post_id, '_pp_roi', sanitize_text_field($_POST['pp_roi']));
        }
        if (isset($_POST['pp_timeline'])) {
            update_post_meta($post_id, '_pp_timeline', sanitize_text_field($_POST['pp_timeline']));
        }
    }
    
    // Testimonial meta
    if (isset($_POST['kadence_pp_testimonial_nonce']) && wp_verify_nonce($_POST['kadence_pp_testimonial_nonce'], 'kadence_pp_testimonial_nonce')) {
        if (isset($_POST['pp_testimonial_client_name'])) {
            update_post_meta($post_id, '_pp_testimonial_client_name', sanitize_text_field($_POST['pp_testimonial_client_name']));
        }
        if (isset($_POST['pp_testimonial_client_title'])) {
            update_post_meta($post_id, '_pp_testimonial_client_title', sanitize_text_field($_POST['pp_testimonial_client_title']));
        }
        if (isset($_POST['pp_testimonial_client_company'])) {
            update_post_meta($post_id, '_pp_testimonial_client_company', sanitize_text_field($_POST['pp_testimonial_client_company']));
        }
        if (isset($_POST['pp_testimonial_rating'])) {
            update_post_meta($post_id, '_pp_testimonial_rating', sanitize_text_field($_POST['pp_testimonial_rating']));
        }
    }
}
add_action('save_post', 'kadence_pp_save_meta_boxes');

/**
 * Add custom admin menu for The Profit Platform
 */
function kadence_pp_admin_menu() {
    add_menu_page(
        'The Profit Platform',
        'Profit Platform',
        'manage_options',
        'profit-platform',
        'kadence_pp_admin_page',
        'dashicons-chart-area',
        30
    );
}
add_action('admin_menu', 'kadence_pp_admin_menu');

/**
 * Admin page callback
 */
function kadence_pp_admin_page() {
    ?>
    <div class="wrap">
        <h1>The Profit Platform Dashboard</h1>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <div style="background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
                <h2>Quick Stats</h2>
                <p><strong>Case Studies:</strong> <?php echo wp_count_posts('case_studies')->publish; ?></p>
                <p><strong>Testimonials:</strong> <?php echo wp_count_posts('testimonials')->publish; ?></p>
                <p><strong>Pages:</strong> <?php echo wp_count_posts('page')->publish; ?></p>
                <p><strong>Posts:</strong> <?php echo wp_count_posts('post')->publish; ?></p>
            </div>
            <div style="background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
                <h2>Quick Actions</h2>
                <p><a href="<?php echo admin_url('post-new.php?post_type=case_studies'); ?>" class="button button-primary">Add Case Study</a></p>
                <p><a href="<?php echo admin_url('post-new.php?post_type=testimonials'); ?>" class="button button-primary">Add Testimonial</a></p>
                <p><a href="<?php echo admin_url('post-new.php?post_type=page'); ?>" class="button button-secondary">Add Page</a></p>
                <p><a href="<?php echo admin_url('customize.php'); ?>" class="button button-secondary">Customize Theme</a></p>
            </div>
        </div>
        
        <div style="background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px; margin-top: 20px;">
            <h2>The Profit Platform Settings</h2>
            <p>Welcome to The Profit Platform WordPress customizations. This child theme is specifically designed for digital marketing agencies targeting the Sydney market.</p>
            
            <h3>Features Included:</h3>
            <ul>
                <li>Custom post types for Case Studies and Testimonials</li>
                <li>Optimized for local SEO and conversion</li>
                <li>Mobile-first responsive design</li>
                <li>Integration with Kadence theme</li>
                <li>Performance optimizations</li>
            </ul>
            
            <h3>Support:</h3>
            <p>For support and customizations, contact us at <a href="mailto:avi@theprofitplatform.com.au">avi@theprofitplatform.com.au</a></p>
        </div>
    </div>
    <?php
}

/**
 * Customize excerpt length
 */
function kadence_pp_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'kadence_pp_excerpt_length');

/**
 * Add custom excerpt more text
 */
function kadence_pp_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '" class="read-more">Read More</a>';
}
add_filter('excerpt_more', 'kadence_pp_excerpt_more');

/**
 * Add schema markup for local business
 */
function kadence_pp_add_schema_markup() {
    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => 'The Profit Platform',
            'description' => 'Digital Marketing Agency helping Sydney businesses get 3x more leads',
            'url' => home_url(),
            'telephone' => '0487-286-451',
            'email' => 'avi@theprofitplatform.com.au',
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Sydney',
                'addressRegion' => 'NSW',
                'addressCountry' => 'AU'
            ),
            'geo' => array(
                '@type' => 'GeoCoordinates',
                'latitude' => -33.8688,
                'longitude' => 151.2093
            ),
            'openingHours' => 'Mo-Fr 09:00-18:00',
            'priceRange' => '$$',
            'image' => get_stylesheet_directory_uri() . '/assets/images/logo.png'
        );
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
add_action('wp_head', 'kadence_pp_add_schema_markup');

/**
 * Add custom body classes
 */
function kadence_pp_body_classes($classes) {
    $classes[] = 'profit-platform-theme';
    
    if (is_front_page()) {
        $classes[] = 'homepage';
    }
    
    return $classes;
}
add_filter('body_class', 'kadence_pp_body_classes');

/**
 * Security enhancements
 */
function kadence_pp_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'kadence_pp_security_headers');

/**
 * Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Disable XML-RPC for security
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Performance optimizations
 */
function kadence_pp_performance_optimizations() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Remove jQuery migrate
    function kadence_pp_remove_jquery_migrate($scripts) {
        if (!is_admin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];
            if ($script->deps) {
                $script->deps = array_diff($script->deps, array('jquery-migrate'));
            }
        }
    }
    add_action('wp_default_scripts', 'kadence_pp_remove_jquery_migrate');
}
add_action('init', 'kadence_pp_performance_optimizations');

/**
 * Add preload for critical resources
 */
function kadence_pp_preload_resources() {
    echo '<link rel="preload" href="' . get_stylesheet_directory_uri() . '/assets/css/custom.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    echo '<noscript><link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/assets/css/custom.css"></noscript>';
}
add_action('wp_head', 'kadence_pp_preload_resources', 1);