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
