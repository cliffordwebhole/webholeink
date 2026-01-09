---
title: Themes
description: WebholeInk documentation
draft: false
---

# THEMES.md (Contract)

Themes define presentation only.

## Theme location
- Theme source: `app/themes/<theme>/`
- Public assets: `public/themes/<theme>/assets/`

## Active theme
- Selected via `config/theme.php`
- Default: `default`

## Required theme files (v0.1.x)
- `layout.php` — wraps page output and includes navigation/footer
- `navigation.php` — renders navigation menu
- `home.php` — template for home page
- `page.php` — template for content pages
- `footer.php` — footer markup
- `theme.php` — optional theme metadata

## Rendering rules
- Core supplies page body HTML as a string
- Theme templates must not access core internals directly
- Templates only use variables passed by View/PageView

## Contract lock
Any change to required files or rules requires doc update first.
