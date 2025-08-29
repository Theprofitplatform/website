<?php
/**
 * Kadence Child Theme Functions
 * The Profit Platform - Phase 1 Integration
 * 
 * Add this code to your Kadence child theme's functions.php file
 * or create a new child theme using this as the base
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent and child theme styles
 */
function profit_platform_kadence_styles() {
    // Parent theme styles
    wp_enqueue_style(
        'kadence-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->get('Version')
    );
    
    // Child theme styles
    wp_enqueue_style(
        'profit-platform-kadence-child',
        get_stylesheet_uri(),
        array('kadence-style'),
        wp_get_theme()->get('Version')
    );
    
    // Custom Profit Platform styles
    wp_enqueue_style(
        'profit-platform-custom',
        get_stylesheet_directory_uri() . '/assets/profit-platform.css',
        array('profit-platform-kadence-child'),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'profit_platform_kadence_styles');

/**
 * Add custom color palette for Kadence blocks
 */
function profit_platform_kadence_colors() {
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Profit Primary', 'profit-platform'),
            'slug'  => 'profit-primary',
            'color' => '#2c86f9',
        ),
        array(
            'name'  => __('Profit Primary Dark', 'profit-platform'),
            'slug'  => 'profit-primary-dark',
            'color' => '#1e6ee8',
        ),
        array(
            'name'  => __('Profit Success', 'profit-platform'),
            'slug'  => 'profit-success',
            'color' => '#10b981',
        ),
        array(
            'name'  => __('Profit Warning', 'profit-platform'),
            'slug'  => 'profit-warning',
            'color' => '#f59e0b',
        ),
        array(
            'name'  => __('Sydney Sky', 'profit-platform'),
            'slug'  => 'sydney-sky',
            'color' => '#667eea',
        ),
        array(
            'name'  => __('Sydney Sunset', 'profit-platform'),
            'slug'  => 'sydney-sunset',
            'color' => '#764ba2',
        ),
    ));
}
add_action('after_setup_theme', 'profit_platform_kadence_colors');

/**
 * Custom Kadence header modifications
 */
function profit_platform_kadence_header() {
    // Add phone number to header
    add_action('kadence_header_row_center', function() {
        echo '<div class="pp-header-phone">';
        echo '<a href="tel:0487286451" class="pp-phone-link">';
        echo '<i class="fas fa-phone"></i> 0487 286 451';
        echo '</a>';
        echo '</div>';
    }, 15);
    
    // Add CTA button to header
    add_action('kadence_header_row_right', function() {
        echo '<div class="pp-header-cta">';
        echo '<a href="#contact" class="pp-header-button">Get Free Audit</a>';
        echo '</div>';
    }, 20);
}
add_action('init', 'profit_platform_kadence_header');

/**
 * Custom Kadence footer modifications
 */
function profit_platform_kadence_footer() {
    // Add trust badges to footer
    add_action('kadence_footer_row_top', function() {
        ?>
        <div class="pp-footer-trust">
            <div class="pp-trust-item">
                <i class="fas fa-shield-alt"></i>
                <span>100% Australian Owned</span>
            </div>
            <div class="pp-trust-item">
                <i class="fas fa-lock"></i>
                <span>Secure & Reliable</span>
            </div>
            <div class="pp-trust-item">
                <i class="fas fa-headset"></i>
                <span>24/7 Support</span>
            </div>
        </div>
        <?php
    }, 5);
}
add_action('init', 'profit_platform_kadence_footer');

/**
 * Add custom Kadence block patterns
 */
function profit_platform_register_block_patterns() {
    // Hero Section Pattern
    register_block_pattern(
        'profit-platform/hero-section',
        array(
            'title'       => __('Profit Platform Hero', 'profit-platform'),
            'description' => __('Hero section with gradient background and CTA buttons', 'profit-platform'),
            'categories'  => array('featured', 'kadence'),
            'content'     => '<!-- wp:kadence/rowlayout {"uniqueID":"_2d3f4a","columns":1,"colLayout":"equal","bgColor":"","bgImg":"","bgImgSize":"cover","bgImgPosition":"center center","bgImgRepeat":"no-repeat","verticalAlignment":"middle","overlayOpacity":30,"overlayGradient":"linear-gradient(135deg,#667eea 0%,#764ba2 100%)","textColor":"#ffffff","paddingTop":120,"paddingBottom":120,"align":"full"} -->
            <div class="wp-block-kadence-rowlayout alignfull">
                <div class="kt-row-layout-inner">
                    <div class="kt-row-column">
                        <!-- wp:kadence/advancedheading {"uniqueID":"_8b9c2d","align":"center","color":"#ffffff","size":48,"lineHeight":1.2,"typography":"heading","fontWeight":"800"} -->
                        <h1 class="wp-block-kadence-advancedheading">Get 3x More Local Customers in Sydney</h1>
                        <!-- /wp:kadence/advancedheading -->
                        
                        <!-- wp:paragraph {"align":"center","textColor":"white","fontSize":"large"} -->
                        <p class="has-text-align-center has-white-color has-large-font-size">Stop losing customers to competitors. Dominate Google with proven digital marketing.</p>
                        <!-- /wp:paragraph -->
                        
                        <!-- wp:kadence/advancedbtn {"uniqueID":"_5f7a9e","btns":[{"text":"Get Free Audit","link":"#contact","target":"_self","size":"large","bgColor":"#ffffff","color":"#2c86f9"},{"text":"Call Now","link":"tel:0487286451","target":"_self","size":"large","bgColor":"transparent","color":"#ffffff","borderColor":"#ffffff","borderWidth":2}]} -->
                        <div class="wp-block-kadence-advancedbtn"></div>
                        <!-- /wp:kadence/advancedbtn -->
                    </div>
                </div>
            </div>
            <!-- /wp:kadence/rowlayout -->',
        )
    );

    // Services Grid Pattern
    register_block_pattern(
        'profit-platform/services-grid',
        array(
            'title'       => __('Profit Platform Services', 'profit-platform'),
            'description' => __('Three-column services grid with icons', 'profit-platform'),
            'categories'  => array('columns', 'kadence'),
            'content'     => '<!-- wp:kadence/rowlayout {"uniqueID":"_3e4f5b","columns":3,"colLayout":"equal"} -->
            <div class="wp-block-kadence-rowlayout">
                <div class="kt-row-layout-inner">
                    <!-- Service 1 -->
                    <div class="kt-row-column">
                        <!-- wp:kadence/iconlist {"uniqueID":"_7c8d9e","icons":[{"icon":"fe_monitor","size":48,"color":"#2c86f9"}]} /-->
                        <!-- wp:kadence/advancedheading {"uniqueID":"_1a2b3c","size":24,"color":"#1e293b"} -->
                        <h3>Web Design</h3>
                        <!-- /wp:kadence/advancedheading -->
                        <!-- wp:paragraph -->
                        <p>Fast, mobile-first websites that convert visitors into customers.</p>
                        <!-- /wp:paragraph -->
                    </div>
                    
                    <!-- Service 2 -->
                    <div class="kt-row-column">
                        <!-- wp:kadence/iconlist {"uniqueID":"_4d5e6f","icons":[{"icon":"fe_search","size":48,"color":"#2c86f9"}]} /-->
                        <!-- wp:kadence/advancedheading {"uniqueID":"_2b3c4d","size":24,"color":"#1e293b"} -->
                        <h3>SEO Services</h3>
                        <!-- /wp:kadence/advancedheading -->
                        <!-- wp:paragraph -->
                        <p>Dominate Google search results and map pack listings.</p>
                        <!-- /wp:paragraph -->
                    </div>
                    
                    <!-- Service 3 -->
                    <div class="kt-row-column">
                        <!-- wp:kadence/iconlist {"uniqueID":"_5e6f7g","icons":[{"icon":"fe_target","size":48,"color":"#2c86f9"}]} /-->
                        <!-- wp:kadence/advancedheading {"uniqueID":"_3c4d5e","size":24,"color":"#1e293b"} -->
                        <h3>Google Ads</h3>
                        <!-- /wp:kadence/advancedheading -->
                        <!-- wp:paragraph -->
                        <p>Instant visibility with targeted advertising campaigns.</p>
                        <!-- /wp:paragraph -->
                    </div>
                </div>
            </div>
            <!-- /wp:kadence/rowlayout -->',
        )
    );

    // CTA Section Pattern
    register_block_pattern(
        'profit-platform/cta-section',
        array(
            'title'       => __('Profit Platform CTA', 'profit-platform'),
            'description' => __('Call-to-action section with gradient background', 'profit-platform'),
            'categories'  => array('call-to-action', 'kadence'),
            'content'     => '<!-- wp:kadence/rowlayout {"uniqueID":"_6f7g8h","align":"full","bgGradient":"linear-gradient(135deg,#2c86f9 0%,#1e6ee8 100%)","paddingTop":80,"paddingBottom":80} -->
            <div class="wp-block-kadence-rowlayout alignfull">
                <div class="kt-row-layout-inner">
                    <div class="kt-row-column">
                        <!-- wp:kadence/advancedheading {"uniqueID":"_9h8g7f","align":"center","color":"#ffffff","size":36} -->
                        <h2 class="has-text-align-center">Ready to Dominate Your Market?</h2>
                        <!-- /wp:kadence/advancedheading -->
                        
                        <!-- wp:paragraph {"align":"center","textColor":"white"} -->
                        <p class="has-text-align-center has-white-color">Join 247+ successful Sydney businesses. Get your free growth audit today.</p>
                        <!-- /wp:paragraph -->
                        
                        <!-- wp:kadence/advancedbtn {"uniqueID":"_8g7f6e","align":"center","btns":[{"text":"Get Your Free Audit","link":"#contact","size":"large","bgColor":"#ffffff","color":"#2c86f9"}]} /-->
                    </div>
                </div>
            </div>
            <!-- /wp:kadence/rowlayout -->',
        )
    );
}
add_action('init', 'profit_platform_register_block_patterns');

/**
 * Add custom CSS for Profit Platform elements
 */
function profit_platform_kadence_custom_css() {
    ?>
    <style>
        /* Header Phone */
        .pp-header-phone {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .pp-phone-link {
            color: #2c86f9;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .pp-phone-link:hover {
            color: #1e6ee8;
        }
        
        /* Header CTA Button */
        .pp-header-button {
            background: linear-gradient(135deg, #2c86f9, #1e6ee8);
            color: white !important;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .pp-header-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(44, 134, 249, 0.3);
        }
        
        /* Footer Trust Badges */
        .pp-footer-trust {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .pp-trust-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .pp-trust-item i {
            color: #2c86f9;
            font-size: 1.2rem;
        }
        
        /* Kadence Block Enhancements */
        .kt-row-layout-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Button hover effects */
        .wp-block-kadence-advancedbtn .kt-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .pp-footer-trust {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .pp-header-phone {
                display: none;
            }
        }
    </style>
    <?php
}
add_action('wp_head', 'profit_platform_kadence_custom_css');

/**
 * Add Schema.org markup for local business
 */
function profit_platform_schema_markup() {
    if (is_front_page()) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "The Profit Platform",
            "description": "Sydney's leading digital marketing agency specializing in SEO, Google Ads, and web design for local businesses.",
            "url": "<?php echo home_url(); ?>",
            "telephone": "+61487286451",
            "email": "avi@theprofitplatform.com.au",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Sydney",
                "addressRegion": "NSW",
                "addressCountry": "AU"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": -33.8688,
                "longitude": 151.2093
            },
            "openingHours": "Mo-Fr 09:00-18:00",
            "priceRange": "$$",
            "image": "<?php echo get_stylesheet_directory_uri(); ?>/assets/logo.png"
        }
        </script>
        <?php
    }
}
add_action('wp_head', 'profit_platform_schema_markup');

/**
 * Optimize Kadence theme for performance
 */
function profit_platform_optimize_kadence() {
    // Remove unnecessary scripts on non-essential pages
    if (!is_front_page() && !is_page()) {
        wp_dequeue_script('kadence-navigation');
        wp_dequeue_style('kadence-global');
    }
    
    // Preload critical fonts
    add_action('wp_head', function() {
        echo '<link rel="preload" href="' . get_template_directory_uri() . '/assets/fonts/inter-v12-latin-700.woff2" as="font" type="font/woff2" crossorigin>';
        echo '<link rel="preload" href="' . get_template_directory_uri() . '/assets/fonts/inter-v12-latin-regular.woff2" as="font" type="font/woff2" crossorigin>';
    }, 1);
    
    // Add DNS prefetch for external resources
    add_action('wp_head', function() {
        echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
        echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">';
    }, 1);
}
add_action('wp_enqueue_scripts', 'profit_platform_optimize_kadence', 100);

/**
 * Custom Kadence mobile menu
 */
function profit_platform_mobile_menu() {
    add_filter('kadence_mobile_menu_args', function($args) {
        $args['menu_class'] .= ' pp-mobile-menu';
        return $args;
    });
}
add_action('init', 'profit_platform_mobile_menu');

/**
 * Integration with Rank Math SEO
 */
function profit_platform_rankmath_integration() {
    // Add custom SEO score to Kadence page headers
    if (function_exists('rank_math')) {
        add_action('kadence_single_before_entry_header', function() {
            $score = get_post_meta(get_the_ID(), 'rank_math_seo_score', true);
            if ($score && current_user_can('edit_posts')) {
                echo '<div class="pp-seo-score" style="background: #10b981; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem; margin-bottom: 10px;">';
                echo 'SEO Score: ' . $score . '/100';
                echo '</div>';
            }
        });
    }
}
add_action('init', 'profit_platform_rankmath_integration');

/**
 * Custom widget areas for Kadence
 */
function profit_platform_kadence_widgets() {
    register_sidebar(array(
        'name'          => __('Profit Platform CTA Widget', 'profit-platform'),
        'id'            => 'profit-platform-cta',
        'description'   => __('Widget area for call-to-action sections', 'profit-platform'),
        'before_widget' => '<div class="pp-widget-cta">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="pp-widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'profit_platform_kadence_widgets');

/**
 * Add custom body classes
 */
function profit_platform_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'profit-platform-home';
    }
    
    if (class_exists('RankMath')) {
        $classes[] = 'rankmath-active';
    }
    
    return $classes;
}
add_filter('body_class', 'profit_platform_body_classes');

// End of Kadence child theme functions