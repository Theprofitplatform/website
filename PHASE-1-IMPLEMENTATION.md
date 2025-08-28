# 🚀 Phase 1: WordPress Homepage Implementation

## Current Status ✅
- [x] Git repositories configured and private
- [x] Deployment pipeline working (GitHub Actions → Hostinger)
- [x] Kadence child theme installed with custom CSS
- [x] All preparation complete

## 🎯 Phase 1 Goal
Create a high-converting homepage using Kadence Blocks that gets you live and generating leads within 24 hours.

---

## Step 1: Access WordPress Admin
1. Go to: `https://theprofitplatform.com.au/wp-admin`
2. Login with your WordPress credentials
3. Ensure Kadence theme is active (Appearance → Themes)

---

## Step 2: Install Required Plugins

### Essential Plugins (If Not Already Installed):
1. **Kadence Blocks** (Free version first)
   - Plugins → Add New → Search "Kadence Blocks"
   - Install and Activate
   
2. **Rank Math SEO**
   - Search "Rank Math SEO"
   - Install and Activate
   - Run setup wizard (choose "Easy" mode)

3. **WPForms Lite** (For contact forms)
   - Search "WPForms"
   - Install and Activate

---

## Step 3: Create Homepage

### A. Create New Page
1. **Pages → Add New**
2. **Title:** "Home" (or leave blank for clean URL)
3. **Page Attributes → Template:** "Default Template" or "Full Width"
4. **Save Draft**

### B. Set as Homepage
1. **Settings → Reading**
2. **Your homepage displays:** Select "A static page"
3. **Homepage:** Select "Home"
4. **Save Changes**

---

## Step 4: Build Hero Section with Kadence

### Click "+" to Add Kadence Row Layout
```
Block: Row Layout
Columns: 2 (60/40 split)
```

### Left Column Content:
1. **Add Kadence Advanced Heading**
   - Text: `Get 3x More Local Customers in Sydney`
   - Font Size: Desktop: 4rem, Tablet: 3rem, Mobile: 2.5rem
   - Font Weight: 800
   - Add CSS Class: `hero-title`

2. **Add Advanced Text Block**
   ```
   Stop losing customers to competitors. We help Sydney businesses 
   dominate Google and get more enquiries with proven digital 
   marketing strategies that actually work.
   ```
   - Font Size: 1.35rem
   - Color: #475569
   - CSS Class: `hero-subtitle`

3. **Add Icon List Block**
   - ✅ Get found on Google Maps & search results
   - ✅ Convert more visitors into paying customers  
   - ✅ No lock-in contracts - cancel anytime
   - Icon Color: #2c86f9

4. **Add Buttons Block**
   - Primary Button:
     - Text: "Get Your Free $500 Marketing Audit"
     - Link: #contact
     - Background: Gradient (#667eea to #764ba2)
     - CSS Class: `btn-primary`
   
   - Secondary Button:
     - Text: "📞 Call Now: 0487 286 451"
     - Link: tel:0487286451
     - Style: Outline
     - CSS Class: `btn-outline`

### Right Column Content:
1. **Add Image Block**
   - Upload hero image (provided in website folder)
   - Or use placeholder: https://theprofitplatform.com.au/wp-content/uploads/2025/08/ChatGPT-Image-Aug-17-2025-11_30_04-PM.png

### Row Settings:
- **Background:** Gradient (135deg, #f8fafc 0%, #fff 50%, #f0f9ff 100%)
- **Padding:** Top: 160px, Bottom: 100px
- **Min Height:** 90vh

---

## Step 5: Add Trust Bar Section

### Add New Row Layout
```
Block: Row Layout
Columns: 3 equal
Background: White
Padding: 40px 0
```

### Column 1:
```html
⭐⭐⭐⭐⭐
4.9/5 from 150+ reviews
```

### Column 2:
```html
📍 Sydney-based
Local team, local results
```

### Column 3:
```html
🔓 No Lock-ins
Month-to-month contracts
```

---

## Step 6: Add Results Section

### Section Header:
1. **Add Row Layout** (single column)
2. **Add Advanced Heading** (H2): "Real Results for Sydney Businesses"
3. **Add Text**: "We measure success in leads, sales, and ROI - not vanity metrics."

### Results Grid:
1. **Add Row Layout** (4 columns)
2. **For each column, add Info Box Block:**

#### Result Card 1:
- Icon: 📞
- Number: +74%
- Label: More Phone Calls
- Description: "Mike's Plumbing - Parramatta"

#### Result Card 2:
- Icon: 📅
- Number: 3.2x
- Label: Booking Increase
- Description: "Sydney Physio Care - North Shore"

#### Result Card 3:
- Icon: 💰
- Number: -41%
- Label: Cost Per Lead
- Description: "Dan's Electrical - Western Sydney"

#### Result Card 4:
- Icon: 🏆
- Number: #1
- Label: Google Ranking
- Description: "Aussie Electric Pro - Inner West"

---

## Step 7: Add Services Section (Quick Overview)

### Add Row Layout (3 columns)

For each service, use **Info Box Block**:

1. **Web Design**
   - Icon: 💻
   - Title: Web Design & Development
   - Text: Fast, mobile-first websites that convert
   - Price: From $1,790

2. **SEO**
   - Icon: 🔍
   - Title: SEO & Local Search
   - Text: Dominate Google search results
   - Price: From $990/month

3. **Google Ads**
   - Icon: 📢
   - Title: Google & Meta Ads
   - Text: Instant visibility with targeted ads
   - Price: From $490/month

---

## Step 8: Add Contact Form Section

### Create Contact Form:
1. **WPForms → Add New**
2. **Select Template:** "Simple Contact Form"
3. **Add Fields:**
   - Name (Required)
   - Phone (Required)
   - Email (Required)
   - Company
   - Message
4. **Settings → Notifications:**
   - Send To: avi@theprofitplatform.com.au
5. **Save Form**

### Add to Page:
1. **Add Row Layout** (2 columns: 40/60)
2. **Left Column:** Contact information
3. **Right Column:** Embed WPForms using shortcode block

---

## Step 9: SEO Configuration with Rank Math

### On-Page SEO:
1. **In Page Editor → Rank Math SEO Box**
2. **Focus Keyword:** "digital marketing agency sydney"
3. **SEO Title:** "Digital Marketing Agency Sydney | Get 3x More Leads"
4. **Meta Description:** "Sydney's results-driven digital marketing agency. Get more customers with proven SEO, Google Ads & web design. No lock-ins. Free strategy call."

### Schema Markup:
1. **Schema Tab → Schema Type:** LocalBusiness
2. **Fill in:**
   - Business Name: The Profit Platform
   - Business Type: Marketing Agency
   - Phone: 0487286451
   - Address: Sydney, NSW
   - Price Range: $490-$1790

---

## Step 10: Final Checks & Launch

### Pre-Launch Checklist:
- [ ] All sections display correctly on mobile (use Customizer preview)
- [ ] Contact form sends test email successfully
- [ ] Phone number links work (click to test)
- [ ] Images are optimized (use Smush plugin if needed)
- [ ] Page loads in under 3 seconds
- [ ] SEO score is green in Rank Math

### Publish:
1. **Click "Publish" button**
2. **View page** at: https://theprofitplatform.com.au
3. **Test on mobile device**

---

## Step 11: Quick Optimizations

### Speed Optimization:
1. Install **WP Rocket** (if budget allows) or **W3 Total Cache** (free)
2. Enable caching
3. Enable lazy loading for images

### Analytics:
1. Install **Google Site Kit** plugin
2. Connect Google Analytics
3. Connect Search Console

---

## 🎯 Success Metrics (Check After 24 Hours)

- [ ] Homepage live and accessible
- [ ] Contact form receiving submissions
- [ ] Google has indexed the page (check: `site:theprofitplatform.com.au`)
- [ ] Mobile responsive working perfectly
- [ ] Load time under 3 seconds

---

## 📝 Notes for Next Phase

Once Phase 1 is complete and live:
1. Monitor initial traffic and engagement
2. Set up Google My Business
3. Start Phase 2: Additional landing pages
4. Begin content creation for blog

---

## 🆘 Troubleshooting

### If Kadence Blocks aren't showing:
- Go to Settings → Kadence Blocks
- Enable all block types
- Clear browser cache

### If styles look broken:
- The custom CSS is already loaded in child theme
- Clear cache (browser and WordPress)
- Check Customizer → Additional CSS

### If contact form isn't working:
- Check spam folder
- Verify SMTP settings
- Use WP Mail SMTP plugin if needed

---

## 🚀 Quick Wins After Launch

1. **Submit to Google Search Console**
   - Verify ownership
   - Submit sitemap

2. **Create Google My Business**
   - Add business details
   - Upload photos
   - Get first reviews

3. **Share on Social Media**
   - LinkedIn announcement
   - Facebook business page
   - Local business groups

---

## Time Estimate: 2-4 Hours

With all assets ready and this guide, you should have a professional homepage live within half a day.

**Remember:** Perfect is the enemy of done. Get it live, then iterate based on real user feedback!

---

## Next Step After Completion

Once Phase 1 is complete, commit your changes:
```bash
git add .
git commit -m "Phase 1: Homepage implementation complete"
git push origin main
```

Your changes will auto-deploy to Hostinger! 🎉