# CONTENT.md  
_WebholeInk Content Contract (v1 — Locked)_

## Purpose

Content in WebholeInk is **file-based, deterministic, and explicit**.

All published output is derived from files stored on disk.
There is no database, no admin UI, and no hidden state.

Content is divided into **three distinct types**:

- Pages
- Posts
- Navigation data

Each type has strict rules and responsibilities.

---

## Content Root

All content MUST live under: /content
Subdirectories define content type.

---

## Content Types Overview

| Type | Path | Purpose |
|----|----|----|
| Pages | `content/pages/` | Timeless site pages |
| Posts | `content/posts/` | Time-based published entries |
| Navigation | `content/navigation.php` | Menu configuration |

No other content roots are permitted in v1.

---

## Pages
Location = content/pages/
### Purpose

Pages represent **timeless, stable site content**.

Examples:

- Home
- 
- About
- 
- Philosophy
- 
- Legal pages

Pages are not chronological.
---

### Page Routing

| URL | File |
|----|----|
| `/about` | `content/pages/about.md` |
| `/philosophy` | `content/pages/philosophy.md` |

---

### Page Front Matter

Pages MAY include front matter.

```yaml
---
title: About
description: About WebholeInk
nav: true
nav_order: 10
---
```
Pages without front matter are valid but discouraged.
## Supported Fields
| Field | Purpose |
|----|----|
| title | <title> and page heading |
| description | Meta description |
| nav |Include in navigation |
| nav_order | Navigation sort order |

---
## Posts
Location -> content/posts/

Posts are time-based, publishable entries intended for chronological reading and long-form writing.
Posts are not pages.

## Post Filenames
Posts MUST follow this format:YYYY-MM-DD-slug.md

Example:2026-01-03-core-stable.md

The date is used for sorting. The slug is used for routing.

## Post Routing
|URL | Source |
|----|----|
| `/posts` | Posts index |
| `/posts/core-stable` | Single post |
The filename date is never exposed in the URL
---
## Required Post Front Matter
title: Core Stable Release

date: 2026-01-03

published: true

description: WebholeInk v0.1.0 is now stable

Posts with published: false are not routable.

## Post Visibility Rules 
published: true → visible and routable

published: false → hidden, returns 404

There is no draft preview in v1.

## Navigation Data
content/navigation.php

## Purpose
Navigation data defines the primary site menu.

Navigation MAY be: Explicit (manual array)

Automatically generated from Pages (v1 enhancement)

Posts are not included in navigation by default.

## Markdown Parsing
All content files are Markdown.

Parsing rules:

Front matter is extracted first

Markdown body is parsed after front matter removal

HTML output is escaped where appropriate

Parsed HTML is passed to the view layer

No Markdown extensions are enabled beyond standard syntax.

## Rendering Flow (All Content)

Resolve file

Parse front matter

Validate required fields

Parse Markdown → HTML

Inject metadata (title, description)

Render via theme templates

Wrap in Layout

Every step is required.

## What Content Does NOT Include (v1)
Tags

Categories

Search

Pagination

RSS feeds

Comments

Media management UI

Any additions require:

New contract

Version bump

Explicit approval

## Stability Guarantee
This contract is LOCKED for v1.
Changes require:
Documentation update
Versioned decision
Intentional break acknowledgment
Silent behavior changes are prohibited.

