<?php
/**
 * Plugin Name: The Profit Platform - Site Enhancements
 * Plugin URI: https://theprofitplatform.com.au
 * Description: Custom functionality and enhancements for The Profit Platform website. Includes lead tracking, analytics integration, and marketing automation features.
 * Version: 1.0.1
 * Author: The Profit Platform
 * Author URI: https://theprofitplatform.com.au
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pp-site
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.4
 * Requires PHP: 8.0
 * Network: false
 * 
 * @package PP_Site
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('PP_SITE_VERSION', '1.0.0');
define('PP_SITE_PLUGIN_FILE', __FILE__);
define('PP_SITE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PP_SITE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PP_SITE_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main PP_Site class
 */
class PP_Site {
    
    /**
     * Plugin instance
     */
    private static $instance = null;
    
    /**
     * Get plugin instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->init_hooks();
    }
    
    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('wp_head', array($this, 'add_tracking_code'));
        add_action('wp_footer', array($this, 'add_footer_scripts'));
        
        // AJAX handlers
        add_action('wp_ajax_pp_track_lead', array($this, 'track_lead'));
        add_action('wp_ajax_nopriv_pp_track_lead', array($this, 'track_lead'));
        add_action('wp_ajax_pp_get_analytics', array($this, 'get_analytics'));
        
        // Admin hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        
        // Contact Form 7 integration
        add_action('wpcf7_before_send_mail', array($this, 'track_contact_form_submission'));
        
        // REST API endpoints
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Load text domain
        load_plugin_textdomain('pp-site', false, dirname(PP_SITE_PLUGIN_BASENAME) . '/languages');
        
        // Initialize features
        $this->init_database_tables();
        $this->init_cron_jobs();
    }
    
    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts() {
        // Enqueue plugin styles
        wp_enqueue_style(
            'pp-site-styles',
            PP_SITE_PLUGIN_URL . 'assets/tweaks.css',
            array(),
            PP_SITE_VERSION
        );
        
        // Enqueue tracking script
        wp_enqueue_script(
            'pp-site-tracking',
            PP_SITE_PLUGIN_URL . 'assets/js/tracking.js',
            array('jquery'),
            PP_SITE_VERSION,
            true
        );
        
        // Localize script
        wp_localize_script('pp-site-tracking', 'pp_site', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pp_site_nonce'),
            'site_url' => home_url(),
            'tracking_enabled' => get_option('pp_site_tracking_enabled', 1),
        ));
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function admin_enqueue_scripts($hook) {
        // Only load on plugin pages
        if (strpos($hook, 'pp-site') === false) {
            return;
        }
        
        wp_enqueue_script(
            'pp-site-admin',
            PP_SITE_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'wp-color-picker'),
            PP_SITE_VERSION,
            true
        );
        
        wp_enqueue_style('wp-color-picker');
        
        wp_localize_script('pp-site-admin', 'pp_site_admin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pp_site_admin_nonce'),
        ));
    }
    
    /**
     * Add tracking code to head
     */
    public function add_tracking_code() {
        if (!get_option('pp_site_tracking_enabled', 1)) {
            return;
        }
        
        $google_analytics_id = get_option('pp_site_google_analytics_id');
        $facebook_pixel_id = get_option('pp_site_facebook_pixel_id');
        
        // Google Analytics 4
        if ($google_analytics_id) {
            ?>
            <!-- Google Analytics 4 - The Profit Platform -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($google_analytics_id); ?>"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '<?php echo esc_js($google_analytics_id); ?>', {
                    'custom_map': {
                        'custom_parameter_1': 'lead_source',
                        'custom_parameter_2': 'lead_type'
                    }
                });
            </script>
            <?php
        }
        
        // Facebook Pixel
        if ($facebook_pixel_id) {
            ?>
            <!-- Facebook Pixel - The Profit Platform -->
            <script>
                !function(f,b,e,v,n,t,s)
                {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '<?php echo esc_js($facebook_pixel_id); ?>');
                fbq('track', 'PageView');
            </script>
            <noscript>
                <img height="1" width="1" style="display:none"
                     src="https://www.facebook.com/tr?id=<?php echo esc_attr($facebook_pixel_id); ?>&ev=PageView&noscript=1" />
            </noscript>
            <?php
        }
    }
    
    /**
     * Add footer scripts
     */
    public function add_footer_scripts() {
        if (!get_option('pp_site_tracking_enabled', 1)) {
            return;
        }
        
        ?>
        <script>
            // The Profit Platform - Lead Tracking
            jQuery(document).ready(function($) {
                // Track phone number clicks
                $('a[href^="tel:"]').on('click', function() {
                    var phoneNumber = $(this).attr('href').replace('tel:', '');
                    ppTrackLead('phone_call', {
                        phone_number: phoneNumber,
                        source: window.location.pathname
                    });
                });
                
                // Track email clicks
                $('a[href^="mailto:"]').on('click', function() {
                    var email = $(this).attr('href').replace('mailto:', '');
                    ppTrackLead('email_click', {
                        email: email,
                        source: window.location.pathname
                    });
                });
                
                // Track button clicks
                $('.btn-primary, .btn-secondary, .cta-button').on('click', function() {
                    var buttonText = $(this).text().trim();
                    var buttonHref = $(this).attr('href') || '';
                    
                    ppTrackLead('button_click', {
                        button_text: buttonText,
                        button_href: buttonHref,
                        source: window.location.pathname
                    });
                });
            });
            
            // Lead tracking function
            function ppTrackLead(action, data) {
                if (typeof pp_site === 'undefined') return;
                
                $.ajax({
                    url: pp_site.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'pp_track_lead',
                        lead_action: action,
                        lead_data: JSON.stringify(data),
                        nonce: pp_site.nonce,
                        url: window.location.href,
                        referrer: document.referrer,
                        user_agent: navigator.userAgent
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Lead tracked successfully');
                            
                            // Fire Google Analytics event
                            if (typeof gtag !== 'undefined') {
                                gtag('event', action, {
                                    'event_category': 'Lead',
                                    'event_label': data.source || 'unknown',
                                    'value': 1
                                });
                            }
                            
                            // Fire Facebook Pixel event
                            if (typeof fbq !== 'undefined') {
                                fbq('track', 'Lead', {
                                    content_name: action,
                                    content_category: 'Lead Generation'
                                });
                            }
                        }
                    }
                });
            }
        </script>
        <?php
    }
    
    /**
     * Track lead via AJAX
     */
    public function track_lead() {
        check_ajax_referer('pp_site_nonce', 'nonce');
        
        $lead_action = sanitize_text_field($_POST['lead_action']);
        $lead_data = json_decode(stripslashes($_POST['lead_data']), true);
        $url = esc_url_raw($_POST['url']);
        $referrer = esc_url_raw($_POST['referrer']);
        $user_agent = sanitize_text_field($_POST['user_agent']);
        
        global $wpdb;
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'pp_leads',
            array(
                'action' => $lead_action,
                'data' => wp_json_encode($lead_data),
                'url' => $url,
                'referrer' => $referrer,
                'user_agent' => $user_agent,
                'ip_address' => $this->get_client_ip(),
                'created_at' => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        if ($result) {
            wp_send_json_success(array('message' => 'Lead tracked successfully'));
        } else {
            wp_send_json_error(array('message' => 'Failed to track lead'));
        }
    }
    
    /**
     * Track Contact Form 7 submissions
     */
    public function track_contact_form_submission($contact_form) {
        $submission = WPCF7_Submission::get_instance();
        
        if (!$submission) {
            return;
        }
        
        $posted_data = $submission->get_posted_data();
        
        // Extract common fields
        $lead_data = array(
            'form_id' => $contact_form->id(),
            'form_title' => $contact_form->title(),
            'name' => isset($posted_data['your-name']) ? $posted_data['your-name'] : '',
            'email' => isset($posted_data['your-email']) ? $posted_data['your-email'] : '',
            'phone' => isset($posted_data['your-phone']) ? $posted_data['your-phone'] : '',
            'message' => isset($posted_data['your-message']) ? $posted_data['your-message'] : '',
        );
        
        global $wpdb;
        
        $wpdb->insert(
            $wpdb->prefix . 'pp_leads',
            array(
                'action' => 'form_submission',
                'data' => wp_json_encode($lead_data),
                'url' => home_url($_SERVER['REQUEST_URI']),
                'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
                'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
                'ip_address' => $this->get_client_ip(),
                'created_at' => current_time('mysql')
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
    }
    
    /**
     * Get client IP address
     */
    private function get_client_ip() {
        $ip_fields = array(
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        );
        
        foreach ($ip_fields as $field) {
            if (!empty($_SERVER[$field])) {
                $ip = $_SERVER[$field];
                if (strpos($ip, ',') !== false) {
                    $ip = explode(',', $ip);
                    $ip = trim($ip[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'PP Site Settings',
            'PP Site',
            'manage_options',
            'pp-site',
            array($this, 'admin_page'),
            'dashicons-chart-line',
            30
        );
        
        add_submenu_page(
            'pp-site',
            'Settings',
            'Settings',
            'manage_options',
            'pp-site',
            array($this, 'admin_page')
        );
        
        add_submenu_page(
            'pp-site',
            'Lead Analytics',
            'Lead Analytics',
            'manage_options',
            'pp-site-analytics',
            array($this, 'analytics_page')
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('pp_site_settings', 'pp_site_tracking_enabled');
        register_setting('pp_site_settings', 'pp_site_google_analytics_id');
        register_setting('pp_site_settings', 'pp_site_facebook_pixel_id');
        register_setting('pp_site_settings', 'pp_site_lead_notifications_enabled');
        register_setting('pp_site_settings', 'pp_site_notification_email');
    }
    
    /**
     * Admin page
     */
    public function admin_page() {
        if (isset($_POST['submit'])) {
            update_option('pp_site_tracking_enabled', isset($_POST['pp_site_tracking_enabled']) ? 1 : 0);
            update_option('pp_site_google_analytics_id', sanitize_text_field($_POST['pp_site_google_analytics_id']));
            update_option('pp_site_facebook_pixel_id', sanitize_text_field($_POST['pp_site_facebook_pixel_id']));
            update_option('pp_site_lead_notifications_enabled', isset($_POST['pp_site_lead_notifications_enabled']) ? 1 : 0);
            update_option('pp_site_notification_email', sanitize_email($_POST['pp_site_notification_email']));
            
            echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
        }
        
        ?>
        <div class="wrap">
            <h1>The Profit Platform - Site Settings</h1>
            
            <form method="post" action="">
                <?php settings_fields('pp_site_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">Enable Tracking</th>
                        <td>
                            <input type="checkbox" name="pp_site_tracking_enabled" value="1" <?php checked(1, get_option('pp_site_tracking_enabled', 1)); ?> />
                            <label>Enable lead tracking and analytics</label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Google Analytics ID</th>
                        <td>
                            <input type="text" name="pp_site_google_analytics_id" value="<?php echo esc_attr(get_option('pp_site_google_analytics_id')); ?>" placeholder="G-XXXXXXXXXX" class="regular-text" />
                            <p class="description">Enter your Google Analytics 4 measurement ID</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Facebook Pixel ID</th>
                        <td>
                            <input type="text" name="pp_site_facebook_pixel_id" value="<?php echo esc_attr(get_option('pp_site_facebook_pixel_id')); ?>" placeholder="123456789012345" class="regular-text" />
                            <p class="description">Enter your Facebook Pixel ID</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Lead Notifications</th>
                        <td>
                            <input type="checkbox" name="pp_site_lead_notifications_enabled" value="1" <?php checked(1, get_option('pp_site_lead_notifications_enabled', 1)); ?> />
                            <label>Send email notifications for new leads</label>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">Notification Email</th>
                        <td>
                            <input type="email" name="pp_site_notification_email" value="<?php echo esc_attr(get_option('pp_site_notification_email', get_option('admin_email'))); ?>" class="regular-text" />
                            <p class="description">Email address to receive lead notifications</p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * Analytics page
     */
    public function analytics_page() {
        global $wpdb;
        
        // Get lead statistics
        $total_leads = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}pp_leads");
        $leads_today = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}pp_leads WHERE DATE(created_at) = %s",
            current_time('Y-m-d')
        ));
        $leads_this_month = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}pp_leads WHERE YEAR(created_at) = %d AND MONTH(created_at) = %d",
            current_time('Y'),
            current_time('n')
        ));
        
        // Get recent leads
        $recent_leads = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}pp_leads ORDER BY created_at DESC LIMIT 10"
        );
        
        ?>
        <div class="wrap">
            <h1>Lead Analytics Dashboard</h1>
            
            <div class="pp-analytics-stats" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 20px 0;">
                <div class="pp-stat-card" style="background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
                    <h3>Total Leads</h3>
                    <p style="font-size: 2rem; font-weight: bold; color: #2c86f9;"><?php echo number_format($total_leads); ?></p>
                </div>
                <div class="pp-stat-card" style="background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
                    <h3>Today's Leads</h3>
                    <p style="font-size: 2rem; font-weight: bold; color: #10b981;"><?php echo number_format($leads_today); ?></p>
                </div>
                <div class="pp-stat-card" style="background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
                    <h3>This Month</h3>
                    <p style="font-size: 2rem; font-weight: bold; color: #f59e0b;"><?php echo number_format($leads_this_month); ?></p>
                </div>
            </div>
            
            <div class="pp-recent-leads" style="background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px; margin-top: 20px;">
                <h2>Recent Leads</h2>
                <table class="widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Action</th>
                            <th>Data</th>
                            <th>Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($recent_leads): ?>
                            <?php foreach ($recent_leads as $lead): ?>
                                <tr>
                                    <td><?php echo esc_html(date('M j, Y H:i', strtotime($lead->created_at))); ?></td>
                                    <td><?php echo esc_html($lead->action); ?></td>
                                    <td>
                                        <?php 
                                        $data = json_decode($lead->data, true);
                                        if ($data) {
                                            foreach ($data as $key => $value) {
                                                if ($value) {
                                                    echo '<strong>' . esc_html($key) . ':</strong> ' . esc_html($value) . '<br>';
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo esc_html(parse_url($lead->url, PHP_URL_PATH)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No leads found yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    
    /**
     * Initialize database tables
     */
    private function init_database_tables() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'pp_leads';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            action varchar(100) NOT NULL,
            data longtext,
            url varchar(500),
            referrer varchar(500),
            user_agent text,
            ip_address varchar(45),
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY action (action),
            KEY created_at (created_at)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // Store the database version
        update_option('pp_site_db_version', PP_SITE_VERSION);
    }
    
    /**
     * Initialize cron jobs
     */
    private function init_cron_jobs() {
        // Daily analytics report
        if (!wp_next_scheduled('pp_site_daily_report')) {
            wp_schedule_event(time(), 'daily', 'pp_site_daily_report');
        }
        
        add_action('pp_site_daily_report', array($this, 'send_daily_report'));
    }
    
    /**
     * Send daily analytics report
     */
    public function send_daily_report() {
        if (!get_option('pp_site_lead_notifications_enabled', 1)) {
            return;
        }
        
        global $wpdb;
        
        $leads_today = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}pp_leads WHERE DATE(created_at) = %s",
            current_time('Y-m-d')
        ));
        
        if ($leads_today > 0) {
            $to = get_option('pp_site_notification_email', get_option('admin_email'));
            $subject = 'Daily Lead Report - The Profit Platform';
            $message = "You received {$leads_today} new lead(s) today.\n\n";
            $message .= "View detailed analytics: " . admin_url('admin.php?page=pp-site-analytics');
            
            wp_mail($to, $subject, $message);
        }
    }
    
    /**
     * Register REST API routes
     */
    public function register_rest_routes() {
        register_rest_route('pp-site/v1', '/analytics', array(
            'methods' => 'GET',
            'callback' => array($this, 'rest_get_analytics'),
            'permission_callback' => function() {
                return current_user_can('manage_options');
            }
        ));
    }
    
    /**
     * REST API: Get analytics data
     */
    public function rest_get_analytics($request) {
        global $wpdb;
        
        $days = intval($request->get_param('days')) ?: 30;
        
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT DATE(created_at) as date, COUNT(*) as count 
             FROM {$wpdb->prefix}pp_leads 
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL %d DAY) 
             GROUP BY DATE(created_at) 
             ORDER BY date DESC",
            $days
        ));
        
        return rest_ensure_response($results);
    }
}

// Initialize the plugin
PP_Site::get_instance();

// Activation hook
register_activation_hook(__FILE__, function() {
    // Create database tables
    $plugin = PP_Site::get_instance();
    
    // Flush rewrite rules
    flush_rewrite_rules();
});

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    // Clear scheduled events
    wp_clear_scheduled_hook('pp_site_daily_report');
});

/**
 * Helper functions for themes and other plugins
 */

/**
 * Get lead count
 */
function pp_get_lead_count($days = 30) {
    global $wpdb;
    
    return $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}pp_leads WHERE created_at >= DATE_SUB(NOW(), INTERVAL %d DAY)",
        $days
    ));
}

/**
 * Track custom lead
 */
function pp_track_custom_lead($action, $data = array()) {
    global $wpdb;
    
    $wpdb->insert(
        $wpdb->prefix . 'pp_leads',
        array(
            'action' => $action,
            'data' => wp_json_encode($data),
            'url' => home_url($_SERVER['REQUEST_URI']),
            'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'ip_address' => PP_Site::get_instance()->get_client_ip(),
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
}