# Kadence Blocks Conversion Guide

## Hero Section - Kadence Block Structure

### Block: Row Layout
**Settings:**
- Background: Linear gradient (135deg, #f8fafc 0%, #fff 50%, #f0f9ff 100%)
- Padding: Top 160px, Bottom 100px
- Min Height: 90vh
- Vertical Alignment: Center

#### Column 1 (60% width) - Text Content

##### Block: Advanced Heading (H1)
```
Get [gradient-text]3x More[/gradient-text] Local Customers in [location-text]Sydney[/location-text]
```
**Settings:**
- Font: Inter, Weight 800
- Size: Desktop 4rem, Tablet 3rem, Mobile 2.5rem
- Letter Spacing: -0.02em
- Line Height: 1.1
- Margin Bottom: 30px

**Custom Classes:**
- Main text: `hero-title`
- "3x More": `highlight-text` (gradient: #667eea to #764ba2)
- "Sydney": `location-text` (color: #059669)

##### Block: Advanced Text/Paragraph
```
Stop losing customers to competitors. We help Sydney businesses dominate Google and get more enquiries with proven digital marketing strategies that actually work.
```
**Settings:**
- Font Size: 1.35rem
- Color: #475569
- Line Height: 1.6
- Margin Bottom: 40px

##### Block: Icon List
**Items:**
- ✔ Get found on Google Maps & search results
- ✔ Convert more visitors into paying customers  
- ✔ No lock-in contracts - cancel anytime

**Settings:**
- Icon: Checkmark, Color: #2c86f9
- Font Weight: 500
- Color: #334155

##### Block: Row Layout (for buttons)
**Column 1:**
**Block: Advanced Button**
```
Get Your Free $500 Marketing Audit
Usually $500 - Free for 48 hours
```
**Settings:**
- Background: Linear gradient (#667eea to #764ba2)
- Padding: 20px 32px
- Border Radius: 16px
- Font Weight: 700
- Box Shadow: 0 10px 30px rgba(102, 126, 234, 0.4)
- Icon: Arrow right (fas fa-arrow-right)

**Column 2:**
**Block: Advanced Button**
```
📞 Call Now: 0487 286 451
```
**Settings:**
- Style: Outline
- Border: 2px solid #2c86f9
- Color: #2c86f9
- Padding: 20px 32px
- Link: tel:0487286451

##### Block: Advanced Text (Guarantee)
```
🛡️ 100% Risk-Free • No Setup Fees • Cancel Anytime
```
**Settings:**
- Font Size: 0.9rem
- Color: #64748b
- Text Align: Center
- Margin Top: 25px

#### Column 2 (40% width) - Hero Image

##### Block: Single Image
**Settings:**
- Image: hero-main-image.png
- Border Radius: 24px
- Box Shadow: 0 25px 50px rgba(0, 0, 0, 0.15)
- Alt Text: "Local SEO in Sydney"

##### Block: Icon (Floating Stats) - Position Absolute
**Stat Card 1:**
- Icon: Users (fas fa-users)
- Number: 247+
- Label: Happy Clients
- Position: Top 20%, Left -60px

**Stat Card 2:**
- Icon: Chart Bar (fas fa-chart-bar)  
- Number: 3.2x
- Label: Avg. ROI
- Position: Bottom 30%, Right -80px

**Stat Card 3:**
- Icon: Star (fas fa-star)
- Number: 4.9
- Label: Rating  
- Position: Top 10%, Right -40px

---

## Trust Bar Section

### Block: Row Layout
**Settings:**
- Background: White
- Padding: 40px 0
- Border Top: 1px solid #e2e8f0
- Border Bottom: 1px solid #e2e8f0

#### Block: Row Layout (3 columns, equal width)

**Column 1:**
##### Block: Icon List (single item)
- Icon: ⭐⭐⭐⭐⭐
- Text: "4.9/5 from 150+ reviews"

**Column 2:**  
##### Block: Icon List (single item)
- Text: "**Sydney-based** Local team, local results"

**Column 3:**
##### Block: Icon List (single item)  
- Text: "**No Lock-ins** Month-to-month contracts"

---

## Results Section

### Block: Advanced Heading (H2)
```
Real Results for Sydney Businesses
```

### Block: Advanced Text
```
We measure success in leads, sales, and ROI - not vanity metrics. Here are actual results from our recent clients.
```

### Block: Row Layout (4 columns)

#### Column 1 - Result Card
##### Block: Advanced Heading (H3)
```
+74%
More Phone Calls
```

##### Block: Icon
- Icon: Phone Volume (fas fa-phone-volume)
- Background: Linear gradient (#667eea to #764ba2)

##### Block: Advanced Text
```
Mike's Plumbing - Parramatta, NSW
"The phone doesn't stop ringing now. Best investment I've made."
Timeline: 60 days
```

#### Column 2-4 - Similar structure for other results

---

## Services Section

### Block: Row Layout (3 columns, equal width)

#### Column 1 - Web Design Service
##### Block: Icon
- Icon: Laptop Code (fas fa-laptop-code)
- Background: Linear gradient (#667eea to #764ba2)
- Size: 80px

##### Block: Advanced Heading (H3)
```
Web Design & Development
```

##### Block: Advanced Text
```
Fast, mobile-first websites that convert visitors into customers. Built on WordPress with full ownership.
```

##### Block: Icon List
- 5-page responsive website
- Contact forms & CRM integration  
- Google Analytics & tracking setup
- 2-second load time guarantee

##### Block: Advanced Text (Price)
```
From $1,790 one-time
```

#### Columns 2-3 - Similar structure for SEO and Google Ads

---

## Custom CSS Required (Add to Kadence Theme Customizer)

```css
/* Gradient text effects */
.highlight-text {
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.location-text {
    color: #059669 !important;
}

/* Floating stats positioning */
.floating-stats {
    position: relative;
}

.stat-card {
    position: absolute;
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    animation: float-cards 6s ease-in-out infinite;
}

@keyframes float-cards {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Hero background elements */
.hero-background-elements {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

/* Trust bar styling */
.trust-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
}

/* Result card styling */
.result-card {
    background: linear-gradient(135deg, #fff 0%, #fafbfc 100%);
    border-radius: 24px;
    padding: 40px 30px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.5s ease;
}

.result-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

/* Service card styling */
.service-card {
    background: linear-gradient(135deg, #fff 0%, #fafbfc 100%);
    border-radius: 16px;
    padding: 40px 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    text-align: center;
}

.service-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}
```

---

## WordPress Setup Instructions

### 1. Install Required Plugins
- Kadence Blocks Pro
- Kadence Theme
- Rank Math SEO

### 2. Theme Settings
- Set Inter as primary font
- Configure color palette with your brand colors
- Set up mobile breakpoints

### 3. Page Setup
- Create new page "Home"
- Set as static front page
- Add blocks following the structure above

### 4. SEO Setup (Rank Math)
- Add LocalBusiness schema
- Set focus keywords: "digital marketing agency sydney"
- Add FAQ schema to FAQ section
- Configure Google My Business integration

### 5. Performance
- Install caching plugin (WP Rocket recommended)
- Optimize images with WebP format
- Enable lazy loading
- Minify CSS/JS

Would you like me to create the detailed block configuration for any specific section?