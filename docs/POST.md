
# POSTS.md 
_WebholeInk Posts Contract (v1 — Locked)_ 

## Purpose Posts are time-based, publishable content entries in WebholeInk. They are designed for: - Long-form writing - Chronological publishing - Stable URLs - File-first ownership Posts are **not pages** and are treated as a distinct content type.
 --- 

## Directory Structure All posts MUST live in: /content/posts/
Example: 
content/posts/ ├── 2026-01-01-hello-world.md ├── 2026-01-03-core-stable.md └── *.md
No subdirectories are allowed in v1. 
--- 

## Filename Rules Each post filename MUST follow this format: 
YYYY-MM-DD-slug.md
---
### Rules - Date MUST be ISO-8601 (`YYYY-MM-DD`) - Slug MUST be lowercase - Words separated by hyphens - File extension MUST be `.md` 
Example  2026-01-03-core-stable.md

Resulting URL:  /posts/core-stable
The date prefix is **never exposed in the URL**.
 --- 

## Required Front Matter Every post MUST contain valid front matter. 
```yaml 
--- 
title: Core Stable Release date: 2026-01-03 
published: true 
description: WebholeInk v0.1.0 is now stable
---
```
## Required Fields
Field             Type                               Description
title           string                       Display title and<title>
date           YYYY-MM-DD                   Used for sorting and validation
published       boolean                          Controls visibility 
---
## Optional Fields (v1)
     Field                   Purpose
description        Meta description 
---
## Visibility Rules
• published: false 
• Post is NOT routable
• Post is NOT listed
• File may still exist for drafts
No preview URLs exist in v1.
---
## Routing Rules
Single Post
/posts/{slug} 
Conditions:
• File MUST exist
• published MUST be true
Otherwise:
• Return 404 Not Found
---
## Posts Index
/posts 
Behavior:
• Lists published posts only
• Sorted by date (newest → oldest)
• Displays: 
• Title
• Date
• Description (if present)
• URL
No pagination in v1.
---
## Rendering Pipeline
Posts follow the same rendering pipeline as Pages with additional validation.
• Resolve file from slug
• Parse front matter
• Validate required fields
• Parse Markdown → HTML
• Render post template
• Wrap in Layout
No step may be skipped.
---
## Sorting Rules
• Posts MUST be sorted by front matter date
• Filename date is ignored after slug resolution
• Invalid dates MUST result in a hard failure (500)
---
## What Posts Do NOT Include (v1)
• Tags
• Categories
• Pagination
• RSS feeds
• Comments
• Database storage
• Admin UI
Any of the above require:
• New contract
• Version bump
• Explicit approval
---
## Stability Guarantee
This contract is LOCKED for v1.
Changes require:
• Documentation update
• Version bump
• Explicit decision record
No silent changes are permitted.
