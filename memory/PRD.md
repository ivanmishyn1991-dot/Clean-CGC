# Clean Gutters Crew - Cleaning Services Website

## Original Problem Statement
Enhance and polish an existing cleaning service website built with PHP and Twig. Primary goals:
1. Achieve Google PageSpeed score of 80+ for both mobile and desktop
2. Eliminate font loading "jumps" (FOUT) that cause Cumulative Layout Shift (CLS)
3. Keep repository clean of unnecessary files
4. Improve site structure for better performance

## Tech Stack
- **Backend:** PHP 8.x with FlightPHP framework
- **Templating:** Twig
- **Frontend:** Vanilla JavaScript, CSS, HTML
- **Database:** MySQL (via Doctrine ORM)
- **Integrations:** Telegram API (notifications), Google reCAPTCHA

## Project Structure
```
/app/
├── app/                  # PHP Controllers, Middleware, Services
├── public/
│   ├── assets/
│   │   ├── css/          # Main stylesheets (style.css, main-page.css)
│   │   ├── js/           # JavaScript (app.js)
│   │   ├── images/       # Site images
│   │   └── fonts/        # Self-hosted Inter fonts (latin subset)
│   ├── admin/            # Admin panel assets (OPTIMIZED)
│   │   ├── css/          # fontawesome.min.css (updated)
│   │   └── webfonts/     # FontAwesome fonts (SVG/EOT removed)
│   └── index.php         # Main router
├── resources/
│   └── templates/        # Twig templates
│       ├── landing/main.html.twig  # Main page (now smaller)
│       ├── quote.html.twig         # Separate quote page (NEW)
│       ├── template.html.twig      # Base template
│       └── page.html.twig          # Page template
├── .env                  # Environment configuration
├── .gitignore            # Updated to exclude vendor/, .emergent/
└── composer.json
```

## What's Been Implemented

### Quote Form Separation (Dec 9, 2025 - Current Session)
- ✅ Created separate `/quote` page (`resources/templates/quote.html.twig`)
- ✅ Added route `/quote` in `public/index.php`
- ✅ Added `quotePage()` method in `MainController.php`
- ✅ Updated all "Get Free Quote" links from `#quote` to `/quote`
- ✅ Updated navigation header link to `/quote`
- ✅ Updated Price modal links to `/quote`
- ✅ Removed embedded quote form from main page
- **Result:** Main page template reduced from 475 lines to 246 lines (~48% reduction)
- **Expected impact:** Smaller DOM, faster initial load, better PageSpeed score

### Buttons Fix Verification (Dec 9, 2025)
- ✅ Verified "Call me back" button works (opens Quick Quote modal)
- ✅ Verified "Price" button works (opens Price modal)
- **Note:** Previous issue was likely browser/CDN caching, not code bug

### Previous Performance Optimizations
- ✅ Self-hosted Inter fonts with latin subsets
- ✅ Fixed CSS animations to reduce CLS
- ✅ Deferred FontAwesome and Facebook Pixel loading
- ✅ Optimized CSS transitions (specific properties vs `transition: all`)
- ✅ Updated minified assets (.min.css, .min.js)

### Repository Cleanup
- ✅ Fixed `.gitignore` to properly exclude `vendor/` and `.emergent/`
- ✅ Removed old zip archives

### Admin Panel Optimization
- ✅ Removed unused font formats (SVG, EOT) - ~1.7MB saved
- ✅ Compressed admin background images - ~328KB saved
- **Total savings: ~2MB**

### reCAPTCHA Lazy Loading
- ✅ reCAPTCHA loads only when user interacts with form
- ✅ Implemented on both main template and quote page
- **Expected impact:** Reduced TBT (Total Blocking Time)

## Current Status: USER VERIFICATION PENDING

The user needs to run a new Google PageSpeed Insights test to verify:
1. Performance score improvement (target: 80+)
2. CLS score improvement (target: < 0.1)
3. TBT reduction from reCAPTCHA optimization
4. All functionality works (forms, modals, Telegram notifications)

## API Endpoints
- `GET /quote` - Quote form page (NEW)
- `POST /quick-quote` - Quick quote form submission
- `POST /applications` - Full application submission
- `POST /upload/photos` - Photo upload
- `DELETE /upload/photos` - Photo deletion
- `GET /admin/login` - Admin login page
- `POST /admin/login` - Admin authentication

## Environment Variables (.env)
```
PROJECT_NAME=cgc_landing
DEV_MODE=1
DB_CONNECTION=pdo_mysql
DB_HOST=localhost
DB_DATABASE=db
DB_USERNAME=username
DB_PASSWORD=password
TG_TOKEN=[telegram_bot_token]
TG_CHANNEL=[telegram_channel_id]
```

## Pending Tasks

### P0 - Critical
- [ ] User to verify PageSpeed scores (mobile & desktop) after quote separation
- [ ] User to confirm all functionality works on production

### P1 - Important
- [ ] Re-implement button animations (pulsing effects) with GPU-accelerated CSS if user wants them back
- [ ] Optimize images (logo.webp, social-robot.webp) to actual display sizes

### P2 - Future/Backlog
- [ ] Move FAQ section to separate `/faq` page (further DOM reduction)
- [ ] Add `font-display: swap` to FontAwesome CSS import
- [ ] Clean up JavaScript code (remove unused quote-mode logic)

## Known Working Features
- ✅ Main homepage with all sections
- ✅ Quote form on separate `/quote` page
- ✅ "Call me back" button and modal
- ✅ "Price" button and modal
- ✅ Navigation between pages
- ✅ Service cards linking to service pages
- ✅ Cities modal
- ✅ CGC Robot contact widget
- ✅ Mobile responsive layout

## 3rd Party Integrations
- Telegram API (for form notifications)
- Google reCAPTCHA (form validation - now lazy loaded)
- Facebook Pixel (deferred loading implemented)
