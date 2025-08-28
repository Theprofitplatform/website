# The Profit Platform - WordPress Website

## 🚀 Project Overview
Sydney-based digital marketing agency website built with WordPress, Kadence Theme, and Rank Math SEO.

## 📁 Repository Structure
```
/
├── wp-content/              # WordPress theme and plugin files
│   ├── themes/
│   │   └── kadence-pp-child/   # Custom child theme
│   └── plugins/
│       └── pp-site/            # Custom site plugin
├── .github/workflows/       # GitHub Actions deployment
├── CLAUDE.md               # AI assistant instructions
└── PHASE-1-IMPLEMENTATION.md  # Current implementation guide
```

## 🔧 Technology Stack
- **CMS:** WordPress 6.x
- **Theme:** Kadence Theme + Child Theme
- **Builder:** Kadence Blocks
- **SEO:** Rank Math
- **Hosting:** Hostinger
- **Deployment:** GitHub Actions → FTP

## 🚀 Deployment

### Automatic Deployment (Active)
Every push to `main` branch triggers automatic FTP deployment to Hostinger.

```bash
# Deploy changes
git add .
git commit -m "Your changes"
git push origin main
```

### Manual Deployment
```bash
# Full site backup
git push auto main
```

## 📊 Git Repositories

1. **website.git** (This repo)
   - URL: https://github.com/Theprofitplatform/website
   - Purpose: Theme/plugin development
   - Auto-deploys via GitHub Actions

2. **auto.git** (Backup)
   - URL: https://github.com/Theprofitplatform/auto
   - Purpose: Full site version control

## 🎯 Current Status

### ✅ Completed
- Git repositories configured
- GitHub Actions deployment working
- Kadence child theme installed
- Custom CSS integrated
- Deployment pipeline tested

### 📝 In Progress
- Phase 1: Homepage implementation (see PHASE-1-IMPLEMENTATION.md)

### 🔜 Next Steps
1. Complete homepage in WordPress admin
2. Configure Rank Math SEO
3. Set up contact forms
4. Launch and test

## 📞 Contact
- **Website:** https://theprofitplatform.com.au
- **Email:** avi@theprofitplatform.com.au
- **Phone:** 0487 286 451

## 📄 Documentation
- **Implementation Guide:** [PHASE-1-IMPLEMENTATION.md](./PHASE-1-IMPLEMENTATION.md)
- **AI Instructions:** [CLAUDE.md](./CLAUDE.md)

---
*Last Updated: 2025-08-29*