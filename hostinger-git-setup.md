# Hostinger Git Repository Setup Guide

## Current Setup Status ✅

You have successfully:
1. Created `auto.git` repository on GitHub
2. Connected it as a remote to your local project
3. Repository is accessible at: https://github.com/Theprofitplatform/auto.git

## Understanding the Two Repository Approach

### Repository 1: `website.git` (Current)
- **Purpose:** WordPress customizations only
- **Contents:** 
  - `/wp-content/themes/kadence-pp-child/`
  - `/wp-content/plugins/pp-site/`
- **Deployment:** Via GitHub Actions FTP to `public_html/wp-content/`

### Repository 2: `auto.git` (New)
- **Purpose:** Full WordPress site on Hostinger
- **Contents:** Everything in `public_html/`
- **Use Case:** Direct deployment or Hostinger Git integration

## Option 1: Push Current wp-content to auto.git

Since `auto.git` should contain your full WordPress site, you have two choices:

### A. Force Push (Replace everything in auto.git)
```bash
# This will replace everything in auto.git with your current files
git push auto master:main --force
```

### B. Merge with existing content
```bash
# Pull the xmlrpc.php file first
git pull auto main --allow-unrelated-histories

# Then push your content
git push auto master:main
```

## Option 2: Set Up Hostinger Git Integration

### Step 1: Enable Git in Hostinger
1. Log into Hostinger hPanel
2. Go to **"Advanced" → "Git"**
3. Click **"Create Git Repository"**
4. Set repository URL: `https://github.com/Theprofitplatform/auto.git`
5. Set branch: `main`
6. Set deployment path: `/public_html`

### Step 2: Add Deploy Key (if using SSH)
1. In Hostinger, generate SSH key
2. Add the public key to GitHub:
   - Go to: https://github.com/Theprofitplatform/auto.git/settings/keys
   - Click "Add deploy key"
   - Paste the public key from Hostinger

### Step 3: Set Up Auto-Deploy
1. In Hostinger Git settings
2. Enable **"Auto-deploy"**
3. Set deploy branch: `main`
4. Save settings

## Option 3: Manual Sync Strategy

If Hostinger doesn't support Git directly, use this workflow:

### For wp-content only (themes/plugins):
```bash
# Continue using website.git with GitHub Actions
git remote set-url origin https://github.com/Theprofitplatform/website.git
git push origin master
# GitHub Actions handles FTP deployment
```

### For full site updates:
```bash
# Use auto.git for version control
git add .
git commit -m "Update full site"
git push auto master:main

# Then manually deploy via:
# - FTP client (FileZilla)
# - Hostinger File Manager
# - GitHub Actions (modified workflow)
```

## Testing Your Current Setup

### 1. Test push to auto.git:
```bash
# Create a test file
echo "Git test $(date)" > git-test.txt
git add git-test.txt
git commit -m "Test auto.git connection"
git push auto master:main
```

### 2. Check on GitHub:
- Visit: https://github.com/Theprofitplatform/auto.git
- Verify your files appear

### 3. Check Hostinger Integration:
- If Git is enabled in Hostinger, it should pull automatically
- If not, you'll need to set up FTP deployment

## Recommended Approach

### For Your Situation:
1. **Keep `website.git`** for theme/plugin development
2. **Use `auto.git`** for full site backups/version control
3. **Deploy via GitHub Actions** (already working)

### Workflow:
```bash
# For theme/plugin updates
git push origin master  # Triggers GitHub Actions FTP

# For full site backup
git push auto master:main  # Version control only
```

## Current Remote Configuration

Your Git is configured with:
- `origin` → https://github.com/Theprofitplatform/website.git (themes/plugins)
- `auto` → https://github.com/Theprofitplatform/auto.git (full site)

## Next Steps

1. **Decide your approach:**
   - Keep using GitHub Actions FTP (working) ✅
   - Set up Hostinger Git integration (if available)
   - Use both for different purposes

2. **Test the deployment:**
   - Make a small change
   - Push to appropriate repository
   - Verify on live site

3. **Document your workflow:**
   - Which repo for which changes
   - Deployment process
   - Backup strategy

## Quick Commands Reference

```bash
# Check current remotes
git remote -v

# Push to website.git (triggers FTP deployment)
git push origin master

# Push to auto.git (version control)
git push auto master:main

# Force push to auto.git (replace everything)
git push auto master:main --force

# Switch between remotes
git push [remote-name] [branch]
```

## Verification Steps

To verify everything is working:

1. **GitHub Actions (current working method):**
   - Check: https://github.com/Theprofitplatform/website/actions
   - Should show green checkmarks for deployments

2. **New auto.git repository:**
   - Check: https://github.com/Theprofitplatform/auto.git
   - Should show your pushed files

3. **Live Website:**
   - Visit: https://theprofitplatform.com.au
   - Check if changes appear

Your setup is working! You just need to decide how to use both repositories effectively.