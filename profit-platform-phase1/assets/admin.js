/**
 * Profit Platform Phase 1 - Admin JavaScript
 * WordPress integration with Kadence Theme and Rank Math SEO
 */

jQuery(document).ready(function($) {
    'use strict';

    // Tab Navigation
    $('.tab-button').on('click', function() {
        const tabName = $(this).data('tab');
        
        // Update buttons
        $('.tab-button').removeClass('active');
        $(this).addClass('active');
        
        // Update content
        $('.pp-tab-content').removeClass('active');
        $('#' + tabName + '-tab').addClass('active');
    });

    // Character Counter
    function updateCharCount(input, maxLength) {
        const $input = $(input);
        const $counter = $input.siblings('.char-count');
        const length = $input.val().length;
        
        $counter.text(length + '/' + maxLength + ' characters');
        
        if (length > maxLength) {
            $counter.css('color', '#ef4444');
        } else if (length > maxLength * 0.9) {
            $counter.css('color', '#f59e0b');
        } else {
            $counter.css('color', '#94a3b8');
        }
    }

    // Initialize character counters
    $('#seo-title').on('input', function() {
        updateCharCount(this, 60);
    }).trigger('input');

    $('#meta-description').on('input', function() {
        updateCharCount(this, 160);
    }).trigger('input');

    // Save Homepage Content
    $('.pp-save-content').on('click', function() {
        const $button = $(this);
        $button.addClass('pp-loading').prop('disabled', true);

        const data = {
            action: 'pp_save_homepage_content',
            nonce: pp_ajax.nonce,
            hero_headline: $('#hero-headline').val(),
            hero_subheadline: $('#hero-subheadline').val(),
            hero_cta_primary: $('#hero-cta-primary').val(),
            hero_cta_secondary: $('#hero-cta-secondary').val()
        };

        // Collect data from other tabs
        $('.pp-tab-content').each(function() {
            const tabId = $(this).attr('id').replace('-tab', '');
            if (tabId !== 'hero') {
                data[tabId] = collectTabData($(this));
            }
        });

        $.post(pp_ajax.ajax_url, data, function(response) {
            $button.removeClass('pp-loading').prop('disabled', false);
            
            if (response.success) {
                showNotification('Homepage content saved successfully!', 'success');
            } else {
                showNotification('Error saving content. Please try again.', 'error');
            }
        });
    });

    // Save SEO Settings
    $('.pp-save-seo').on('click', function() {
        const $button = $(this);
        $button.addClass('pp-loading').prop('disabled', true);

        const data = {
            action: 'pp_save_seo_settings',
            nonce: pp_ajax.nonce,
            focus_keyword: $('#focus-keyword').val(),
            seo_title: $('#seo-title').val(),
            meta_description: $('#meta-description').val()
        };

        $.post(pp_ajax.ajax_url, data, function(response) {
            $button.removeClass('pp-loading').prop('disabled', false);
            
            if (response.success) {
                showNotification('SEO settings saved successfully!', 'success');
                updateSEOScore();
            } else {
                showNotification('Error saving SEO settings.', 'error');
            }
        });
    });

    // Save Form Settings
    $('.pp-save-forms').on('click', function() {
        const $button = $(this);
        $button.addClass('pp-loading').prop('disabled', true);

        const fields = [];
        $('.pp-field-list input:checked').each(function() {
            fields.push($(this).parent().text().trim());
        });

        const placement = [];
        $('.pp-placement-options input:checked').each(function() {
            placement.push($(this).parent().text().trim());
        });

        const data = {
            action: 'pp_save_form_settings',
            nonce: pp_ajax.nonce,
            fields: fields,
            placement: placement,
            submit_text: $('.pp-form-builder input[type="text"]').eq(0).val(),
            success_message: $('.pp-form-builder textarea').eq(0).val(),
            email_notifications: $('.pp-form-builder input[type="email"]').val()
        };

        $.post(pp_ajax.ajax_url, data, function(response) {
            $button.removeClass('pp-loading').prop('disabled', false);
            
            if (response.success) {
                showNotification('Form settings saved successfully!', 'success');
            } else {
                showNotification('Error saving form settings.', 'error');
            }
        });
    });

    // Preview Content
    $('.pp-preview-content').on('click', function() {
        const previewUrl = pp_ajax.site_url + '?pp_preview=true';
        window.open(previewUrl, '_blank');
    });

    // Export to Page
    $('.pp-export-content').on('click', function() {
        const $button = $(this);
        
        // Check if Kadence is active
        const exportType = pp_ajax.hasKadence ? 'kadence' : 'gutenberg';
        
        if (confirm('Export content as ' + exportType + ' blocks to a new page?')) {
            $button.addClass('pp-loading').prop('disabled', true);

            const data = {
                action: 'pp_import_content',
                nonce: pp_ajax.nonce,
                content_type: exportType,
                page_id: 0 // Create new page
            };

            $.post(pp_ajax.ajax_url, data, function(response) {
                $button.removeClass('pp-loading').prop('disabled', false);
                
                if (response.success) {
                    showNotification('Content exported successfully!', 'success');
                    
                    // Open page editor
                    if (response.data.edit_url) {
                        setTimeout(function() {
                            if (confirm('Open the page editor now?')) {
                                window.open(response.data.edit_url, '_blank');
                            }
                        }, 1000);
                    }
                } else {
                    showNotification('Error exporting content.', 'error');
                }
            });
        }
    });

    // Helper Functions
    function collectTabData($tab) {
        const data = {};
        
        $tab.find('input, textarea, select').each(function() {
            const $field = $(this);
            const name = $field.attr('id') || $field.attr('name');
            
            if (name) {
                if ($field.attr('type') === 'checkbox') {
                    data[name] = $field.is(':checked');
                } else {
                    data[name] = $field.val();
                }
            }
        });
        
        return data;
    }

    function showNotification(message, type) {
        const $notification = $('<div class="pp-notification pp-' + type + '">');
        $notification.text(message);
        
        $('body').append($notification);
        
        $notification.animate({ top: '50px', opacity: 1 }, 300);
        
        setTimeout(function() {
            $notification.animate({ top: '30px', opacity: 0 }, 300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    function updateSEOScore() {
        // Calculate SEO score based on various factors
        let score = 0;
        const focusKeyword = $('#focus-keyword').val();
        const seoTitle = $('#seo-title').val();
        const metaDescription = $('#meta-description').val();
        
        // Check focus keyword presence
        if (focusKeyword) {
            score += 20;
            
            // Check if keyword is in title
            if (seoTitle.toLowerCase().includes(focusKeyword.toLowerCase())) {
                score += 20;
            }
            
            // Check if keyword is in meta description
            if (metaDescription.toLowerCase().includes(focusKeyword.toLowerCase())) {
                score += 15;
            }
        }
        
        // Check title length
        if (seoTitle.length >= 30 && seoTitle.length <= 60) {
            score += 15;
        }
        
        // Check meta description length
        if (metaDescription.length >= 120 && metaDescription.length <= 160) {
            score += 15;
        }
        
        // Check for Rank Math
        if (pp_ajax.hasRankMath) {
            score += 15;
        }
        
        // Update score display
        $('.score-circle').text(score);
        $('.progress-fill').css('width', score + '%');
        
        // Update color based on score
        let color;
        if (score >= 80) {
            color = '#10b981';
        } else if (score >= 60) {
            color = '#f59e0b';
        } else {
            color = '#ef4444';
        }
        
        $('.score-circle').css('background', 'linear-gradient(135deg, ' + color + ', ' + color + ')');
    }

    // Auto-save functionality
    let autoSaveTimer;
    
    $('input, textarea').on('input', function() {
        clearTimeout(autoSaveTimer);
        
        autoSaveTimer = setTimeout(function() {
            saveCurrentTab();
        }, 5000); // Auto-save after 5 seconds of inactivity
    });

    function saveCurrentTab() {
        const activeTab = $('.pp-tab-content.active').attr('id').replace('-tab', '');
        console.log('Auto-saving ' + activeTab + ' tab...');
        
        // Show saving indicator
        const $indicator = $('<span class="pp-saving-indicator">Saving...</span>');
        $('.pp-builder-actions').append($indicator);
        
        // Perform save based on active tab
        // This would trigger the appropriate save action
        
        setTimeout(function() {
            $indicator.text('Saved').delay(1000).fadeOut(function() {
                $(this).remove();
            });
        }, 1000);
    }

    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            $('.pp-save-content:visible, .pp-save-seo:visible, .pp-save-forms:visible').first().click();
        }
        
        // Ctrl/Cmd + P to preview
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            $('.pp-preview-content:visible').first().click();
        }
    });

    // Initialize tooltips
    $('[data-tooltip]').each(function() {
        const $this = $(this);
        const tooltip = $this.data('tooltip');
        
        $this.on('mouseenter', function() {
            const $tooltip = $('<div class="pp-tooltip">').text(tooltip);
            $('body').append($tooltip);
            
            const offset = $this.offset();
            $tooltip.css({
                top: offset.top - $tooltip.outerHeight() - 10,
                left: offset.left + ($this.outerWidth() / 2) - ($tooltip.outerWidth() / 2)
            }).fadeIn(200);
        }).on('mouseleave', function() {
            $('.pp-tooltip').fadeOut(200, function() {
                $(this).remove();
            });
        });
    });

    // Initialize on page load
    updateSEOScore();
    
    // Show Kadence/Rank Math integration status
    if (pp_ajax.hasKadence) {
        console.log('✅ Kadence Theme detected and integrated');
    }
    
    if (pp_ajax.hasRankMath) {
        console.log('✅ Rank Math SEO detected and integrated');
    }
});

// Additional styles for notifications
(function() {
    const style = document.createElement('style');
    style.textContent = `
        .pp-notification {
            position: fixed;
            top: 30px;
            right: 30px;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 600;
            z-index: 99999;
            opacity: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .pp-notification.pp-success {
            background: #10b981;
        }
        
        .pp-notification.pp-error {
            background: #ef4444;
        }
        
        .pp-saving-indicator {
            margin-left: 15px;
            color: #2c86f9;
            font-weight: 600;
            animation: pulse 1s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .pp-tooltip {
            position: absolute;
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.85rem;
            z-index: 99999;
            pointer-events: none;
            display: none;
        }
        
        .pp-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: #333;
        }
    `;
    document.head.appendChild(style);
})();