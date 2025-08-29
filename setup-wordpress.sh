#!/bin/bash

# Profit Platform Phase 1 - WordPress Setup Script
# This script sets up the Phase 1 integration with WordPress, Kadence Theme, and Rank Math SEO

echo "======================================"
echo "The Profit Platform Phase 1 Setup"
echo "======================================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Function to print success message
success() {
    echo -e "${GREEN}✓${NC} $1"
}

# Function to print error message
error() {
    echo -e "${RED}✗${NC} $1"
}

# Function to print warning message
warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

# Check if running in WordPress directory
if [ ! -f "wp-config.php" ]; then
    error "This script must be run from your WordPress root directory"
    echo "Please navigate to your WordPress installation directory and run again"
    exit 1
fi

echo "Step 1: Checking WordPress installation..."
if [ -f "wp-config.php" ]; then
    success "WordPress installation found"
else
    error "WordPress not found. Please install WordPress first."
    exit 1
fi

echo ""
echo "Step 2: Creating plugin directory structure..."

# Create plugin directory if it doesn't exist
PLUGIN_DIR="wp-content/plugins/profit-platform-phase1"
if [ ! -d "$PLUGIN_DIR" ]; then
    mkdir -p "$PLUGIN_DIR"
    success "Plugin directory created: $PLUGIN_DIR"
else
    warning "Plugin directory already exists: $PLUGIN_DIR"
fi

# Create assets directory
if [ ! -d "$PLUGIN_DIR/assets" ]; then
    mkdir -p "$PLUGIN_DIR/assets"
    success "Assets directory created"
else
    warning "Assets directory already exists"
fi

echo ""
echo "Step 3: Copying plugin files..."

# Get the script directory (where the files are)
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Copy main plugin file
if [ -f "$SCRIPT_DIR/profit-platform-phase1-plugin.php" ]; then
    cp "$SCRIPT_DIR/profit-platform-phase1-plugin.php" "$PLUGIN_DIR/profit-platform-phase1.php"
    success "Main plugin file copied"
else
    error "Plugin file not found: profit-platform-phase1-plugin.php"
fi

# Copy CSS file
if [ -f "$SCRIPT_DIR/assets/admin.css" ]; then
    cp "$SCRIPT_DIR/assets/admin.css" "$PLUGIN_DIR/assets/admin.css"
    success "Admin CSS file copied"
else
    error "CSS file not found: assets/admin.css"
fi

# Copy JavaScript file
if [ -f "$SCRIPT_DIR/assets/admin.js" ]; then
    cp "$SCRIPT_DIR/assets/admin.js" "$PLUGIN_DIR/assets/admin.js"
    success "Admin JS file copied"
else
    error "JS file not found: assets/admin.js"
fi

# Copy automation HTML tool
if [ -f "$SCRIPT_DIR/wp-automation.html" ]; then
    cp "$SCRIPT_DIR/wp-automation.html" "$PLUGIN_DIR/automation-tool.html"
    success "Automation tool copied"
else
    warning "Automation tool not found: wp-automation.html"
fi

echo ""
echo "Step 4: Checking theme compatibility..."

# Check for Kadence theme
if [ -d "wp-content/themes/kadence" ]; then
    success "Kadence theme detected"
else
    warning "Kadence theme not found. Please install Kadence theme for best compatibility."
    echo "    Download from: https://wordpress.org/themes/kadence/"
fi

echo ""
echo "Step 5: Checking required plugins..."

# Check for Rank Math SEO
if [ -d "wp-content/plugins/seo-by-rank-math" ]; then
    success "Rank Math SEO detected"
else
    warning "Rank Math SEO not found. Please install for full SEO features."
    echo "    Download from: https://wordpress.org/plugins/seo-by-rank-math/"
fi

echo ""
echo "Step 6: Setting file permissions..."

# Set proper permissions
chmod 755 "$PLUGIN_DIR"
chmod 644 "$PLUGIN_DIR"/*.php 2>/dev/null
chmod 755 "$PLUGIN_DIR/assets"
chmod 644 "$PLUGIN_DIR/assets"/*.css 2>/dev/null
chmod 644 "$PLUGIN_DIR/assets"/*.js 2>/dev/null

success "File permissions set"

echo ""
echo "Step 7: Creating backup directory..."

# Create backup directory
BACKUP_DIR="wp-content/profit-platform-backups"
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p "$BACKUP_DIR"
    chmod 755 "$BACKUP_DIR"
    success "Backup directory created: $BACKUP_DIR"
else
    warning "Backup directory already exists"
fi

echo ""
echo "======================================"
echo "Setup Complete!"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. Log in to your WordPress admin panel"
echo "2. Go to Plugins → Installed Plugins"
echo "3. Find 'Profit Platform Phase 1' and click 'Activate'"
echo "4. Access the plugin from the 'Profit Platform' menu"
echo ""
echo "Required plugins for full functionality:"
echo "- Kadence Theme (for optimal design integration)"
echo "- Rank Math SEO (for SEO features)"
echo ""
echo "Documentation:"
echo "- Plugin Guide: $PLUGIN_DIR/README.md"
echo "- Automation Tool: $PLUGIN_DIR/automation-tool.html"
echo ""
success "Installation complete! Your Phase 1 WordPress integration is ready."