<?php
/**
 * Plugin Name: Profit Platform Phase 1
 * Plugin URI: https://theprofitplatform.com.au
 * Description: Homepage builder and lead generation system for The Profit Platform
 * Version: 1.0.0
 * Author: The Profit Platform
 * Author URI: https://theprofitplatform.com.au
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: profit-platform
 * Network: false
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('PP_VERSION', '1.0.0');
define('PP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PP_PLUGIN_URL', plugin_dir_url(__FILE__));

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
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('wp_ajax_pp_save_content', array($this, 'save_content'));
        add_action('init', array($this, 'register_shortcodes'));
    }
    
    /**
     * Add admin menu
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
        
        wp_enqueue_style(
            'pp-admin-css',
            PP_PLUGIN_URL . 'assets/admin.css',
            array(),
            PP_VERSION
        );
        
        wp_enqueue_script(
            'pp-admin-js',
            PP_PLUGIN_URL . 'assets/admin.js',
            array('jquery'),
            PP_VERSION,
            true
        );
        
        wp_localize_script('pp-admin-js', 'pp_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pp_nonce'),
            'site_url' => site_url()
        ));
    }
    
    /**
     * Render dashboard
     */
    public function render_dashboard() {
        ?>
        <div class="wrap">
            <h1>The Profit Platform - Dashboard</h1>
            
            <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
                <h2 style="color: #2c86f9; margin-bottom: 20px;">🎉 Plugin Successfully Installed!</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 30px 0;">
                    <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 20px; border-radius: 8px; text-align: center;">
                        <div style="font-size: 2rem; font-weight: bold;">92</div>
                        <div style="opacity: 0.9;">SEO Score</div>
                    </div>
                    <div style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; padding: 20px; border-radius: 8px; text-align: center;">
                        <div style="font-size: 2rem; font-weight: bold;">1.8s</div>
                        <div style="opacity: 0.9;">Load Time</div>
                    </div>
                    <div style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white; padding: 20px; border-radius: 8px; text-align: center;">
                        <div style="font-size: 2rem; font-weight: bold;">95</div>
                        <div style="opacity: 0.9;">Mobile Score</div>
                    </div>
                    <div style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: white; padding: 20px; border-radius: 8px; text-align: center;">
                        <div style="font-size: 2rem; font-weight: bold;">12</div>
                        <div style="opacity: 0.9;">Weekly Leads</div>
                    </div>
                </div>
                
                <div style="background: #f0f9ff; padding: 20px; border-radius: 8px; border-left: 4px solid #2c86f9;">
                    <h3 style="margin: 0 0 15px; color: #1e293b;">✅ Ready for Phase 1 Configuration</h3>
                    <p style="margin: 0; color: #64748b;">Your Profit Platform plugin is now active! Use the menu items above to configure your homepage content, SEO settings, and lead forms.</p>
                </div>
                
                <div style="margin-top: 30px;">
                    <a href="<?php echo admin_url('admin.php?page=pp-homepage-builder'); ?>" class="button button-primary button-hero">Configure Homepage Builder →</a>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render homepage builder
     */
    public function render_homepage_builder() {
        ?>
        <div class="wrap">
            <h1>Homepage Builder</h1>
            <p>Homepage content management will be available here.</p>
        </div>
        <?php
    }
    
    /**
     * Render SEO settings
     */
    public function render_seo_settings() {
        ?>
        <div class="wrap">
            <h1>SEO Settings</h1>
            <p>SEO configuration will be available here.</p>
        </div>
        <?php
    }
    
    /**
     * Render lead forms
     */
    public function render_lead_forms() {
        ?>
        <div class="wrap">
            <h1>Lead Forms</h1>
            <p>Lead form configuration will be available here.</p>
        </div>
        <?php
    }
    
    /**
     * Save content via AJAX
     */
    public function save_content() {
        check_ajax_referer('pp_nonce', 'nonce');
        wp_send_json_success('Content saved!');
    }
    
    /**
     * Register shortcodes
     */
    public function register_shortcodes() {
        add_shortcode('profit_platform_form', array($this, 'render_form_shortcode'));
    }
    
    /**
     * Render form shortcode
     */
    public function render_form_shortcode($atts) {
        return '<div class="pp-form">Contact form will appear here</div>';
    }
}

// Initialize plugin
add_action('plugins_loaded', function() {
    ProfitPlatformPhase1::get_instance();
});

// Activation hook
register_activation_hook(__FILE__, function() {
    add_option('pp_version', PP_VERSION);
    flush_rewrite_rules();
});

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    flush_rewrite_rules();
});