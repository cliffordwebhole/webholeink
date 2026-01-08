# Writing & Content Style Guide 

This document defines **how content should be written, structured, and maintained** in WebholeInk. It is not about creativity. 

It is about **clarity, longevity, and consistency**. 

--- 

## Core Principles WebholeInk content should be: 
- Clear over clever 

- Durable over trendy 

- Explicit over implicit

 - Boring over optimized 

- Written for humans first Content is expected to age well.
 ---
##  File Structure

### Pages 

content/pages/{slug}.md

Examples: - `home.md` - `about.md` - `philosophy.md` 

### Posts 
content/posts/{date}-{slug}.md

Example: 2026-01-04-core-stable.md

The filename is informational only. The **front matter slug is authoritative**. 

--- 

###  Front Matter (Required) All pages and posts **must** begin with YAML front matter. 

### Minimum Required Fields

title: Hello World

description: Short summary of the content 

--- 
# Front Matter (Posts)

Recommended full post example:

--- 
title: Core Stable Release 

description: WebholeInk v0.1.0 core stable release 

excerpt: The first stable release of the WebholeInk engine.

date: 2026-01-04 

updated: 2026-01-05 

slug: core-stable draft: false 

--- 
# Field Definitions
| Field | Purpose |
|---|---|
| title | Display title (required) |
| description | SEO / feed summary (required) |
| excerpt | Optional shorter summary |
| date | Original publish date |
| updated | Last meaningful update |
| slug | Canonical URL identifier |
| draft | true excludes from index, feeds, sitemap |

# Front Matter (Pages)


Recommended page example:

--- 
title: Philosophy 

description: About WebholeInk's philosophy 

nav: true 

nav_order: 3 
--- 


# Page-Specific Fields
| Field | Purpose |
|---|---|
| nav | Include page in navigation |
| nav_order | Ordering in navigation |
 
# Headings

### Rules
• One # heading per document

• Use headings to structure, not decorate

• Do not skip levels

Correct:
```
# Title 

## Section 

### Subsection 

Incorrect:

# Title 

### Subsection 
```
# Paragraphs

• Keep paragraphs short

• One idea per paragraph

• Prefer blank lines over inline formatting

Good:
This is a single idea. 

This is a second idea. 

Avoid walls of text.

# Lists
Use lists for clarity, not filler.

- Minimal by design 

- Secure by default 

- File-first 

Avoid excessive nesting.

Emphasis
Use emphasis sparingly.

• **bold** for importance

• _italic_ for light emphasis

Avoid:

• ALL CAPS

• Emoji

• Decorative formatting

# Links

Use descriptive link text.

Good:

See the [deployment guide](DEPLOYMENT.md). 

Avoid:

Click here. 

# Code Blocks

Always specify language where possible.

```
php app/cli/webholeink.php post:new "Hello World" 

```

Code blocks must be copy-paste safe. 

--- 

## Tone & Voice WebholeInk content should sound: 

- Calm

 - Confident 

- Direct 

- Opinionated but reasoned

Avoid: 

- Marketing language

 - Hype - Growth talk

 - Calls to action 

This is documentation and publishing

 — not promotion. 

--- 

## SEO & Metadata Expectations

 - Titles should be descriptive, not clever

 - Descriptions should summarize, not tease

 - Do not keyword stuff

 - Metadata should reflect reality Metadata exists to **describe**, not manipulate.

 --- 

## Drafts To hide unfinished work:

 draft: true 

Drafts:

• Do not appear in /posts

• Do not appear in feeds

• Do not appear in sitemap

Removing draft: true publishes the content.

# Editing & Updates

When making meaningful changes:

• Update the updated field

• Preserve original intent

• Do not rewrite history unnecessarily

Minor typo fixes do not require updated.

# What Not To Do

Do not:

• Embed tracking scripts

• Reference external CMS platforms

• Write platform-dependent instructions

• Assume reader ignorance

• Over-explain obvious concepts

# Final Rule

If content feels:

• Fragile

• Trend-driven

• Optimized for algorithms

• Designed for engagement

It does not belong here.
