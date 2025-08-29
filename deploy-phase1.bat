@echo off
REM =====================================================
REM The Profit Platform - Phase 1 Deployment Script
REM For Windows/XAMPP/Local WordPress Installation
REM =====================================================

echo.
echo ====================================================
echo    THE PROFIT PLATFORM - PHASE 1 DEPLOYMENT
echo ====================================================
echo.

REM Set variables - MODIFY THESE FOR YOUR SETUP
set WORDPRESS_PATH=C:\xampp\htdocs\wordpress
set PLUGIN_NAME=profit-platform-phase1
set SOURCE_PATH=%~dp0

REM Check if we're in the right directory
if not exist "%SOURCE_PATH%profit-platform-phase1-plugin.php" (
    echo ERROR: Cannot find plugin files in current directory
    echo Please run this script from The Profit Platform project folder
    pause
    exit /b 1
)

echo [1/7] Checking WordPress installation...
if exist "%WORDPRESS_PATH%\wp-config.php" (
    echo [OK] WordPress found at: %WORDPRESS_PATH%
) else (
    echo [ERROR] WordPress not found at: %WORDPRESS_PATH%
    echo.
    echo Please update WORDPRESS_PATH in this script to your WordPress location.
    echo Common locations:
    echo   - C:\xampp\htdocs\wordpress
    echo   - C:\wamp64\www\wordpress
    echo   - C:\Users\%USERNAME%\Local Sites\profit-platform\app\public
    echo.
    pause
    exit /b 1
)

echo.
echo [2/7] Creating plugin directory structure...
set PLUGIN_PATH=%WORDPRESS_PATH%\wp-content\plugins\%PLUGIN_NAME%

if not exist "%PLUGIN_PATH%" (
    mkdir "%PLUGIN_PATH%"
    echo [OK] Plugin directory created
) else (
    echo [!] Plugin directory already exists - will overwrite files
)

if not exist "%PLUGIN_PATH%\assets" (
    mkdir "%PLUGIN_PATH%\assets"
    echo [OK] Assets directory created
)

echo.
echo [3/7] Copying plugin files...

REM Copy main plugin file
copy /Y "%SOURCE_PATH%profit-platform-phase1-plugin.php" "%PLUGIN_PATH%\%PLUGIN_NAME%.php" >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] Main plugin file copied
) else (
    echo [ERROR] Failed to copy main plugin file
    pause
    exit /b 1
)

REM Copy CSS file
copy /Y "%SOURCE_PATH%assets\admin.css" "%PLUGIN_PATH%\assets\admin.css" >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] Admin CSS copied
) else (
    echo [ERROR] Failed to copy admin.css
)

REM Copy JavaScript file
copy /Y "%SOURCE_PATH%assets\admin.js" "%PLUGIN_PATH%\assets\admin.js" >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] Admin JavaScript copied
) else (
    echo [ERROR] Failed to copy admin.js
)

REM Copy automation tool
copy /Y "%SOURCE_PATH%wp-automation.html" "%PLUGIN_PATH%\automation-tool.html" >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] Automation tool copied
) else (
    echo [!] Automation tool not copied (optional)
)

echo.
echo [4/7] Creating plugin readme...
(
echo # Profit Platform Phase 1 - Homepage Manager
echo.
echo Version: 1.0.0
echo Requires WordPress: 5.0+
echo Requires PHP: 7.4+
echo.
echo ## Features
echo - Homepage content builder
echo - SEO optimization with Rank Math
echo - Lead capture forms
echo - Kadence theme integration
echo.
echo ## Installation
echo 1. Activate plugin in WordPress admin
echo 2. Navigate to Profit Platform menu
echo 3. Configure homepage content
echo 4. Set up SEO settings
echo 5. Configure lead forms
echo.
echo ## Support
echo Email: avi@theprofitplatform.com.au
echo Phone: 0487 286 451
) > "%PLUGIN_PATH%\readme.txt"
echo [OK] Readme file created

echo.
echo [5/7] Checking for Kadence theme...
if exist "%WORDPRESS_PATH%\wp-content\themes\kadence" (
    echo [OK] Kadence theme detected
    
    REM Check if child theme exists
    if not exist "%WORDPRESS_PATH%\wp-content\themes\kadence-child" (
        echo [!] Creating Kadence child theme...
        mkdir "%WORDPRESS_PATH%\wp-content\themes\kadence-child"
        
        REM Create style.css for child theme
        (
echo /*
echo Theme Name: Kadence Child - Profit Platform
echo Theme URI: https://theprofitplatform.com.au
echo Template: kadence
echo Author: The Profit Platform
echo Description: Kadence child theme for The Profit Platform
echo Version: 1.0.0
echo */
        ) > "%WORDPRESS_PATH%\wp-content\themes\kadence-child\style.css"
        
        REM Copy functions.php
        copy /Y "%SOURCE_PATH%kadence-child-functions.php" "%WORDPRESS_PATH%\wp-content\themes\kadence-child\functions.php" >nul 2>&1
        echo [OK] Kadence child theme created
    ) else (
        echo [!] Kadence child theme already exists
    )
) else (
    echo [!] Kadence theme not found - please install for best results
)

echo.
echo [6/7] Creating deployment log...
(
echo Deployment Date: %date% %time%
echo WordPress Path: %WORDPRESS_PATH%
echo Plugin Path: %PLUGIN_PATH%
echo Deployed By: %USERNAME%
echo.
echo Files Deployed:
echo - %PLUGIN_NAME%.php
echo - assets/admin.css
echo - assets/admin.js
echo - automation-tool.html ^(optional^)
echo - readme.txt
echo.
echo Next Steps:
echo 1. Activate plugin in WordPress admin
echo 2. Configure settings
echo 3. Test functionality
) > "%PLUGIN_PATH%\deployment.log"
echo [OK] Deployment log created

echo.
echo [7/7] Verifying deployment...
set /a VERIFY_COUNT=0

if exist "%PLUGIN_PATH%\%PLUGIN_NAME%.php" set /a VERIFY_COUNT+=1
if exist "%PLUGIN_PATH%\assets\admin.css" set /a VERIFY_COUNT+=1
if exist "%PLUGIN_PATH%\assets\admin.js" set /a VERIFY_COUNT+=1
if exist "%PLUGIN_PATH%\readme.txt" set /a VERIFY_COUNT+=1

if %VERIFY_COUNT% equ 4 (
    echo [OK] All core files deployed successfully
) else (
    echo [WARNING] Some files may be missing
)

echo.
echo ====================================================
echo    DEPLOYMENT COMPLETE!
echo ====================================================
echo.
echo Plugin installed at:
echo %PLUGIN_PATH%
echo.
echo NEXT STEPS:
echo -----------
echo 1. Open WordPress Admin: http://localhost/wordpress/wp-admin
echo 2. Go to: Plugins - Installed Plugins
echo 3. Find: "Profit Platform Phase 1 - Homepage Manager"
echo 4. Click: Activate
echo 5. Access: Profit Platform menu in admin panel
echo.
echo OPTIONAL:
echo ---------
echo - Install Kadence Theme for best compatibility
echo - Install Rank Math SEO for SEO features
echo - Activate Kadence child theme if created
echo.
echo Would you like to open WordPress admin now? (Y/N)
set /p OPEN_ADMIN=

if /i "%OPEN_ADMIN%"=="Y" (
    start http://localhost/wordpress/wp-admin/plugins.php
)

echo.
echo Deployment script completed.
pause