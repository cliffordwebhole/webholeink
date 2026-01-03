# CONTENT.md (Contract)

This document defines content resolution rules in WebholeInk v0.1.x.

## Content roots
- Pages live under: `content/pages/`
- Navigation data lives under: `content/navigation.php`
- Posts/media are reserved for future use

## Page resolution
- URL path `/` maps to `content/pages/home.md`
- URL path `/about` maps to `content/pages/about.md`
- URL path `/philosophy` maps to `content/pages/philosophy.md`

## Slug rules
- Lowercase recommended
- One file per slug: `{slug}.md`
- No nested directories required in v0.1.x

## Markdown rendering
- Markdown is converted to HTML via Parsedown
- Raw HTML inside markdown is permitted unless explicitly restricted later

## Not found
If resolved file does not exist:
- return 404 via PageHandler

## Contract lock
Any change to these rules must update this doc first.
