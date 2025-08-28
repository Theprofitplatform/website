# FAQ Section - Kadence Blocks + Rank Math Schema

## FAQ Section Structure

### Block: Advanced Heading (H2)
```
Frequently Asked Questions
```
**Settings:**
- Font Weight: 700
- Text Align: Center
- Margin Bottom: 20px

### Block: Advanced Text
```
Got questions? We've got comprehensive answers to help you make the right decision.
```
**Settings:**
- Text Align: Center
- Font Size: 1.1rem
- Color: #64748b
- Margin Bottom: 40px

---

## FAQ Items (Use Kadence FAQ Block or Accordion)

### FAQ 1 - Pricing Structure
**Question:** How is your pricing structured?
**Answer:**
```
**Transparent, no-surprise pricing:**

• **Website Design:** One-time fee from $1,790 (includes 5 pages, mobile optimization, contact forms)
• **SEO Services:** Monthly packages from $990 (includes local SEO, content creation, technical optimization)  
• **Google Ads:** Management fee from $490/month + your ad spend budget (you pay Google directly)
• **Meta Ads:** Same structure - management fee + ad spend

*No setup fees, no hidden costs, no long-term contracts required.*
```

### FAQ 2 - Lock-in Contracts
**Question:** Are there any lock-in contracts?
**Answer:**
```
**No lock-in contracts, ever.** All our services are month-to-month because we believe in earning your business through results, not legal agreements.

**Cancellation terms:**
• 30 days written notice for ongoing services
• Pause services anytime (great for seasonal businesses)
• Resume services whenever you're ready
• Keep everything we've built - websites, ads accounts, analytics

*We're confident you'll want to stay because of the results we deliver.*
```

### FAQ 3 - Service Areas
**Question:** What areas of Sydney do you service?
**Answer:**
```
**We serve all of Greater Sydney:**

**Inner Sydney:** CBD, Surry Hills, Darlinghurst, Potts Point, Redfern
**North Shore:** Chatswood, North Sydney, Neutral Bay, Mosman, Hornsby  
**Eastern Suburbs:** Bondi, Randwick, Double Bay, Woollahra, Maroubra
**Inner West:** Newtown, Leichhardt, Balmain, Glebe, Marrickville
**Western Sydney:** Parramatta, Penrith, Blacktown, Liverpool, Campbelltown
**Southern Sydney:** Sutherland Shire, St George, Hurstville, Bankstown

**Virtual consultations** available for all NSW businesses. **On-site meetings** available within 50km of Sydney CBD.
```

### FAQ 4 - Industries
**Question:** What industries do you work with?
**Answer:**
```
**We specialize in local Sydney businesses across all industries:**

🏠 **Home Services:** Plumbers, electricians, landscapers, cleaners
🏥 **Health & Wellness:** Dentists, physios, gyms, beauty salons  
⚖️ **Professional Services:** Lawyers, accountants, consultants
🏪 **Retail & E-commerce:** Online stores, local retailers
🍴 **Hospitality:** Restaurants, cafes, catering
🚗 **Automotive:** Mechanics, car dealers, auto services

*Every industry has unique challenges - we tailor our approach accordingly.*
```

### FAQ 5 - Results Timeline
**Question:** How quickly will I see results?
**Answer:**
```
**Results timeline by service:**

🚀 **Immediate (24-48 hours):**
• Google Ads campaigns go live
• Website improvements visible
• Analytics tracking active

📈 **Short-term (1-4 weeks):**
• First Google Ads leads and calls
• Google My Business improvements  
• Website conversion rate improvements

📊 **Medium-term (1-3 months):**
• Local SEO ranking improvements
• Increased organic website traffic
• More consistent lead flow

🎯 **Long-term (3-6 months):**
• Significant SEO results
• Established market presence
• Predictable ROI and growth

*We track and report on progress every step of the way.*
```

### FAQ 6 - Expected Results
**Question:** What kind of results can I expect?
**Answer:**
```
**Real results from recent Sydney clients:**

📞 **Plumber (Inner West):** +74% phone calls in 60 days
💪 **Gym (North Shore):** +120% membership enquiries in 90 days  
🦷 **Dental Practice (CBD):** +45% new patient bookings in 45 days
⚖️ **Law Firm (Eastern Suburbs):** +89% consultation requests in 4 months
🔧 **Auto Repair (Western Sydney):** -35% cost per lead with Google Ads

**Typical improvements within 90 days:**
• 2-5x increase in website enquiries
• 30-80% more phone calls
• First page Google rankings for target keywords  
• ROI of 3:1 to 8:1 on advertising spend

*Results vary by industry and competition, but we guarantee you'll see measurable improvement.*
```

### FAQ 7 - Results Guarantee
**Question:** Do you guarantee results?
**Answer:**
```
**Our guarantee:** If you don't see measurable improvement in your key metrics within 90 days, we'll work for free until you do.

**What we guarantee:**
✅ Increased website traffic and engagement
✅ Improved Google search visibility
✅ More enquiries through your website
✅ Better conversion rates
✅ Transparent monthly reporting

**What we don't guarantee:** Specific ranking positions or exact lead numbers (too many variables outside our control).

*We're so confident in our process that we're willing to put our money where our mouth is.*
```

### FAQ 8 - Support & Communication
**Question:** What kind of support do you provide?
**Answer:**
```
**Comprehensive support included:**

📞 **Phone Support:** Direct line to your account manager (not a call center)
📧 **Email Support:** Response within 4 business hours
💬 **WhatsApp:** Quick questions and urgent issues
🖥️ **Screen Share:** We'll show you exactly what we're doing
📊 **Monthly Calls:** Strategy review and planning sessions

**Support hours:** Monday-Friday 9am-6pm AEST. Emergency support available for critical issues.

*You'll always talk to the same team members who know your business.*
```

---

## Rank Math Schema Configuration

### FAQ Schema Setup

In Rank Math, add this FAQ schema data:

```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How is your pricing structured?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Transparent, no-surprise pricing: Website Design one-time fee from $1,790, SEO Services monthly packages from $990, Google Ads management fee from $490/month + ad spend. No setup fees, no hidden costs, no long-term contracts required."
      }
    },
    {
      "@type": "Question", 
      "name": "Are there any lock-in contracts?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No lock-in contracts, ever. All services are month-to-month. 30 days written notice for cancellation. You keep everything we've built - websites, ads accounts, analytics."
      }
    },
    {
      "@type": "Question",
      "name": "What areas of Sydney do you service?",
      "acceptedAnswer": {
        "@type": "Answer", 
        "text": "We serve all of Greater Sydney including Inner Sydney, North Shore, Eastern Suburbs, Inner West, Western Sydney, and Southern Sydney. Virtual consultations available for all NSW businesses."
      }
    },
    {
      "@type": "Question",
      "name": "How quickly will I see results?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Results timeline varies: Immediate (24-48 hours) for Google Ads, Short-term (1-4 weeks) for first leads, Medium-term (1-3 months) for SEO improvements, Long-term (3-6 months) for significant growth and market dominance."
      }
    },
    {
      "@type": "Question",
      "name": "What kind of results can I expect?", 
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Recent client results include: +74% phone calls, +120% enquiries, +45% bookings. Typical improvements within 90 days: 2-5x increase in website enquiries, 30-80% more phone calls, first page Google rankings, ROI of 3:1 to 8:1."
      }
    },
    {
      "@type": "Question",
      "name": "Do you guarantee results?",
      "acceptedAnswer": {
        "@type": "Answer", 
        "text": "Yes, if you don't see measurable improvement in key metrics within 90 days, we'll work for free until you do. We guarantee increased traffic, improved visibility, more enquiries, better conversion rates, and transparent reporting."
      }
    }
  ]
}
```

### LocalBusiness Schema for Rank Math

```json
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "The Profit Platform",
  "description": "Sydney's results-driven digital marketing agency. Get more customers with proven SEO, Google Ads & web design.",
  "url": "https://theprofitplatform.com.au",
  "telephone": "0487286451",
  "email": "avi@theprofitplatform.com.au",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Sydney",
    "addressRegion": "NSW", 
    "addressCountry": "Australia"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "-33.8688",
    "longitude": "151.2093"
  },
  "areaServed": [
    "Sydney NSW",
    "Inner Sydney",
    "North Shore Sydney", 
    "Eastern Suburbs Sydney",
    "Inner West Sydney",
    "Western Sydney",
    "Southern Sydney"
  ],
  "serviceType": [
    "Digital Marketing",
    "Search Engine Optimization", 
    "Google Ads Management",
    "Web Design",
    "Local SEO"
  ],
  "priceRange": "$490-$1790",
  "openingHours": "Mo-Fr 09:00-18:00",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "150"
  }
}
```

## Kadence FAQ Block Settings

### Block: Accordion/FAQ Block
**Global Settings:**
- Layout: Accordion style
- Icon: Plus/Minus
- Border: 1px solid #e2e8f0
- Border Radius: 16px
- Spacing: 20px between items
- Background: White
- Shadow: 0 4px 20px rgba(15, 23, 42, .08)

**Question Style:**
- Font Weight: 600
- Font Size: 1rem
- Color: #0f172a
- Padding: 25px 30px
- Background: White (hover: #f8fafc)

**Answer Style:** 
- Font Size: 1rem
- Color: #475569
- Padding: 0 30px 30px
- Line Height: 1.7

**Custom CSS Class:** `faq-section`