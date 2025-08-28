# 🚀 Hostinger Automatic Deployment Setup

## Step 1: Get Your Hostinger FTP Credentials

### From Hostinger Control Panel:
1. **Log in to Hostinger** (https://hpanel.hostinger.com)
2. **Go to "File Manager"** or **"FTP Access"**
3. **Copy these details:**
   - **FTP Server:** Usually `files.000webhost.com` or similar
   - **Username:** Your FTP username
   - **Password:** Your FTP password
   - **Port:** Usually `21` (FTP) or `990` (FTPS)

### Alternative - Create New FTP User:
1. Go to **"File Manager"** > **"FTP Accounts"**
2. **Create new FTP user** for GitHub deployment
3. **Set directory to:** `public_html`
4. **Note down the credentials**

---

## Step 2: Add FTP Credentials to GitHub Secrets

### In GitHub Repository:
1. **Go to:** https://github.com/Theprofitplatform/website/settings/secrets/actions
2. **Click "New repository secret"**
3. **Add these secrets ONE BY ONE:**

| Secret Name | Value | Example |
|-------------|-------|---------|
| `FTP_SERVER` | Your FTP server URL | `files.000webhost.com` |
| `FTP_USERNAME` | Your FTP username | `u123456789.theprofitplatform` |
| `FTP_PASSWORD` | Your FTP password | `your-secure-password` |
| `FTP_PORT` | FTP port number | `21` or `990` |

### 🔒 Security Note:
- These secrets are encrypted and only visible to GitHub Actions
- Never commit FTP credentials to your code

---

## Step 3: Test the Deployment

### Manual Test:
1. **Go to:** https://github.com/Theprofitplatform/website/actions
2. **Click "Deploy to Hostinger"**
3. **Click "Run workflow"** > **"Run workflow"**
4. **Watch the deployment process**

### Automatic Test:
1. **Make any small change** to a file
2. **Commit and push:**
   ```bash
   cd "C:\Users\abhis\Claud and Gemini\The Profit Platform\website"
   git add .
   git commit -m "Test automatic deployment"
   git push
   ```
3. **Check GitHub Actions tab** for deployment status

---

## Step 4: Verify Deployment

### Check Your Website:
1. **Visit:** https://theprofitplatform.com.au
2. **Go to WordPress Admin** > **Appearance** > **Themes**
3. **Look for:** "Kadence The Profit Platform Child" theme
4. **Check:** **Plugins** > **"PP Site - Site Enhancements"**

### Verify Files Uploaded:
- `/wp-content/themes/kadence-pp-child/` ✅
- `/wp-content/plugins/pp-site/` ✅

---

## 🛠️ Alternative Methods

### Method A: Hostinger Git Integration (If Available)
1. **Check if Hostinger supports Git**
2. **Connect your repository directly**
3. **Enable automatic pulls**

### Method B: Manual Sync (Backup)
```bash
# Download from GitHub
git clone https://github.com/Theprofitplatform/website.git

# Upload via FTP client (FileZilla, WinSCP)
# Upload only wp-content folder contents
```

---

## 🔧 Troubleshooting

### Common Issues:

**1. FTP Connection Failed**
- ✅ Check FTP server URL
- ✅ Verify username/password
- ✅ Try port 21 instead of 990 (or vice versa)

**2. Permission Denied**
- ✅ Ensure FTP user has write access to `public_html`
- ✅ Check directory permissions on Hostinger

**3. Files Not Appearing**
- ✅ Clear WordPress cache
- ✅ Check file paths in deployment
- ✅ Verify files uploaded to correct directory

**4. WordPress Not Recognizing Theme/Plugin**
- ✅ Check file permissions (755 for folders, 644 for files)
- ✅ Verify complete file upload
- ✅ Clear any caching plugins

---

## 📞 Next Steps

1. **Get FTP credentials from Hostinger**
2. **Add them to GitHub Secrets**
3. **Test deployment**
4. **Activate theme and plugin in WordPress**

**Need help?** The deployment will run automatically every time you push changes to GitHub!

---

## 🎯 What Happens After Setup

**Every time you push to GitHub:**
1. ✅ GitHub Actions triggers automatically
2. ✅ Files sync to your Hostinger website
3. ✅ WordPress theme and plugin update
4. ✅ Changes appear on https://theprofitplatform.com.au

**Your workflow becomes:**
```bash
# Make changes locally
git add .
git commit -m "Update website"
git push
# 🎉 Website automatically updates!
```