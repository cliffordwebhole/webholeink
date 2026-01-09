---
title: Navigation
description: WebholeInk documentation
draft: false
---

# NAVIGATION.md (Contract)

Navigation is content-driven and theme-rendered.

## Data source
- `content/navigation.php` returns an array of items

## Item shape
Each item is an array with:
- `label` (string)
- `path`  (string)

Example:
- Home → `/`
- About → `/about`

## Rendering
- Theme renders nav markup
- Labels and paths must be escaped in HTML output

## Contract lock
Any change to data format or rendering expectations requires updating this doc first.
