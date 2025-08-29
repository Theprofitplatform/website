# 🚀 Phase 1 Deployment Guide
**The Profit Platform - WordPress Homepage Automation**

---

## 📋 Table of Contents
1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Installation Methods](#installation-methods)
3. [Configuration Steps](#configuration-steps)
4. [Testing & Verification](#testing--verification)
5. [Go-Live Process](#go-live-process)
6. [Troubleshooting](#troubleshooting)

---

## ✅ Pre-Deployment Checklist

### System Requirements
- [ ] WordPress 5.0+ installed
- [ ] PHP 7.4+ 
- [ ] MySQL 5.6+ or MariaDB 10.1+
- [ ] Minimum 256MB PHP memory limit
- [ ] HTTPS/SSL certificate active

### Required Plugins
- [ ] **Kadence Theme** (Free version minimum)
- [ ] **Rank Math SEO** (Free version minimum)
- [ ] **UpdraftPlus** (For backups - recommended)

### Files Ready
- [ ] `profit-platform-phase1-plugin.php` - Main plugin file
- [ ] `assets/admin.css` - Admin styles
- [ ] `assets/admin.js` - Admin JavaScript
- [ ] `wp-automation.html` - Standalone automation tool
- [ ] `setup-wordpress.sh` - Setup script (optional)

### Access Required
- [ ] WordPress admin credentials
- [ ] FTP/cPanel access (for manual installation)
- [ ] Database access (for troubleshooting)

---

## 🔧 Installation Methods

### Method 1: Automated Setup (Recommended)

```bash
# 1. Navigate to WordPress root directory
cd /path/to/wordpress

# 2. Download the setup script
wget https://raw.githubusercontent.com/your-repo/setup-wordpress.sh

# 3. Make it executable
chmod +x setup-wordpress.sh

# 4. Run the setup
./setup-wordpress.sh
```

### Method 2: Manual Installation via WordPress Admin

1. **Create ZIP package:**
```bash
# Create plugin directory structure
mkdir profit-platform-phase1
mkdir profit-platform-phase1/assets

# Copy files
cp profit-platform-phase1-plugin.php profit-platform-phase1/profit-platform-phase1.php
cp assets/admin.css profit-platform-phase1/assets/
cp assets/admin.js profit-platform-phase1/assets/

# Create ZIP
zip -r profit-platform-phase1.zip profit-platform-phase1/
```

2. **Upload via WordPress:**
- Go to **Plugins → Add New → Upload Plugin**
- Choose `profit-platform-phase1.zip`
- Click **Install Now**
- Click **Activate Plugin**

### Method 3: Manual FTP Installation

1. **Connect via FTP to your server**

2. **Navigate to:** `/wp-content/plugins/`

3. **Create folder:** `profit-platform-phase1`

4. **Upload files:**
```
/profit-platform-phase1/
├── profit-platform-phase1.php
└── assets/
    ├── admin.css
    └── admin.js
```

5. **Set permissions:**
```bash
chmod 755 /wp-content/plugins/profit-platform-phase1
chmod 644 /wp-content/plugins/profit-platform-phase1/*.php
chmod 755 /wp-content/plugins/profit-platform-phase1/assets
chmod 644 /wp-content/plugins/profit-platform-phase1/assets/*
```

---

## ⚙️ Configuration Steps

### Step 1: Activate the Plugin

1. Go to **WordPress Admin → Plugins**
2. Find **"Profit Platform Phase 1"**
3. Click **Activate**
4. You should see a new menu item: **"Profit Platform"**

### Step 2: Initial Setup

1. **Navigate to:** Profit Platform → Dashboard
2. **Check integration status:**
   - ✅ Kadence Theme Active
   - ✅ Rank Math SEO Active
   - ✅ Database Tables Created

### Step 3: Configure Homepage Content

1. **Go to:** Profit Platform → Homepage Builder

2. **Hero Section:**
```
Headline: Get 3x More Local Customers in Sydney
Subheadline: Stop losing customers to competitors...
Primary CTA: Get Your Free $500 Marketing Audit
Secondary CTA: Call Now: 0487 286 451
```

3. **Services Section:**
- Web Design & Development
- SEO & Local Search
- Google & Meta Ads

4. **Save Changes**

### Step 4: SEO Configuration

1. **Go to:** Profit Platform → SEO Settings

2. **Set focus keyword:** `digital marketing agency sydney`

3. **Configure meta:**
- Title: 60 characters max
- Description: 160 characters max

4. **Verify Rank Math integration**

### Step 5: Lead Forms Setup

1. **Go to:** Profit Platform → Lead Forms

2. **Configure fields:**
- Name (Required)
- Email (Required)
- Phone (Required)
- Service Interest
- Message

3. **Set notifications:**
- Email: avi@theprofitplatform.com.au
- Success message: Custom thank you

4. **Save Form Settings**

---

## 🧪 Testing & Verification

### Functionality Tests

```bash
# Test 1: Plugin Activation
✓ Plugin activates without errors
✓ Admin menu appears
✓ No PHP warnings in debug.log

# Test 2: Content Saving
✓ Hero content saves correctly
✓ SEO settings persist
✓ Form configuration saves

# Test 3: Export Function
✓ Export to Gutenberg blocks works
✓ Export to Kadence blocks works
✓ Preview function displays correctly
```

### Performance Tests

1. **Check page load speed:**
```bash
# Using WP-CLI
wp eval 'echo "Page generation time: " . timer_stop() . " seconds";'
```

2. **Verify no database bloat:**
```sql
SELECT table_name, 
       ROUND(((data_length + index_length) / 1024 / 1024), 2) AS "Size (MB)"
FROM information_schema.tables
WHERE table_schema = 'your_database'
AND table_name LIKE '%profit_platform%';
```

### Integration Tests

1. **Kadence Theme:**
- Custom styles apply correctly
- Blocks render properly
- Responsive design works

2. **Rank Math SEO:**
- SEO score calculates
- Meta data populates
- Schema markup generates

---

## 🚀 Go-Live Process

### Pre-Launch (1 Hour Before)

1. **Create full backup:**
```bash
wp db export backup-before-profit-platform.sql
```

2. **Clear all caches:**
- WordPress cache
- Browser cache
- CDN cache (if applicable)

3. **Test critical paths:**
- Homepage loads
- Forms submit
- Mobile responsive

### Launch Steps

1. **Export content to homepage:**
- Profit Platform → Homepage Builder
- Click "Export to Page"
- Select homepage or create new

2. **Set as front page:**
- Settings → Reading
- Set "Your homepage displays" to "A static page"
- Select your created page

3. **Configure permalinks:**
- Settings → Permalinks
- Select "Post name"
- Save changes

4. **Test live site:**
```bash
# Check homepage
curl -I https://theprofitplatform.com.au

# Test form submission
# Submit test form and verify email receipt
```

### Post-Launch (First 24 Hours)

1. **Monitor performance:**
- Check server logs
- Monitor form submissions
- Track page load speeds

2. **Verify SEO:**
- Submit to Google Search Console
- Check meta tags render
- Verify schema markup

3. **Test conversions:**
- Submit test lead
- Check email notifications
- Verify data storage

---

## 🔧 Troubleshooting

### Common Issues & Solutions

#### Issue: Plugin won't activate
```bash
# Check PHP version
php -v

# Check error log
tail -f /wp-content/debug.log

# Solution: Update PHP to 7.4+
```

#### Issue: Styles not loading
```bash
# Check file permissions
ls -la wp-content/plugins/profit-platform-phase1/assets/

# Solution: Fix permissions
chmod 644 assets/admin.css
```

#### Issue: AJAX calls failing
```javascript
// Check browser console for errors
// Verify nonce is being generated
console.log(pp_ajax.nonce);

// Solution: Regenerate permalinks
// Settings → Permalinks → Save
```

#### Issue: Kadence blocks not rendering
```php
// Add to wp-config.php for debugging
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Check for theme conflicts
// Try switching to default theme temporarily
```

### Database Issues

```sql
-- Check if tables exist
SHOW TABLES LIKE '%profit_platform%';

-- Check option values
SELECT * FROM wp_options 
WHERE option_name LIKE 'pp_%';

-- Reset plugin data if needed
DELETE FROM wp_options 
WHERE option_name LIKE 'pp_%';
```

### Performance Optimization

```bash
# Enable object caching
wp plugin install redis-cache --activate

# Optimize database
wp db optimize

# Clear transients
wp transient delete --all
```

---

## 📞 Support & Resources

### Getting Help

**Documentation:**
- Plugin Guide: `/wp-content/plugins/profit-platform-phase1/README.md`
- API Reference: `PHASE-1-MASTERPLAN.md`

**Support Channels:**
- Email: avi@theprofitplatform.com.au
- Phone: 0487 286 451
- GitHub Issues: [Report Issue](https://github.com/your-repo/issues)

### Useful Commands

```bash
# Check plugin status
wp plugin status profit-platform-phase1

# Deactivate if issues
wp plugin deactivate profit-platform-phase1

# View recent errors
wp eval 'print_r(error_get_last());'

# Export settings
wp option get pp_homepage_content --format=json > settings-backup.json

# Import settings
wp option update pp_homepage_content --format=json < settings-backup.json
```

### Rollback Procedure

If issues occur:

1. **Immediate rollback:**
```bash
# Deactivate plugin
wp plugin deactivate profit-platform-phase1

# Restore database
wp db import backup-before-profit-platform.sql

# Clear caches
wp cache flush
```

2. **Investigate issue:**
- Check error logs
- Review recent changes
- Test in staging environment

3. **Fix and redeploy:**
- Apply fixes
- Test thoroughly
- Deploy again following this guide

---

## ✅ Launch Checklist

### Final Verification
- [ ] All content displays correctly
- [ ] Forms submit and send emails
- [ ] Mobile responsive works
- [ ] Page loads under 2 seconds
- [ ] SEO meta tags present
- [ ] Analytics tracking active
- [ ] Backup created
- [ ] Team notified

### Sign-off
- [ ] Technical lead approval
- [ ] Content review complete
- [ ] Client approval received
- [ ] Launch communication sent

---

**Launch Date:** ___________  
**Launched By:** ___________  
**Version:** 1.0.0  

---

*This deployment guide is part of The Profit Platform Phase 1 implementation. For Phase 2 (automation) and Phase 3 (full integration), separate guides will be provided.*