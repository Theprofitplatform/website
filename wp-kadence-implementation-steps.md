# Immediate WordPress + Kadence Implementation Steps

## Phase 1: Homepage Creation with Kadence Blocks (This Week)

### Step 1: Create Homepage in WordPress Admin

1. **Go to Pages > Add New**
2. **Title:** "Home"
3. **Set as Front Page:** Settings > Reading > Static Front Page > Select "Home"
4. **Template:** Full Width (if available in Kadence)

### Step 2: Build Hero Section

**Add Row Layout Block:**
1. Click "+" → Search "Row Layout" (Kadence Blocks)
2. Choose 2-column layout (60% | 40%)
3. **Background Settings:**
   - Background Type: Gradient
   - Gradient: Linear (135deg)
   - Color 1: #f8fafc
   - Color 2: #f0f9ff
4. **Spacing:**
   - Padding Top: 160px
   - Padding Bottom: 100px
   - Min Height: 90vh

**Column 1 - Text Content:**

1. **Add Advanced Heading Block:**
   ```
   Get [highlight]3x More[/highlight] Local Customers in [location]Sydney[/location]
   ```
   - Font Size: 4rem (Desktop), 3rem (Tablet), 2.5rem (Mobile) 
   - Font Weight: 800
   - Line Height: 1.1
   - Custom CSS Class: `hero-title`

2. **Add Advanced Text Block (Subtitle):**
   ```
   Stop losing customers to competitors. We help Sydney businesses dominate Google and get more enquiries with proven digital marketing strategies that actually work.
   ```
   - Font Size: 1.35rem
   - Color: #475569
   - Custom CSS Class: `hero-subtitle`

3. **Add Icon List Block:**
   - Item 1: ✔ Get found on Google Maps & search results
   - Item 2: ✔ Convert more visitors into paying customers
   - Item 3: ✔ No lock-in contracts - cancel anytime
   - Icon Color: #2c86f9
   - Custom CSS Class: `hero-bullets`

4. **Add Row Layout (for buttons):**
   - 2 columns (60% | 40%)
   
   **Column 1 - Primary CTA:**
   - Add Advanced Button
   - Text: "Get Your Free $500 Marketing Audit"
   - Background: Gradient (#667eea to #764ba2)
   - Custom CSS Class: `btn-primary`
   - Link: #contact

   **Column 2 - Phone CTA:**
   - Add Advanced Button  
   - Text: "📞 Call Now: 0487 286 451"
   - Style: Outline
   - Link: tel:0487286451
   - Custom CSS Class: `btn-outline`

**Column 2 - Hero Image:**

1. **Add Single Image Block:**
   - Upload your hero image
   - Border Radius: 24px
   - Add Custom CSS Class: `hero-image-container`

2. **Add Custom HTML Block (for floating stats):**
   ```html
   <div class="floating-stats">
     <div class="stat-card stat-1">
       <div class="stat-icon">
         <i class="fas fa-users"></i>
       </div>
       <div class="stat-content">
         <span class="stat-number">247+</span>
         <span class="stat-label">Happy Clients</span>
       </div>
     </div>
     
     <div class="stat-card stat-2">
       <div class="stat-icon">
         <i class="fas fa-chart-bar"></i>
       </div>
       <div class="stat-content">
         <span class="stat-number">3.2x</span>
         <span class="stat-label">Avg. ROI</span>
       </div>
     </div>
     
     <div class="stat-card stat-3">
       <div class="stat-icon">
         <i class="fas fa-star"></i>
       </div>
       <div class="stat-content">
         <span class="stat-number">4.9</span>
         <span class="stat-label">Rating</span>
       </div>
     </div>
   </div>
   ```

### Step 3: Build Trust Bar Section

**Add Row Layout Block:**
1. Background: White
2. Padding: 40px 0
3. Border Top & Bottom: 1px solid #e2e8f0
4. Custom CSS Class: `trust-bar`

**Add Row Layout (3 equal columns):**

**Column 1:**
```html
<div class="trust-item">
  <strong>⭐⭐⭐⭐⭐</strong>
  <span>4.9/5 from 150+ reviews</span>
</div>
```

**Column 2:**
```html
<div class="trust-item">
  <strong>Sydney-based</strong>
  <span>Local team, local results</span>
</div>
```

**Column 3:**
```html
<div class="trust-item">
  <strong>No Lock-ins</strong>
  <span>Month-to-month contracts</span>
</div>
```

### Step 4: Build Results Section

**Add Section Block:**
1. Background: Linear gradient (#fafbfc to #f0f9ff)
2. Padding: 100px 0
3. Custom CSS Class: `results-section`

**Add Advanced Heading (H2):**
```
Real Results for Sydney Businesses
```

**Add Advanced Text:**
```
We measure success in leads, sales, and ROI - not vanity metrics. Here are actual results from our recent clients.
```

**Add Row Layout (4 columns):**

**Column 1 - Result Card 1:**
```html
<div class="result-card case-study-1">
  <div class="result-icon">
    <i class="fas fa-phone-volume"></i>
  </div>
  <div class="result-number">+74%</div>
  <div class="result-label">More Phone Calls</div>
  <div class="result-testimonial">
    <p>"The phone doesn't stop ringing now. Best investment I've made."</p>
    <strong>Mike's Plumbing - Parramatta, NSW</strong>
  </div>
</div>
```

**Column 2-4:** Similar structure with different data

### Step 5: Add Required Plugins

1. **Install Kadence Blocks Pro:**
   - Go to Plugins > Add New
   - Search "Kadence Blocks"
   - Install and activate

2. **Install Rank Math SEO:**
   - Search "Rank Math"  
   - Install and activate
   - Run setup wizard

3. **Install WP Rocket (optional but recommended):**
   - For caching and performance

## Phase 2: SEO Configuration (Rank Math)

### Quick Rank Math Setup:

1. **Go to Rank Math > General Settings**
2. **Local SEO Tab:**
   - Business Name: The Profit Platform
   - Business Type: Marketing Agency
   - Address: [Your Sydney address]
   - Phone: 0487286451
   - Email: avi@theprofitplatform.com.au

3. **Homepage SEO:**
   - Focus Keyword: "digital marketing agency sydney"
   - SEO Title: "Digital Marketing Agency Sydney | Get 3x More Leads"
   - Meta Description: "Sydney's results-driven digital marketing agency. Get more customers with proven SEO, Google Ads & web design. No lock-ins. Free strategy call."

### Add Schema Markup:

Go to Rank Math > Schema > Add Schema:

**LocalBusiness Schema:**
```json
{
  "@type": "LocalBusiness",
  "name": "The Profit Platform",
  "description": "Sydney's results-driven digital marketing agency",
  "telephone": "+61487286451",
  "email": "avi@theprofitplatform.com.au",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Sydney",
    "addressRegion": "NSW",
    "addressCountry": "AU"
  },
  "areaServed": ["Sydney NSW", "Greater Sydney"],
  "serviceType": ["Digital Marketing", "SEO", "Google Ads", "Web Design"],
  "priceRange": "$490-$1790"
}
```

## Phase 3: Contact Form Setup

### Using Kadence Advanced Form:

1. **Add Advanced Form Block**
2. **Form Fields:**
   - Name (required)
   - Phone (required)  
   - Email (required)
   - Company Name
   - Website URL
   - Budget (dropdown)
   - Message (textarea)

3. **Email Settings:**
   - To: avi@theprofitplatform.com.au
   - Subject: "New Free Audit Request - {name}"
   - Auto-responder: Enable

4. **Success Message:**
   ```
   Thanks! We'll send your free audit within 4 hours.
   ```

## Phase 4: FAQ Section with Schema

### Add Accordion Block:

1. **Add FAQ/Accordion Block**
2. **Add each FAQ item from the guide**
3. **Custom CSS Class:** `faq-section`

### Add FAQ Schema in Rank Math:
1. Go to your page/post
2. Scroll to Rank Math SEO box
3. Schema tab > Add FAQ Schema
4. Add each question/answer pair

## Phase 5: Performance & Testing

### Optimize Images:
1. Install Smush or ShortPixel plugin
2. Compress all images
3. Convert to WebP format

### Test Site:
1. **Mobile Responsiveness:** Use mobile preview
2. **Page Speed:** Test with GTmetrix or PageSpeed Insights
3. **Contact Form:** Submit test form
4. **Schema:** Validate with Google's Rich Results Test

## Phase 6: Launch Checklist

### Pre-Launch:
- ✅ All sections built and styled
- ✅ Contact form working
- ✅ Mobile responsive
- ✅ SEO setup complete
- ✅ Schema markup validated
- ✅ Images optimized
- ✅ Site speed acceptable (<3 seconds)

### Post-Launch:
- ✅ Submit sitemap to Google Search Console
- ✅ Monitor Google Analytics
- ✅ Track form submissions
- ✅ Check for broken links
- ✅ Monitor site performance

## Quick Reference - CSS Classes to Use:

**Hero Section:**
- `.hero-section` - Main hero container
- `.hero-title` - Main heading
- `.highlight-text` - Gradient text
- `.location-text` - Green Sydney text
- `.hero-subtitle` - Subtitle text
- `.hero-bullets` - Benefit list

**Trust Bar:**
- `.trust-bar` - Section container
- `.trust-item` - Individual trust elements

**Results:**
- `.results-section` - Section background
- `.result-card` - Individual result cards
- `.case-study-1`, `.case-study-2`, etc. - Specific styling

**Buttons:**
- `.btn-primary` - Primary CTA button
- `.btn-outline` - Outline button

Your enhanced CSS is already loaded, so these classes will automatically style your content!

## Priority Order:
1. **Week 1:** Hero + Trust Bar sections
2. **Week 2:** Results + Services sections  
3. **Week 3:** FAQ + Contact form
4. **Week 4:** SEO optimization + testing

Need help with any specific section? Let me know!