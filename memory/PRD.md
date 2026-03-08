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

#### Schema.org Implementation - City Pages (COMPLETED)
- **17 City Pages:** Each city page now has unique Schema.org `@graph`:
  - `WebPage` with city-specific description
  - `Service` (Gutter Cleaning in [City])
  - `Offer` with `minPrice` based on page content
  - `BreadcrumbList` (Home > [City])

**City Pages with Schema:**
| City | minPrice | Notes |
|------|----------|-------|
| Burnaby | $150 | Эталон |
| Vancouver | $150 | |
| Surrey | $340 | Цена из контента страницы |
| Richmond | $150 | |
| Coquitlam | $180 | Цена из контента страницы |
| Delta | $180 | Цена из контента страницы |
| Langley | $150 | |
| North Vancouver | $150 | |
| West Vancouver | $180 | Цена из контента страницы |
| New Westminster | $180 | Цена из контента страницы |
| Maple Ridge | $150 | |
| Pitt Meadows | $150 | |
| Port Coquitlam | $150 | |
| Port Moody | $150 | |
| White Rock | $150 | |
| Ladner | $150 | |
| Tsawwassen | $150 | |

#### Schema.org Implementation - Service Pages (COMPLETED)
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
- `resources/templates/landing/services/*.html.twig` - 6 service pages with Schema.org
- `resources/templates/landing/cities/*.html.twig` - 17 city pages with Schema.org:
  - burnaby.html.twig, vancouver.html.twig, surrey.html.twig
  - richmond.html.twig, coquitlam.html.twig, delta.html.twig
  - langley.html.twig, north_vancouver.html.twig, west_vancouver.html.twig
  - new_westminster.html.twig, maple_ridge.html.twig, pitt_meadows.html.twig
  - port_coquitlam.html.twig, port_moody.html.twig, white_rock.html.twig
  - ladner.html.twig, tsawwassen.html.twig

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
