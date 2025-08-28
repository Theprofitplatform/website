# Contact Section - Kadence Blocks

## Contact Section Layout

### Block: Row Layout
**Settings:**
- Columns: 2 (40% | 60%)
- Gap: 60px
- Padding: 80px 0
- Background: White

---

## Column 1 - Contact Information

### Block: Advanced Heading (H3)
```
Get In Touch
```
**Settings:**
- Font Size: 1.5rem
- Color: #0f172a
- Margin Bottom: 30px

### Contact Items (Using Icon List or Custom HTML)

#### Phone Contact
**Block: Icon List (Single Item)**
- Icon: Phone (fas fa-phone), Color: White, Background: #2c86f9
- Text: **Phone** [link]0487 286 451[/link]
- Link: tel:0487286451

#### Email Contact  
**Block: Icon List (Single Item)**
- Icon: Envelope (fas fa-envelope), Color: White, Background: #2c86f9
- Text: **Email** [link]avi@profitplatform.com.au[/link]
- Link: mailto:avi@profitplatform.com.au

#### Location
**Block: Icon List (Single Item)**
- Icon: Map Marker (fas fa-map-marker-alt), Color: White, Background: #2c86f9
- Text: **Location** Sydney, NSW Australia

#### Hours
**Block: Icon List (Single Item)**
- Icon: Clock (fas fa-clock), Color: White, Background: #2c86f9  
- Text: **Hours** Mon-Fri: 9am-6pm AEST

---

## Column 2 - Contact Form

### Block: Kadence Advanced Form
**Form Title:** Get Your Free Growth Audit

#### Form Fields:

##### Row 1 (2 columns, 50% each)
**Field 1: Text Input**
- Label: Full Name *
- Required: Yes
- Placeholder: Enter your full name
- Width: 50%

**Field 2: Phone Input**  
- Label: Phone Number *
- Required: Yes
- Placeholder: 04xx xxx xxx
- Width: 50%
- Validation: Phone number format

##### Row 2 (2 columns, 50% each)
**Field 3: Email Input**
- Label: Email Address *
- Required: Yes
- Placeholder: your@email.com
- Width: 50%
- Validation: Email format

**Field 4: Text Input**
- Label: Company Name
- Required: No
- Placeholder: Your company name
- Width: 50%

##### Row 3 (Full width)
**Field 5: URL Input**
- Label: Current Website (if any)
- Required: No
- Placeholder: https://yourwebsite.com
- Width: 100%

##### Row 4 (Full width)
**Field 6: Select Dropdown**
- Label: Monthly Marketing Budget
- Required: No
- Options:
  - Select budget range
  - $1,000 - $2,500
  - $2,500 - $5,000
  - $5,000 - $10,000  
  - $10,000+
- Width: 100%

##### Row 5 (Full width)
**Field 7: Textarea**
- Label: Tell us about your business goals
- Required: No
- Placeholder: What are your main challenges? What would you like to achieve?
- Rows: 4
- Width: 100%

#### Submit Button
**Block: Advanced Button (within form)**
- Text: 🚀 Get My Free Audit
- Background: Linear gradient (#667eea to #764ba2)
- Color: White
- Font Weight: 700
- Font Size: 1.1rem
- Padding: 18px 32px
- Border Radius: 16px
- Width: 100%
- Icon: Rocket (fas fa-rocket)

#### Form Footer Text
**Block: Advanced Text**
```
We'll get back to you within 4 hours with your personalized growth plan.
```
**Settings:**
- Font Size: 0.9rem
- Color: #64748b
- Text Align: Center
- Font Style: Italic
- Margin Top: 15px

---

## Form Settings & Configuration

### Kadence Advanced Form Settings

#### General Settings:
- Form ID: contact-audit-form
- Submit Action: Email
- Success Message: "Thanks! We'll send your free audit within 4 hours."
- Error Message: "Please check your details and try again."

#### Email Settings:
**To Email:** avi@theprofitplatform.com.au
**From Email:** {email}
**Subject:** New Free Audit Request - {name}
**Message Template:**
```
New free audit request received:

Name: {name}
Phone: {phone}
Email: {email} 
Company: {company}
Website: {website}
Budget: {budget}

Business Goals:
{message}

---
Submitted from: The Profit Platform Contact Form
Time: {date} {time}
IP Address: {ip}
```

#### Autoresponder Settings:
**To Email:** {email}
**From Email:** avi@theprofitplatform.com.au
**From Name:** Avi from The Profit Platform
**Subject:** Your Free Marketing Audit is Coming!
**Message:**
```
Hi {name},

Thanks for requesting your free marketing audit!

Here's what happens next:

✅ Within 4 hours: You'll receive your personalized audit report
✅ We'll identify exactly why you're missing leads
✅ Get a custom roadmap to 3x your enquiries
✅ No obligation - just valuable insights

Questions? Reply to this email or call 0487 286 451.

Talk soon,
Avi
The Profit Platform

P.S. This audit normally costs $500 - you're getting it free because you acted fast!
```

#### Spam Protection:
- Enable Honeypot: Yes
- Enable reCAPTCHA: Yes (optional)
- Rate Limiting: 3 submissions per IP per hour

#### Success Actions:
1. Show success message
2. Redirect to thank you page (optional)
3. Track conversion in Google Analytics
4. Add to email list (if using MailChimp/ConvertKit)

---

## Custom CSS for Contact Section

```css
/* Contact section styling */
.contact-section {
    background: white;
    padding: 80px 0;
}

.contact-info .kb-icon-list-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 16px;
    transition: all 0.3s ease;
}

.contact-info .kb-icon-list-item:hover {
    background: #f1f5f9;
    transform: translateX(5px);
}

.contact-info .kb-icon {
    width: 24px;
    height: 24px;
    background: #2c86f9;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
    margin-top: 2px;
}

/* Form container styling */
.contact-form-container {
    background: #f8fafc;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, .08);
}

.contact-form .kb-form {
    margin: 0;
}

.contact-form .kb-field {
    margin-bottom: 20px;
}

.contact-form label {
    display: block;
    margin-bottom: 8px;
    color: #0f172a;
    font-weight: 600;
}

.contact-form input,
.contact-form select, 
.contact-form textarea {
    width: 100%;
    padding: 15px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    font-family: inherit;
}

.contact-form input:focus,
.contact-form select:focus,
.contact-form textarea:focus {
    outline: none;
    border-color: #2c86f9;
    box-shadow: 0 0 0 3px rgba(44, 134, 249, 0.1);
}

.contact-form textarea {
    resize: vertical;
    min-height: 120px;
}

/* Submit button styling */
.contact-form .kb-button {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    padding: 18px 32px;
    border-radius: 16px;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.contact-form .kb-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

/* Success/Error messages */
.kb-form-success {
    background: #f0fdf4;
    border: 1px solid #10b981;
    color: #059669;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
}

.kb-form-error {
    background: #fef2f2;
    border: 1px solid #ef4444;
    color: #dc2626;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .contact-content {
        flex-direction: column;
        gap: 40px;
    }
    
    .contact-form-container {
        padding: 30px 20px;
    }
    
    .contact-info .kb-icon-list-item {
        padding: 15px;
    }
}
```

---

## WordPress Integration Steps

### 1. Install Required Plugins
- Kadence Blocks Pro (for Advanced Form block)
- Contact Form 7 (alternative option)
- WPForms (premium alternative)

### 2. Form Processing Options

#### Option A: Kadence Advanced Form (Recommended)
- Built-in spam protection
- Email notifications  
- Database storage of submissions
- Integration with email marketing services

#### Option B: Contact Form 7
- Free plugin
- Highly customizable
- Extensive add-on ecosystem
- Manual spam protection setup needed

#### Option C: WPForms (Premium)
- Drag & drop builder
- Advanced features
- Payment integration
- Email marketing integration

### 3. Email Setup
- Configure SMTP (use WP Mail SMTP plugin)
- Set up autoresponders
- Create email templates
- Test form submissions

### 4. Analytics Tracking
- Add Google Analytics event tracking
- Set up goal conversions
- Track form completion rates
- Monitor spam submissions

### 5. CRM Integration (Optional)
- Connect to HubSpot, Pipedrive, or similar
- Automatically create leads
- Set up lead nurturing sequences
- Track lead conversion rates