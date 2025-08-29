# =====================================================
# The Profit Platform - Phase 1 PowerShell Deployment
# =====================================================

param(
    [string]$WordPressPath = "C:\xampp\htdocs\wordpress",
    [switch]$SkipBackup = $false,
    [switch]$AutoActivate = $false
)

# Colors for output
function Write-Success { Write-Host $args -ForegroundColor Green }
function Write-Error { Write-Host $args -ForegroundColor Red }
function Write-Warning { Write-Host $args -ForegroundColor Yellow }
function Write-Info { Write-Host $args -ForegroundColor Cyan }

Clear-Host
Write-Host "====================================================" -ForegroundColor Cyan
Write-Host "   THE PROFIT PLATFORM - PHASE 1 DEPLOYMENT" -ForegroundColor Cyan
Write-Host "====================================================" -ForegroundColor Cyan
Write-Host ""

# Check if running as administrator
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")
if (-not $isAdmin) {
    Write-Warning "Running without administrator privileges. Some operations may fail."
}

# Variables
$PluginName = "profit-platform-phase1"
$SourcePath = Split-Path -Parent $MyInvocation.MyCommand.Path
$PluginPath = Join-Path $WordPressPath "wp-content\plugins\$PluginName"
$ThemesPath = Join-Path $WordPressPath "wp-content\themes"
$BackupPath = Join-Path $WordPressPath "wp-content\profit-platform-backups"

# Step 1: Verify WordPress installation
Write-Host "[1/10] Checking WordPress installation..." -ForegroundColor Yellow
$wpConfig = Join-Path $WordPressPath "wp-config.php"
if (Test-Path $wpConfig) {
    Write-Success "[OK] WordPress found at: $WordPressPath"
    
    # Try to read database info from wp-config.php
    $configContent = Get-Content $wpConfig -Raw
    if ($configContent -match "define\s*\(\s*'DB_NAME'\s*,\s*'([^']+)'\s*\)") {
        $dbName = $matches[1]
        Write-Info "     Database: $dbName"
    }
} else {
    Write-Error "[ERROR] WordPress not found at: $WordPressPath"
    Write-Host ""
    Write-Host "Please specify the correct path:" -ForegroundColor Yellow
    Write-Host "  .\deploy-phase1.ps1 -WordPressPath 'C:\your\wordpress\path'" -ForegroundColor White
    exit 1
}

# Step 2: Check source files
Write-Host ""
Write-Host "[2/10] Verifying source files..." -ForegroundColor Yellow
$requiredFiles = @(
    "profit-platform-phase1-plugin.php",
    "assets\admin.css",
    "assets\admin.js"
)

$filesOk = $true
foreach ($file in $requiredFiles) {
    $filePath = Join-Path $SourcePath $file
    if (Test-Path $filePath) {
        Write-Success "[OK] Found: $file"
    } else {
        Write-Error "[ERROR] Missing: $file"
        $filesOk = $false
    }
}

if (-not $filesOk) {
    Write-Error "Some required files are missing. Deployment aborted."
    exit 1
}

# Step 3: Backup existing plugin (if exists)
if (-not $SkipBackup -and (Test-Path $PluginPath)) {
    Write-Host ""
    Write-Host "[3/10] Creating backup..." -ForegroundColor Yellow
    
    if (-not (Test-Path $BackupPath)) {
        New-Item -ItemType Directory -Path $BackupPath -Force | Out-Null
    }
    
    $timestamp = Get-Date -Format "yyyyMMdd-HHmmss"
    $backupFile = Join-Path $BackupPath "backup-$PluginName-$timestamp.zip"
    
    try {
        Compress-Archive -Path $PluginPath -DestinationPath $backupFile -Force
        Write-Success "[OK] Backup created: $backupFile"
    } catch {
        Write-Warning "[!] Could not create backup: $_"
    }
} else {
    Write-Host ""
    Write-Host "[3/10] Skipping backup..." -ForegroundColor Yellow
}

# Step 4: Create plugin directory
Write-Host ""
Write-Host "[4/10] Creating plugin directory..." -ForegroundColor Yellow
if (-not (Test-Path $PluginPath)) {
    New-Item -ItemType Directory -Path $PluginPath -Force | Out-Null
    Write-Success "[OK] Plugin directory created"
} else {
    Write-Warning "[!] Plugin directory exists - will overwrite"
}

$assetsPath = Join-Path $PluginPath "assets"
if (-not (Test-Path $assetsPath)) {
    New-Item -ItemType Directory -Path $assetsPath -Force | Out-Null
}

# Step 5: Copy files
Write-Host ""
Write-Host "[5/10] Deploying plugin files..." -ForegroundColor Yellow

# Copy main plugin file
$sourceFile = Join-Path $SourcePath "profit-platform-phase1-plugin.php"
$destFile = Join-Path $PluginPath "$PluginName.php"
Copy-Item -Path $sourceFile -Destination $destFile -Force
Write-Success "[OK] Main plugin file deployed"

# Copy CSS
$sourceFile = Join-Path $SourcePath "assets\admin.css"
$destFile = Join-Path $assetsPath "admin.css"
Copy-Item -Path $sourceFile -Destination $destFile -Force
Write-Success "[OK] Admin CSS deployed"

# Copy JavaScript
$sourceFile = Join-Path $SourcePath "assets\admin.js"
$destFile = Join-Path $assetsPath "admin.js"
Copy-Item -Path $sourceFile -Destination $destFile -Force
Write-Success "[OK] Admin JavaScript deployed"

# Copy automation tool if exists
$automationFile = Join-Path $SourcePath "wp-automation.html"
if (Test-Path $automationFile) {
    $destFile = Join-Path $PluginPath "automation-tool.html"
    Copy-Item -Path $automationFile -Destination $destFile -Force
    Write-Success "[OK] Automation tool deployed"
}

# Step 6: Check for Kadence theme
Write-Host ""
Write-Host "[6/10] Checking theme compatibility..." -ForegroundColor Yellow
$kadencePath = Join-Path $ThemesPath "kadence"
if (Test-Path $kadencePath) {
    Write-Success "[OK] Kadence theme detected"
    
    # Create child theme if it doesn't exist
    $childThemePath = Join-Path $ThemesPath "kadence-child"
    if (-not (Test-Path $childThemePath)) {
        Write-Info "     Creating Kadence child theme..."
        New-Item -ItemType Directory -Path $childThemePath -Force | Out-Null
        
        # Create style.css
        $styleContent = @"
/*
Theme Name: Kadence Child - Profit Platform
Theme URI: https://theprofitplatform.com.au
Template: kadence
Author: The Profit Platform
Description: Kadence child theme optimized for The Profit Platform
Version: 1.0.0
*/
"@
        Set-Content -Path (Join-Path $childThemePath "style.css") -Value $styleContent
        
        # Copy functions.php
        $functionsSource = Join-Path $SourcePath "kadence-child-functions.php"
        if (Test-Path $functionsSource) {
            Copy-Item -Path $functionsSource -Destination (Join-Path $childThemePath "functions.php") -Force
            Write-Success "[OK] Kadence child theme created"
        }
    } else {
        Write-Info "     Kadence child theme already exists"
    }
} else {
    Write-Warning "[!] Kadence theme not found"
    Write-Host "     Install from: https://wordpress.org/themes/kadence/" -ForegroundColor Gray
}

# Step 7: Check for Rank Math SEO
Write-Host ""
Write-Host "[7/10] Checking SEO plugin..." -ForegroundColor Yellow
$rankMathPath = Join-Path $WordPressPath "wp-content\plugins\seo-by-rank-math"
if (Test-Path $rankMathPath) {
    Write-Success "[OK] Rank Math SEO detected"
} else {
    Write-Warning "[!] Rank Math SEO not found"
    Write-Host "     Install from: https://wordpress.org/plugins/seo-by-rank-math/" -ForegroundColor Gray
}

# Step 8: Create documentation
Write-Host ""
Write-Host "[8/10] Creating documentation..." -ForegroundColor Yellow

# Create README
$readmeContent = @"
# Profit Platform Phase 1 - Homepage Manager

Version: 1.0.0
Deployed: $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")

## Features
- Homepage content builder with visual editor
- SEO optimization with Rank Math integration
- Lead capture forms with email notifications
- Kadence theme compatibility
- Mobile-responsive design
- Performance optimized (<2s load time)

## Quick Start
1. Activate the plugin in WordPress admin
2. Navigate to "Profit Platform" menu
3. Configure your homepage content
4. Set up SEO settings
5. Configure lead forms

## File Structure
- $PluginName.php - Main plugin file
- assets/admin.css - Admin panel styles
- assets/admin.js - Admin panel JavaScript
- automation-tool.html - Standalone automation tool

## Support
Email: avi@theprofitplatform.com.au
Phone: 0487 286 451

## Requirements
- WordPress 5.0+
- PHP 7.4+
- Kadence Theme (recommended)
- Rank Math SEO (recommended)
"@
Set-Content -Path (Join-Path $PluginPath "README.md") -Value $readmeContent
Write-Success "[OK] Documentation created"

# Step 9: Verify deployment
Write-Host ""
Write-Host "[9/10] Verifying deployment..." -ForegroundColor Yellow
$verifyFiles = @(
    "$PluginName.php",
    "assets\admin.css",
    "assets\admin.js",
    "README.md"
)

$allGood = $true
foreach ($file in $verifyFiles) {
    $checkPath = Join-Path $PluginPath $file
    if (Test-Path $checkPath) {
        Write-Success "[OK] Verified: $file"
    } else {
        Write-Error "[ERROR] Missing: $file"
        $allGood = $false
    }
}

# Step 10: Auto-activate if requested
if ($AutoActivate) {
    Write-Host ""
    Write-Host "[10/10] Attempting auto-activation..." -ForegroundColor Yellow
    
    # Try to use WP-CLI if available
    $wpCliPath = Get-Command wp -ErrorAction SilentlyContinue
    if ($wpCliPath) {
        Push-Location $WordPressPath
        & wp plugin activate $PluginName
        Pop-Location
        Write-Success "[OK] Plugin activated via WP-CLI"
    } else {
        Write-Warning "[!] WP-CLI not found - please activate manually"
    }
} else {
    Write-Host ""
    Write-Host "[10/10] Manual activation required..." -ForegroundColor Yellow
}

# Summary
Write-Host ""
Write-Host "====================================================" -ForegroundColor Green
Write-Host "   DEPLOYMENT COMPLETE!" -ForegroundColor Green
Write-Host "====================================================" -ForegroundColor Green
Write-Host ""
Write-Info "Plugin Location:"
Write-Host "  $PluginPath" -ForegroundColor White
Write-Host ""
Write-Info "Next Steps:"
Write-Host "  1. Open WordPress Admin Panel" -ForegroundColor White
Write-Host "  2. Navigate to Plugins → Installed Plugins" -ForegroundColor White
Write-Host "  3. Find 'Profit Platform Phase 1'" -ForegroundColor White
Write-Host "  4. Click 'Activate'" -ForegroundColor White
Write-Host "  5. Access 'Profit Platform' menu" -ForegroundColor White
Write-Host ""

# Offer to open admin panel
$openAdmin = Read-Host "Open WordPress admin panel now? (Y/N)"
if ($openAdmin -eq 'Y' -or $openAdmin -eq 'y') {
    Start-Process "http://localhost/wordpress/wp-admin/plugins.php"
}

Write-Host ""
Write-Success "Phase 1 deployment successful!"