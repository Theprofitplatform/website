/**
 * The Profit Platform - Custom JavaScript
 * Enhanced functionality for the digital marketing agency website
 * 
 * @package Kadence_PP_Child
 * @version 1.0.0
 */

(function($) {
    'use strict';

    // Wait for DOM to be ready
    $(document).ready(function() {
        // Initialize all functionality
        initScrollAnimations();
        initTestimonialSlider();
        initFAQAccordion();
        initContactForm();
        initSmoothScrolling();
        initHeaderScrollEffect();
        initCounterAnimations();
        initServiceCards();
        
        console.log('The Profit Platform - Custom JS Loaded');
    });

    /**
     * Initialize scroll-based animations
     */
    function initScrollAnimations() {
        // Intersection Observer for scroll animations
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.3,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        
                        // Trigger counter animations for result cards
                        if (entry.target.classList.contains('result-card')) {
                            animateCounter(entry.target);
                        }
                    }
                });
            }, observerOptions);

            // Observe all animated elements
            $('.animate-on-scroll').each(function() {
                observer.observe(this);
            });
        } else {
            // Fallback for browsers without Intersection Observer
            $('.animate-on-scroll').addClass('visible');
        }
    }

    /**
     * Initialize testimonial slider functionality
     */
    function initTestimonialSlider() {
        const $testimonials = $('.testimonial-card');
        
        if ($testimonials.length > 0) {
            // Add hover effects
            $testimonials.on('mouseenter', function() {
                $(this).addClass('hovered');
            }).on('mouseleave', function() {
                $(this).removeClass('hovered');
            });

            // Auto-rotate testimonials if there are more than 3
            if ($testimonials.length > 3) {
                let currentIndex = 0;
                
                setInterval(function() {
                    $testimonials.removeClass('featured');
                    $testimonials.eq(currentIndex).addClass('featured');
                    currentIndex = (currentIndex + 1) % $testimonials.length;
                }, 5000);
            }
        }
    }

    /**
     * Initialize FAQ accordion functionality
     */
    function initFAQAccordion() {
        $('.faq-question').on('click', function(e) {
            e.preventDefault();
            
            const $question = $(this);
            const $answer = $question.next('.faq-answer');
            const $faqItem = $question.closest('.faq-item');
            
            // Check if this item is already active
            const isActive = $question.hasClass('active');
            
            // Close all other FAQ items
            $('.faq-question').removeClass('active');
            $('.faq-answer').removeClass('active');
            $('.faq-item').removeClass('expanded');
            
            // Toggle current item
            if (!isActive) {
                $question.addClass('active');
                $answer.addClass('active');
                $faqItem.addClass('expanded');
                
                // Smooth scroll to question after animation
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $question.offset().top - 100
                    }, 500);
                }, 300);
            }
        });

        // FAQ search functionality
        $('#faq-search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase().trim();
            
            $('.faq-item').each(function() {
                const $item = $(this);
                const question = $item.find('.faq-question').text().toLowerCase();
                const answer = $item.find('.faq-answer').text().toLowerCase();
                
                if (searchTerm === '' || question.includes(searchTerm) || answer.includes(searchTerm)) {
                    $item.show();
                } else {
                    $item.hide();
                }
            });
        });
    }

    /**
     * Initialize contact form enhancements
     */
    function initContactForm() {
        // Enhanced form validation
        $('.contact-form').on('submit', function(e) {
            const $form = $(this);
            let isValid = true;
            
            // Clear previous errors
            $form.find('.error').removeClass('error');
            $form.find('.error-message').remove();
            
            // Validate required fields
            $form.find('input[required], textarea[required], select[required]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (value === '') {
                    isValid = false;
                    $field.addClass('error');
                    $field.after('<div class="error-message">This field is required</div>');
                }
            });
            
            // Validate email format
            const $email = $form.find('input[type="email"]');
            if ($email.length && $email.val().trim() !== '') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test($email.val().trim())) {
                    isValid = false;
                    $email.addClass('error');
                    $email.after('<div class="error-message">Please enter a valid email address</div>');
                }
            }
            
            // Validate phone number (Australian format)
            const $phone = $form.find('input[type="tel"]');
            if ($phone.length && $phone.val().trim() !== '') {
                const phoneRegex = /^(\+61|0)[2-478](?:[ -]?[0-9]){8}$/;
                if (!phoneRegex.test($phone.val().trim())) {
                    isValid = false;
                    $phone.addClass('error');
                    $phone.after('<div class="error-message">Please enter a valid Australian phone number</div>');
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to first error
                const $firstError = $form.find('.error').first();
                if ($firstError.length) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 100
                    }, 500);
                }
                
                return false;
            }
            
            // Show loading state
            const $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text('Sending...');
        });

        // Real-time validation feedback
        $('.contact-form input, .contact-form textarea, .contact-form select').on('blur', function() {
            const $field = $(this);
            $field.removeClass('error');
            $field.next('.error-message').remove();
            
            if ($field.attr('required') && $field.val().trim() === '') {
                $field.addClass('error');
                $field.after('<div class="error-message">This field is required</div>');
            }
        });
    }

    /**
     * Initialize smooth scrolling for anchor links
     */
    function initSmoothScrolling() {
        $('a[href^="#"]').on('click', function(e) {
            const href = $(this).attr('href');
            const $target = $(href);
            
            if ($target.length) {
                e.preventDefault();
                
                const headerHeight = $('.site-header').outerHeight() || 0;
                const targetPosition = $target.offset().top - headerHeight - 20;
                
                $('html, body').animate({
                    scrollTop: targetPosition
                }, 800);
            }
        });
    }

    /**
     * Initialize header scroll effects
     */
    function initHeaderScrollEffect() {
        const $header = $('.site-header');
        let lastScrollTop = 0;
        
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            if (scrollTop > 50) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }
            
            // Hide/show header on scroll
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                $header.addClass('hidden');
            } else {
                $header.removeClass('hidden');
            }
            
            lastScrollTop = scrollTop;
        });
    }

    /**
     * Animate counters in result cards
     */
    function animateCounter($card) {
        const $counter = $card.find('.result-number');
        const target = parseFloat($card.data('result')) || 0;
        
        if (target > 0 && $counter.length) {
            let current = 0;
            const increment = target / 50;
            const suffix = $counter.text().includes('x') ? 'x' : 
                          $counter.text().includes('%') ? '%' : '';
            const prefix = $counter.text().includes('-') ? '-' : '+';
            
            const timer = setInterval(function() {
                current += increment;
                
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                let displayValue;
                if (suffix === 'x') {
                    displayValue = current.toFixed(1) + suffix;
                } else if (suffix === '%') {
                    displayValue = prefix + Math.floor(current) + suffix;
                } else {
                    displayValue = Math.floor(current).toLocaleString();
                }
                
                $counter.text(displayValue);
            }, 50);
        }
    }

    /**
     * Initialize counter animations for visible elements
     */
    function initCounterAnimations() {
        // Animate counters for any visible result cards
        $('.result-card[data-result]').each(function() {
            const $card = $(this);
            
            // Check if card is in viewport
            if (isElementInViewport($card[0])) {
                animateCounter($card);
            }
        });
    }

    /**
     * Check if element is in viewport
     */
    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    /**
     * Initialize service card interactions
     */
    function initServiceCards() {
        $('.service-card').on('mouseenter', function() {
            $(this).addClass('hovered');
            
            // Add subtle animation to service icon
            const $icon = $(this).find('.service-icon');
            $icon.addClass('animated');
        }).on('mouseleave', function() {
            $(this).removeClass('hovered');
            
            const $icon = $(this).find('.service-icon');
            $icon.removeClass('animated');
        });
    }

    /**
     * Initialize Google Analytics tracking for The Profit Platform
     */
    function initAnalyticsTracking() {
        // Track button clicks
        $('.btn-primary, .btn-secondary, .wpcf7-submit').on('click', function() {
            const buttonText = $(this).text().trim();
            
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Button',
                    'event_label': buttonText,
                    'value': 1
                });
            }
        });

        // Track form submissions
        $('.contact-form').on('submit', function() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'form_submit', {
                    'event_category': 'Contact',
                    'event_label': 'Contact Form',
                    'value': 1
                });
            }
        });

        // Track phone number clicks
        $('a[href^="tel:"]').on('click', function() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Contact',
                    'event_label': 'Phone Call',
                    'value': 1
                });
            }
        });
    }

    /**
     * Initialize AJAX functionality for WordPress
     */
    function initAjaxFunctionality() {
        // Load more case studies or testimonials
        $('.load-more-btn').on('click', function(e) {
            e.preventDefault();
            
            const $btn = $(this);
            const postType = $btn.data('post-type') || 'post';
            const page = parseInt($btn.data('page')) || 1;
            const $container = $btn.data('container') ? $($btn.data('container')) : $('.posts-container');
            
            // Show loading state
            $btn.prop('disabled', true).text('Loading...');
            
            $.ajax({
                url: pp_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    post_type: postType,
                    page: page + 1,
                    nonce: pp_ajax.nonce
                },
                success: function(response) {
                    if (response.success && response.data.posts) {
                        $container.append(response.data.posts);
                        $btn.data('page', page + 1);
                        
                        // Re-initialize animations for new content
                        initScrollAnimations();
                        
                        if (!response.data.has_more) {
                            $btn.hide();
                        }
                    } else {
                        $btn.hide();
                    }
                },
                error: function() {
                    console.error('Error loading more posts');
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Load More');
                }
            });
        });
    }

    /**
     * Initialize mobile menu enhancements
     */
    function initMobileMenu() {
        // Enhanced mobile menu toggle
        $('.menu-toggle').on('click', function() {
            $('body').toggleClass('mobile-menu-open');
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.mobile-menu, .menu-toggle').length) {
                $('body').removeClass('mobile-menu-open');
            }
        });

        // Close mobile menu on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('body').removeClass('mobile-menu-open');
            }
        });
    }

    /**
     * Initialize performance optimizations
     */
    function initPerformanceOptimizations() {
        // Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            $('img[data-src]').each(function() {
                imageObserver.observe(this);
            });
        }

        // Preload critical resources
        const criticalResources = [
            pp_ajax.site_url + '/wp-content/themes/kadence-pp-child/assets/css/custom.css'
        ];

        criticalResources.forEach(function(resource) {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = resource;
            link.as = resource.endsWith('.css') ? 'style' : 'script';
            document.head.appendChild(link);
        });
    }

    // Initialize all enhancements
    $(window).on('load', function() {
        initAnalyticsTracking();
        initAjaxFunctionality();
        initMobileMenu();
        initPerformanceOptimizations();
    });

    // Handle window resize
    $(window).on('resize', function() {
        // Debounce resize handler
        clearTimeout(window.resizeTimer);
        window.resizeTimer = setTimeout(function() {
            // Recalculate animations if needed
            initScrollAnimations();
        }, 250);
    });

})(jQuery);

/**
 * Vanilla JavaScript for critical functionality
 * (runs without jQuery dependency)
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Critical path CSS loading
    const criticalCSS = document.createElement('link');
    criticalCSS.rel = 'stylesheet';
    criticalCSS.href = '/wp-content/themes/kadence-pp-child/assets/css/custom.css';
    criticalCSS.media = 'all';
    document.head.appendChild(criticalCSS);

    // Service worker registration for PWA functionality
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
                console.log('ServiceWorker registration successful');
            }).catch(function(err) {
                console.log('ServiceWorker registration failed');
            });
        });
    }

});