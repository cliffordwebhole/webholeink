# CONTENT.md
WebholeInk Content Contract (LOCKED)

Status: **Stable**
Version: **v0.1.0-core**
Audience: Core maintainers and contributors

---

## Purpose

This document defines the **content model and rules** for WebholeInk.

Content behavior described here is **intentional, minimal, and locked**.
Any deviation requires a documented design decision and version bump.

WebholeInk is a **file-first publishing engine**.
Markdown files are the single source of truth.

---

## Content Directory Structure
content/ ├── pages/ │   ├── home.md │   ├── about.md │   ├── philosophy.md │   └── *.md ├── posts/        (reserved for future use) ├── media/        (static assets) └── navigation.php (optional legacy/manual override)
Only `content/pages/*.md` are treated as routable pages.

---

## Page Resolution Rules

- Each file in `content/pages/` represents **one page**
- Filename (without `.md`) becomes the URL slug
- Examples:
  - `about.md` → `/about`
  - `philosophy.md` → `/philosophy`
  - `home.md` → `/` (special case)

Routing is **static and deterministic**.
There are no dynamic parameters or database lookups.

---

## Home Page Rules (Special Case)

`home.md` is a **content file**, not hardcoded HTML.

- It **must** exist
- It resolves to `/`
- It is rendered using the same pipeline as all other pages
- It may appear in navigation if configured

There is **no separate “home template logic”**
beyond view selection.

---

## Markdown File Format

Each page **must** be valid Markdown.

Optional front matter is supported.

### Front Matter Format

```yaml
---
title: Page Title
description: Meta description text
nav: true
nav_order: 10
---
```
Front matter is optional but strongly recommended.
## Front Matter Fields

title (string, optional)
Used for:
<title> tag
Navigation label (fallback)
If omitted:
Navigation falls back to slug-based label
<title> falls back to site default
description (string, optional)
Injected into <meta name="description">
If omitted:
No description tag is rendered
nav (boolean, optional)
Controls navigation visibility
true → page appears in navigation
false or omitted → page is hidden
nav_order (integer, optional)
Lower numbers appear first
Default: 999
Navigation is always sorted numerically

## Navigation Generation Rules

Navigation is derived from content, not hardcoded.
Only pages with nav: true appear
Ordering is determined by nav_order
Labels are resolved in this order:
title
Slug (capitalized)
Navigation is rendered globally via the Layout.

## Rendering Pipeline (Guaranteed Order)

1.Markdown file is read
2.Front matter is parsed (if present)
3.Markdown body is converted to HTML
4.View renders page template
5.Layout wraps content
6.Navigation is injected
7.<head> metadata is injected
No step mutates content unexpectedly.

## What Content Does NOT Do (By Design)

❌ No shortcodes
❌ No embedded PHP
❌ No dynamic queries
❌ No automatic formatting beyond Markdown
❌ No database writes
❌ No runtime mutation

If you need those, this is the wrong system.

## Stability Guarantee
Content behavior defined in this document is stable.
Breaking changes require:
Contract update
Version bump
Explicit migration note


## Philosophy
Content should outlive software.
WebholeInk treats Markdown as archives, not features.
If this contract feels restrictive — good. That’s the point.
