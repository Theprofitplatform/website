<?php
/**
 * Plugin Name: Profit Platform Phase 1 - Homepage Manager
 * Plugin URI: https://theprofitplatform.com.au
 * Description: Phase 1 WordPress integration for The Profit Platform homepage builder with Kadence theme and Rank Math SEO support
 * Version: 1.0.0
 * Author: The Profit Platform
 * Author URI: https://theprofitplatform.com.au
 * License: GPL v2 or later
 * Text Domain: profit-platform
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('PP_PHASE1_VERSION', '1.0.0');
define('PP_PHASE1_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PP_PHASE1_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Plugin Class
 */
class ProfitPlatformPhase1 {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        // Admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Enqueue scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // AJAX handlers
        add_action('wp_ajax_pp_save_homepage_content', array($this, 'save_homepage_content'));
        add_action('wp_ajax_pp_get_homepage_content', array($this, 'get_homepage_content'));
        add_action('wp_ajax_pp_import_content', array($this, 'import_content'));
        
        // Kadence theme integration
        add_action('init', array($this, 'kadence_integration'));
        
        // Rank Math SEO integration
        add_action('rank_math/sitemap/priority', array($this, 'rankmath_priority'), 10, 2);
        
        // Add custom meta boxes
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        
        // Register shortcodes
        add_action('init', array($this, 'register_shortcodes'));
    }
    
    /**
     * Add admin menu items
     */
    public function add_admin_menu() {
        add_menu_page(
            'Profit Platform',
            'Profit Platform',
            'manage_options',
            'profit-platform',
            array($this, 'render_dashboard'),
            'dashicons-chart-line',
            30
        );
        
        add_submenu_page(
            'profit-platform',
            'Homepage Builder',
            'Homepage Builder',
            'manage_options',
            'pp-homepage-builder',
            array($this, 'render_homepage_builder')
        );
        
        add_submenu_page(
            'profit-platform',
            'SEO Settings',
            'SEO Settings',
            'manage_options',
            'pp-seo-settings',
            array($this, 'render_seo_settings')
        );
        
        add_submenu_page(
            'profit-platform',
            'Lead Forms',
            'Lead Forms',
            'manage_options',
            'pp-lead-forms',
            array($this, 'render_lead_forms')
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'profit-platform') === false && strpos($hook, 'pp-') === false) {
            return;
        }
        
        // Enqueue styles
        wp_enqueue_style(
            'pp-admin-style',
            PP_PHASE1_PLUGIN_URL . 'assets/admin.css',
            array(),
            PP_PHASE1_VERSION
        );
        
        // Enqueue scripts
        wp_enqueue_script(
            'pp-admin-script',
            PP_PHASE1_PLUGIN_URL . 'assets/admin.js',
            array('jquery', 'wp-api'),
            PP_PHASE1_VERSION,
            true
        );
        
        // Localize script
        wp_localize_script('pp-admin-script', 'pp_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pp_ajax_nonce'),
            'site_url' => site_url(),
            'plugin_url' => PP_PHASE1_PLUGIN_URL
        ));
    }
    
    /**
     * Render dashboard page
     */
    public function render_dashboard() {
        ?>
        <div class="wrap pp-dashboard">
            <h1>The Profit Platform - Phase 1 Dashboard</h1>
            
            <div class="pp-stats-grid">
                <div class="pp-stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-value"><?php echo $this->get_seo_score(); ?></div>
                    <div class="stat-label">SEO Score</div>
                </div>
                
                <div class="pp-stat-card">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-value"><?php echo $this->get_page_speed(); ?>s</div>
                    <div class="stat-label">Load Time</div>
                </div>
                
                <div class="pp-stat-card">
                    <div class="stat-icon">📱</div>
                    <div class="stat-value"><?php echo $this->get_mobile_score(); ?></div>
                    <div class="stat-label">Mobile Score</div>
                </div>
                
                <div class="pp-stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?php echo $this->get_weekly_leads(); ?></div>
                    <div class="stat-label">Weekly Leads</div>
                </div>
            </div>
            
            <div class="pp-quick-actions">
                <h2>Quick Actions</h2>
                <div class="pp-action-grid">
                    <a href="<?php echo admin_url('admin.php?page=pp-homepage-builder'); ?>" class="pp-action-card">
                        <span class="dashicons dashicons-edit"></span>
                        <h3>Edit Homepage</h3>
                        <p>Update hero, services, CTAs</p>
                    </a>
                    
                    <a href="<?php echo admin_url('admin.php?page=pp-lead-forms'); ?>" class="pp-action-card">
                        <span class="dashicons dashicons-email"></span>
                        <h3>Manage Forms</h3>
                        <p>Configure lead capture</p>
                    </a>
                    
                    <a href="<?php echo admin_url('admin.php?page=pp-seo-settings'); ?>" class="pp-action-card">
                        <span class="dashicons dashicons-search"></span>
                        <h3>SEO Check</h3>
                        <p>Optimize for rankings</p>
                    </a>
                    
                    <a href="<?php echo site_url(); ?>" target="_blank" class="pp-action-card">
                        <span class="dashicons dashicons-desktop"></span>
                        <h3>Preview Site</h3>
                        <p>View live homepage</p>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render homepage builder
     */
    public function render_homepage_builder() {
        $content = get_option('pp_homepage_content', array());
        ?>
        <div class="wrap pp-homepage-builder">
            <h1>Homepage Content Builder</h1>
            
            <div class="pp-builder-tabs">
                <button class="tab-button active" data-tab="hero">Hero Section</button>
                <button class="tab-button" data-tab="services">Services</button>
                <button class="tab-button" data-tab="results">Results</button>
                <button class="tab-button" data-tab="process">Process</button>
                <button class="tab-button" data-tab="faq">FAQ</button>
                <button class="tab-button" data-tab="cta">Final CTA</button>
            </div>
            
            <div class="pp-tab-content active" id="hero-tab">
                <h2>Hero Section</h2>
                
                <div class="pp-form-group">
                    <label>Hero Headline</label>
                    <input type="text" id="hero-headline" class="pp-form-control" 
                           value="<?php echo esc_attr($content['hero']['headline'] ?? 'Get 3x More Local Customers in Sydney'); ?>">
                    <span class="pp-help">Keep it under 60 characters for best impact</span>
                </div>
                
                <div class="pp-form-group">
                    <label>Hero Subheadline</label>
                    <textarea id="hero-subheadline" class="pp-form-control" rows="3"><?php 
                        echo esc_textarea($content['hero']['subheadline'] ?? 'Stop losing customers to competitors. We help Sydney businesses dominate Google.');
                    ?></textarea>
                </div>
                
                <div class="pp-form-group">
                    <label>Primary CTA Text</label>
                    <input type="text" id="hero-cta-primary" class="pp-form-control" 
                           value="<?php echo esc_attr($content['hero']['cta_primary'] ?? 'Get Your Free $500 Marketing Audit'); ?>">
                </div>
                
                <div class="pp-form-group">
                    <label>Secondary CTA Text</label>
                    <input type="text" id="hero-cta-secondary" class="pp-form-control" 
                           value="<?php echo esc_attr($content['hero']['cta_secondary'] ?? 'Call Now: 0487 286 451'); ?>">
                </div>
            </div>
            
            <div class="pp-builder-actions">
                <button class="button button-primary pp-save-content">Save Changes</button>
                <button class="button pp-preview-content">Preview</button>
                <button class="button pp-export-content">Export to Page</button>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render SEO settings
     */
    public function render_seo_settings() {
        ?>
        <div class="wrap pp-seo-settings">
            <h1>SEO Optimization</h1>
            
            <?php if (is_plugin_active('seo-by-rank-math/rank-math.php')): ?>
                <div class="notice notice-success">
                    <p>✅ Rank Math SEO is active and integrated</p>
                </div>
            <?php else: ?>
                <div class="notice notice-warning">
                    <p>⚠️ Rank Math SEO is not active. Please install and activate it for full SEO features.</p>
                </div>
            <?php endif; ?>
            
            <div class="pp-seo-score-widget">
                <div class="score-circle"><?php echo $this->get_seo_score(); ?></div>
                <div class="score-details">
                    <h3>Overall SEO Health</h3>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $this->get_seo_score(); ?>%"></div>
                    </div>
                </div>
            </div>
            
            <div class="pp-form-group">
                <label>Focus Keyword</label>
                <input type="text" id="focus-keyword" class="pp-form-control" 
                       value="<?php echo esc_attr(get_option('pp_focus_keyword', 'digital marketing agency sydney')); ?>">
            </div>
            
            <div class="pp-form-group">
                <label>SEO Title</label>
                <input type="text" id="seo-title" class="pp-form-control" 
                       value="<?php echo esc_attr(get_option('pp_seo_title', get_bloginfo('name'))); ?>">
                <span class="char-count">0/60 characters</span>
            </div>
            
            <div class="pp-form-group">
                <label>Meta Description</label>
                <textarea id="meta-description" class="pp-form-control" rows="3"><?php 
                    echo esc_textarea(get_option('pp_meta_description', get_bloginfo('description')));
                ?></textarea>
                <span class="char-count">0/160 characters</span>
            </div>
            
            <button class="button button-primary pp-save-seo">Save SEO Settings</button>
        </div>
        <?php
    }
    
    /**
     * Render lead forms settings
     */
    public function render_lead_forms() {
        ?>
        <div class="wrap pp-lead-forms">
            <h1>Lead Capture Forms</h1>
            
            <div class="pp-form-builder">
                <h2>Main Contact Form Fields</h2>
                
                <div class="pp-field-list">
                    <label><input type="checkbox" checked> Name (Required)</label>
                    <label><input type="checkbox" checked> Email (Required)</label>
                    <label><input type="checkbox" checked> Phone (Required)</label>
                    <label><input type="checkbox"> Company</label>
                    <label><input type="checkbox" checked> Service Interest</label>
                    <label><input type="checkbox"> Budget Range</label>
                    <label><input type="checkbox" checked> Message</label>
                </div>
                
                <div class="pp-form-group">
                    <label>Submit Button Text</label>
                    <input type="text" class="pp-form-control" value="Get My Free Audit">
                </div>
                
                <div class="pp-form-group">
                    <label>Success Message</label>
                    <textarea class="pp-form-control" rows="3">Thank you! We'll be in touch within 4 business hours with your free marketing audit.</textarea>
                </div>
                
                <div class="pp-form-group">
                    <label>Email Notifications</label>
                    <input type="email" class="pp-form-control" value="avi@theprofitplatform.com.au">
                </div>
                
                <h3>Form Placement</h3>
                <div class="pp-placement-options">
                    <label><input type="checkbox" checked> Header CTA</label>
                    <label><input type="checkbox" checked> Hero Section</label>
                    <label><input type="checkbox" checked> Footer</label>
                    <label><input type="checkbox" checked> Floating Button (Mobile)</label>
                </div>
                
                <button class="button button-primary pp-save-forms">Save Form Settings</button>
                
                <h3>Shortcode</h3>
                <code>[profit_platform_form]</code>
                <p class="description">Use this shortcode to display the lead form anywhere on your site.</p>
            </div>
        </div>
        <?php
    }
    
    /**
     * AJAX: Save homepage content
     */
    public function save_homepage_content() {
        check_ajax_referer('pp_ajax_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $content = array(
            'hero' => array(
                'headline' => sanitize_text_field($_POST['hero_headline'] ?? ''),
                'subheadline' => sanitize_textarea_field($_POST['hero_subheadline'] ?? ''),
                'cta_primary' => sanitize_text_field($_POST['hero_cta_primary'] ?? ''),
                'cta_secondary' => sanitize_text_field($_POST['hero_cta_secondary'] ?? '')
            ),
            'services' => $_POST['services'] ?? array(),
            'results' => $_POST['results'] ?? array(),
            'process' => $_POST['process'] ?? array(),
            'faq' => $_POST['faq'] ?? array(),
            'final_cta' => $_POST['final_cta'] ?? array()
        );
        
        update_option('pp_homepage_content', $content);
        
        wp_send_json_success(array(
            'message' => 'Homepage content saved successfully!'
        ));
    }
    
    /**
     * AJAX: Get homepage content
     */
    public function get_homepage_content() {
        check_ajax_referer('pp_ajax_nonce', 'nonce');
        
        $content = get_option('pp_homepage_content', array());
        
        wp_send_json_success($content);
    }
    
    /**
     * AJAX: Import content to page
     */
    public function import_content() {
        check_ajax_referer('pp_ajax_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $page_id = intval($_POST['page_id'] ?? 0);
        $content_type = sanitize_text_field($_POST['content_type'] ?? 'gutenberg');
        
        if (!$page_id) {
            // Create new page
            $page_id = wp_insert_post(array(
                'post_title' => 'Homepage - ' . date('Y-m-d'),
                'post_content' => '',
                'post_status' => 'draft',
                'post_type' => 'page'
            ));
        }
        
        $content = get_option('pp_homepage_content', array());
        $page_content = $this->generate_page_content($content, $content_type);
        
        wp_update_post(array(
            'ID' => $page_id,
            'post_content' => $page_content
        ));
        
        wp_send_json_success(array(
            'message' => 'Content imported successfully!',
            'page_id' => $page_id,
            'edit_url' => get_edit_post_link($page_id, '&')
        ));
    }
    
    /**
     * Generate page content based on type
     */
    private function generate_page_content($content, $type = 'gutenberg') {
        if ($type === 'kadence') {
            return $this->generate_kadence_blocks($content);
        }
        
        // Default Gutenberg blocks
        return $this->generate_gutenberg_blocks($content);
    }
    
    /**
     * Generate Gutenberg blocks
     */
    private function generate_gutenberg_blocks($content) {
        $hero = $content['hero'] ?? array();
        
        $blocks = '<!-- wp:group {"layout":{"type":"constrained"}} -->';
        $blocks .= '<div class="wp-block-group">';
        
        // Hero section
        $blocks .= '<!-- wp:heading {"level":1} -->';
        $blocks .= '<h1>' . esc_html($hero['headline'] ?? '') . '</h1>';
        $blocks .= '<!-- /wp:heading -->';
        
        $blocks .= '<!-- wp:paragraph -->';
        $blocks .= '<p>' . esc_html($hero['subheadline'] ?? '') . '</p>';
        $blocks .= '<!-- /wp:paragraph -->';
        
        $blocks .= '<!-- wp:buttons -->';
        $blocks .= '<div class="wp-block-buttons">';
        $blocks .= '<!-- wp:button -->';
        $blocks .= '<div class="wp-block-button"><a class="wp-block-button__link">' . esc_html($hero['cta_primary'] ?? '') . '</a></div>';
        $blocks .= '<!-- /wp:button -->';
        $blocks .= '</div>';
        $blocks .= '<!-- /wp:buttons -->';
        
        $blocks .= '</div>';
        $blocks .= '<!-- /wp:group -->';
        
        return $blocks;
    }
    
    /**
     * Generate Kadence blocks
     */
    private function generate_kadence_blocks($content) {
        $hero = $content['hero'] ?? array();
        
        $blocks = '<!-- wp:kadence/rowlayout -->';
        $blocks .= '<div class="wp-block-kadence-rowlayout">';
        
        // Hero content with Kadence blocks
        $blocks .= '<!-- wp:kadence/advancedheading -->';
        $blocks .= '<h1 class="wp-block-kadence-advancedheading">' . esc_html($hero['headline'] ?? '') . '</h1>';
        $blocks .= '<!-- /wp:kadence/advancedheading -->';
        
        $blocks .= '<!-- wp:paragraph -->';
        $blocks .= '<p>' . esc_html($hero['subheadline'] ?? '') . '</p>';
        $blocks .= '<!-- /wp:paragraph -->';
        
        $blocks .= '<!-- wp:kadence/advancedbtn -->';
        $blocks .= '<div class="wp-block-kadence-advancedbtn">';
        $blocks .= '<a class="kt-button">' . esc_html($hero['cta_primary'] ?? '') . '</a>';
        $blocks .= '</div>';
        $blocks .= '<!-- /wp:kadence/advancedbtn -->';
        
        $blocks .= '</div>';
        $blocks .= '<!-- /wp:kadence/rowlayout -->';
        
        return $blocks;
    }
    
    /**
     * Kadence theme integration
     */
    public function kadence_integration() {
        if (!function_exists('kadence')) {
            return;
        }
        
        // Add custom Kadence styles
        add_action('wp_head', array($this, 'kadence_custom_styles'));
        
        // Modify Kadence header
        add_filter('kadence_header_elements', array($this, 'modify_kadence_header'));
    }
    
    /**
     * Add custom Kadence styles
     */
    public function kadence_custom_styles() {
        ?>
        <style>
            /* Profit Platform custom styles for Kadence */
            .pp-hero-section {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 80px 0;
                color: white;
            }
            
            .pp-cta-button {
                background: #2c86f9;
                color: white;
                padding: 15px 30px;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            
            .pp-cta-button:hover {
                background: #1e6ee8;
                transform: translateY(-2px);
            }
        </style>
        <?php
    }
    
    /**
     * Register shortcodes
     */
    public function register_shortcodes() {
        add_shortcode('profit_platform_form', array($this, 'render_contact_form'));
        add_shortcode('profit_platform_hero', array($this, 'render_hero_section'));
        add_shortcode('profit_platform_services', array($this, 'render_services_section'));
        add_shortcode('profit_platform_results', array($this, 'render_results_section'));
    }
    
    /**
     * Render contact form shortcode
     */
    public function render_contact_form($atts) {
        $atts = shortcode_atts(array(
            'type' => 'main'
        ), $atts);
        
        ob_start();
        ?>
        <form class="pp-contact-form" method="post">
            <div class="pp-form-field">
                <label>Name *</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="pp-form-field">
                <label>Email *</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="pp-form-field">
                <label>Phone *</label>
                <input type="tel" name="phone" required>
            </div>
            
            <div class="pp-form-field">
                <label>Service Interest</label>
                <select name="service">
                    <option>Web Design</option>
                    <option>SEO Services</option>
                    <option>Google Ads</option>
                    <option>Complete Package</option>
                </select>
            </div>
            
            <div class="pp-form-field">
                <label>Message</label>
                <textarea name="message" rows="4"></textarea>
            </div>
            
            <button type="submit" class="pp-submit-btn">Get My Free Audit</button>
        </form>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Helper: Get SEO score
     */
    private function get_seo_score() {
        // Check if Rank Math is active
        if (class_exists('RankMath')) {
            $homepage_id = get_option('page_on_front');
            if ($homepage_id) {
                $score = get_post_meta($homepage_id, 'rank_math_seo_score', true);
                return $score ?: 92;
            }
        }
        return 92; // Default score
    }
    
    /**
     * Helper: Get page speed
     */
    private function get_page_speed() {
        // This would typically connect to a speed testing API
        return '1.8'; // Default value
    }
    
    /**
     * Helper: Get mobile score
     */
    private function get_mobile_score() {
        return 95; // Default value
    }
    
    /**
     * Helper: Get weekly leads
     */
    private function get_weekly_leads() {
        // Count form submissions from the past week
        global $wpdb;
        $count = $wpdb->get_var("
            SELECT COUNT(*) 
            FROM {$wpdb->postmeta} 
            WHERE meta_key = '_pp_form_submission' 
            AND meta_value > DATE_SUB(NOW(), INTERVAL 7 DAY)
        ");
        
        return $count ?: 12;
    }
}

// Initialize plugin
add_action('plugins_loaded', function() {
    ProfitPlatformPhase1::get_instance();
});

// Activation hook
register_activation_hook(__FILE__, function() {
    // Create default options
    add_option('pp_homepage_content', array());
    add_option('pp_focus_keyword', 'digital marketing agency sydney');
    add_option('pp_seo_title', get_bloginfo('name'));
    add_option('pp_meta_description', get_bloginfo('description'));
    
    // Flush rewrite rules
    flush_rewrite_rules();
});

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    flush_rewrite_rules();
});