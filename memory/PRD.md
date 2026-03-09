# PRD: Cleaning Service Landing Page

## Original Problem Statement
Enhance and polish an existing cleaning service website built with PHP and Twig with focus on performance optimization (PageSpeed 80+), eliminating layout shifts, and UI polishing.

## User Language
Русский (Russian)

## Core Requirements
1. **Performance (P0):** PageSpeed 80+ mobile/desktop
2. **CLS Fix (P0):** Eliminate Cumulative Layout Shift
3. **UI Polish (P1):** Visual effects without performance degradation
4. **Structure (P2):** Split large pages for better performance

## Architecture
- **Backend:** PHP with FlightPHP, Twig templating
- **Frontend:** Vanilla JavaScript, CSS, HTML
- **No database**

## What's Been Implemented

### 2025-03-09
- [x] Fixed "Callback" and "Price" buttons
- [x] Moved Quote form to `/quote` page
- [x] Moved FAQ to `/faq` page
- [x] Fixed "Areas" modal on all pages
- [x] Fixed header button asymmetry
- [x] Removed redundant toast notification
- [x] Removed "Back to Home" buttons
- [x] Implemented scroll-to-top on navigation
- [x] Restored performant button animations
- [x] Adjusted form field spacing on `/quote`
- [x] Styled desktop header phone number
- [x] Changed mobile header button to orange with glow
- [x] Implemented scroll-based sticky button logic
- [x] CSS versioning (cache-busting) implemented
- [x] Removed CLS-causing block animations
- [x] Changed border color from yellow to #38BDF8 (blue)
- [x] **Fixed CLS-causing button animations** — removed `scale()` and `translate()` from:
  - `pulse` animation (header phone button)
  - `mobileGlowWiggle` animation (mobile Call button)
  - `btnPulseGreen` animation (Callback button)
  - `btnPulseOrange` animation (Price button)
- [x] Animations now use only `box-shadow` and `filter: brightness()` (CLS-safe)

## PageSpeed Optimization Done
- reCAPTCHA deferred loading
- Content split to separate pages
- GPU-accelerated animations (`box-shadow`, `filter`, `opacity` only)
- CSS minification
- Cache-busting with version parameters (`?v=20250309k`)

## Prioritized Backlog

### P0 (Critical)
- [x] Fix CLS issues - DONE
- [ ] Verify PageSpeed 95+ after user uploads new files

### P1 (Important)
- [ ] Image optimization (logo.webp, social-robot.webp)

### P2 (Nice to have)
- [ ] FontAwesome `font-display: swap`
- [ ] CSS cleanup (remove unused code)

## Key Files
- `resources/templates/template.html.twig` - Base template with CSS links
- `public/assets/css/style.css` & `.min.css` - Main styles
- `public/assets/css/main-page.css` & `.min.css` - Homepage styles
- `public/assets/css/page-city.css` & `.min.css` - City page styles
- `public/assets/js/app.js` & `.min.js` - JavaScript logic

## CLS-Safe Animation Guidelines
**DO use:** `box-shadow`, `filter`, `opacity`
**DON'T use:** `scale()`, `translate()`, `width`, `height`, `margin`, `padding`

## 3rd Party Integrations
- Telegram API (form notifications)
- Google reCAPTCHA (deferred)
- Facebook Pixel (deferred)

## Credentials
- TG_TOKEN and TG_CHANNEL in root `.env`
