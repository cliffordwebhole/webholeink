---
title: Themes
description: WebholeInk Theme Documentation
draft: false
---

# THEMES.md (Contract)

WebholeInk uses a **two-layer CSS theming system** designed for stability,
clarity, and long-term maintainability.

Themes are **author-controlled**. Visitors cannot toggle themes.

---

## Theme Architecture

WebholeInk separates styling into two distinct layers:

### 1. Structural CSS (Engine-Controlled)
/public/themes/default/assets/css/style.css

This file defines:
- Layout
- Typography
- Spacing
- Navigation structure
- Image behavior
- Element selectors

This file **must not be modified for branding or color changes**.

---

### 2. Theme Variable CSS (Publisher-Controlled)
/public/themes/default/assets/css/theme-dark.v1.css
These files define **CSS variables only**:

- Colors
- Contrast
- Mood
- Brand identity

**No selectors are allowed** in theme files.

---

## Available Themes

Themes are defined and activated via configuration:
/app/config/theme.php
Example:

```php
<?php

return [
    'available' => ['classic', 'light', 'dark'],
    'default'   => 'classic',
    'active'    => 'dark',
];
```
Changing the active value immediately switches the site theme.
## Versioning Rules
- Theme files are versioned (.v1.css)
- Breaking visual changes require a version bump
- Old theme versions remain valid indefinitely

## Design Principles
- One theme per site
- No runtime theme switching
- No JavaScript
- No user preference storage
- Predictable rendering

WebholeInk themes are intentional, not interactive.

