# Clean Gutters Crew - Product Requirements Document

## Project Overview
Marketing website for Clean Gutters Crew - a local exterior cleaning company serving Metro Vancouver, BC, Canada.

**Tech Stack:** PHP 8.2, FlightPHP, Twig, Vanilla JavaScript, CSS

## Core Services
1. Gutter Cleaning (from $150)
2. Window Washing (from $150)
3. Pressure Washing (from $200)
4. Moss Removal (from $400)
5. Junk Removal (from $150)
6. Handyman Services (from $120)

## Completed Features

### December 2025

#### Schema.org Implementation (COMPLETED)
- **Main Page:** Complete `@graph` with LocalBusiness, WebSite, WebPage, FAQPage (14 questions), and 6 Service definitions
- **Service Pages:** Each of 6 service pages now has unique Schema.org:
  - `WebPage` with unique description
  - `Service` with detailed service description
  - `Offer` with correct `minPrice` for each service
  - `FAQPage` with service-specific questions only
  - `BreadcrumbList` (Home > Services > [Service Name])

#### FAQ Distribution by Service Page:
- **Gutter Cleaning:** 5 FAQs (duration, frequency, cost, inclusions, roof leaks)
- **Window Washing:** 1 FAQ (interior/exterior cleaning)
- **Moss Removal:** 1 FAQ (safety for roof)
- **Pressure Washing:** No page-specific FAQ (general info in content)
- **Junk Removal:** No page-specific FAQ (general info in content)
- **Handyman Services:** No page-specific FAQ (general info in content)

### Previous Session (Completed)
- Full Technical & Security Audit
- CSRF protection on all forms
- Server-side rate limiting
- Toast notifications (replaced alert())
- CSS consolidation (main-page.css)
- Dynamic portfolio sidebar with lightbox
- Sticky mobile menu improvements
- Hover animations on cards/links

## Architecture

```
/app/
├── app/Controllers/         # PHP Controllers
├── app/Middleware/          # CSRF, Rate Limiting
├── app/Twig/               # Custom Twig extensions
├── public/                 # Web root
│   ├── assets/css/         # Stylesheets
│   ├── assets/js/          # JavaScript
│   └── index.php           # Router
└── resources/templates/    # Twig templates
    ├── template.html.twig  # Main page base
    ├── page.html.twig      # Service pages base (with {% block schema %})
    └── landing/services/   # 6 service page templates
```

## Key Files Modified This Session
- `resources/templates/page.html.twig` - Added `{% block schema %}` support
- `resources/templates/landing/services/gutter_cleaning.html.twig` - Schema.org added
- `resources/templates/landing/services/window_washing.html.twig` - Schema.org added
- `resources/templates/landing/services/pressure_washing.html.twig` - Schema.org added
- `resources/templates/landing/services/moss_removal.html.twig` - Schema.org added
- `resources/templates/landing/services/junk_removal.html.twig` - Schema.org added
- `resources/templates/landing/services/handyman_services.html.twig` - Schema.org added

## Backlog / Future Tasks

### P2 - Future Enhancements
- **Robot Animation:** Animate the social-robot.png mascot (movement, blinking, juggling icons)

### Technical Debt
- JavaScript files (app.js, page-city.js) could benefit from modularization

## Integration
- **Telegram API:** Form submissions sent to Telegram channel

## Environment
- TG_TOKEN and TG_CHANNEL configured in .env
- PHP built-in server for development
- No database required (static content)

## Testing Notes
- Schema validation recommended via Google Rich Results Test
- All 6 service pages have unique, valid JSON-LD schemas
- Main page schema includes complete LocalBusiness + FAQPage
