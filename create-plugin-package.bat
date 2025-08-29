@echo off
REM =====================================================
REM Create Plugin Package for Manual Installation
REM =====================================================

echo.
echo Creating Profit Platform Phase 1 Plugin Package...
echo.

REM Create temporary directory structure
set TEMP_DIR=profit-platform-phase1
set ZIP_NAME=profit-platform-phase1.zip

REM Clean up any existing temp directory
if exist "%TEMP_DIR%" rmdir /s /q "%TEMP_DIR%"
if exist "%ZIP_NAME%" del "%ZIP_NAME%"

REM Create directory structure
echo [1/5] Creating directory structure...
mkdir "%TEMP_DIR%"
mkdir "%TEMP_DIR%\assets"

REM Copy files
echo [2/5] Copying plugin files...
copy "profit-platform-phase1-plugin.php" "%TEMP_DIR%\profit-platform-phase1.php" >nul 2>&1
copy "assets\admin.css" "%TEMP_DIR%\assets\admin.css" >nul 2>&1
copy "assets\admin.js" "%TEMP_DIR%\assets\admin.js" >nul 2>&1

REM Copy optional files
if exist "wp-automation.html" (
    copy "wp-automation.html" "%TEMP_DIR%\automation-tool.html" >nul 2>&1
)

REM Create README
echo [3/5] Creating documentation...
(
echo # Profit Platform Phase 1 - Homepage Manager
echo.
echo Version: 1.0.0
echo Requires: WordPress 5.0+, PHP 7.4+
echo.
echo ## Installation
echo 1. Upload this folder to wp-content/plugins/
echo 2. Activate in WordPress admin
echo 3. Access via Profit Platform menu
echo.
echo ## Features
echo - Homepage content builder
echo - SEO optimization
echo - Lead capture forms
echo - Kadence theme integration
echo - Rank Math SEO support
echo.
echo ## Support
echo Email: avi@theprofitplatform.com.au
echo Phone: 0487 286 451
) > "%TEMP_DIR%\README.txt"

REM Check if PowerShell compression is available
echo [4/5] Creating ZIP package...
powershell -Command "Compress-Archive -Path '%TEMP_DIR%' -DestinationPath '%ZIP_NAME%' -Force" 2>nul

if exist "%ZIP_NAME%" (
    echo [5/5] Package created successfully!
    echo.
    echo ====================================================
    echo    PLUGIN PACKAGE READY!
    echo ====================================================
    echo.
    echo Package created: %ZIP_NAME%
    echo Size: 
    powershell -Command "(Get-Item '%ZIP_NAME%').Length / 1KB" | more
    echo KB
    echo.
    echo INSTALLATION INSTRUCTIONS:
    echo --------------------------
    echo.
    echo Option 1: Upload via WordPress Admin
    echo   1. Log in to WordPress Admin
    echo   2. Go to Plugins - Add New - Upload Plugin
    echo   3. Choose %ZIP_NAME%
    echo   4. Click Install Now
    echo   5. Click Activate
    echo.
    echo Option 2: Manual FTP Installation
    echo   1. Extract %ZIP_NAME%
    echo   2. Upload folder to /wp-content/plugins/
    echo   3. Activate in WordPress admin
    echo.
) else (
    echo [ERROR] Failed to create ZIP package
    echo.
    echo Manual packaging required:
    echo   1. Right-click on '%TEMP_DIR%' folder
    echo   2. Select "Send to" - "Compressed (zipped) folder"
    echo   3. Upload the ZIP file to WordPress
)

REM Clean up temp directory
echo.
echo Clean up temporary files? (Y/N)
set /p CLEANUP=
if /i "%CLEANUP%"=="Y" (
    rmdir /s /q "%TEMP_DIR%"
    echo Temporary files cleaned.
)

echo.
pause