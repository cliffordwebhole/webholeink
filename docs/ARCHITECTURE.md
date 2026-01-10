# WebholeInk Architecture
WebholeInk is a minimal, file-first publishing engine designed for long-term stability,

transparency, and ownership.

It intentionally avoids databases, plugins, admin panels, and background jobs.

Every decision favors predictability over convenience and durability over features.

This document describes how WebholeInk works, why it is designed this way, and what
it deliberately does not do.

# Core Philosophy
WebholeInk is built on a few non-negotiable principles:

File-first: Content lives as Markdown files on disk

No database: Nothing to migrate, corrupt, or optimize

Server-rendered: HTML is generated on request

Explicit behavior: No magic, no hidden state

Boring technology: PHP, Nginx, Markdown

Operator trust: Assumes the user understands their server
WebholeInk is not a platform.

It is infrastructure for publishing.

# High-Level Request Flow

Every request follows the same predictable path:

Client

  ↓
  
NGINX / OpenResty

  ↓
  
public/index.php

  ↓
  
Router

  ↓
  
Handler

  ↓
  
View

  ↓
  
Layout

  ↓
  
HTML Response


There are no background workers, queues, or async layers.

# Entry Point

public/index.php

• Bootstraps the application
• 
• Creates the Request object
• 
• Dispatches the request to the router
• 
• Returns a Response


This file does not contain business logic.

# Routing

app/Http/Router.php

Routing is explicit and minimal.

Routes are resolved by path inspection, not regex tables or middleware stacks.

Examples:

• / → Page handler (home)
• 
• /about → Page handler
• 
• /posts → Posts index handler
• 
• /posts/{slug} → Single post handler
• 
• /feed.xml → RSS feed handler
• 
• /feed.json → JSON Feed handler
• 
• /sitemap.xml → Sitemap handler

If a route does not match, a controlled 404 response is returned

# Handlers (Controllers)

Handlers live in:

app/Http/Handlers/ 

Each handler has one responsibility and returns a Response.

# Key Handlers

### PageHandler 
 
• Resolves Markdown pages

• Renders static pages (/about, /philosophy, /)

### PostsHandler 

• Builds the posts index

### PostHandler 

• Renders individual posts

### FeedHandler 

• Generates RSS (feed.xml)

### FeedJsonHandler 

• Generates JSON Feed (feed.json)

### SitemapHandler 

• Generates sitemap.xml

Handlers do not:

• Access globals directly

• Output HTML

• Perform Markdown rendering inline

 # Content Resolution Pages
Pages live in:

content/pages/*.md 

Handled by: WebholeInk\Core\PageResolver 

PageResolver returns:

• slug

• meta (front matter)

• body (raw Markdown)

Markdown rendering happens after resolution, inside the handler.

# Posts
Posts live in: content/posts/*.md 

Handled by: WebholeInk\Core\PostResolver 

# Draft Handling
Draft logic is explicit and conservative:

draft: true 

• Only posts with draft: true are excluded

• Missing draft defaults to published

• There is no implicit publish state

This ensures old content does not disappear accidentally.

D Markdown Processing
Markdown parsing is centralized in: WebholeInk\Core\Markdown 

Responsibilities:

• Parse front matter

• Convert Markdown → HTML

• Return structured output: 

• meta

• html

Handlers never parse Markdown themselves.


# Views & Templates
Templates live in: app/themes/default/ 

Examples:

• page.php

• post.php

• posts.php

Views receive already-processed data:

• Title

• Description

• Canonical URL

• HTML content

Templates do not:

• Read files

• Parse Markdown

• Apply business logic

# Layout System

### WebholeInk\Core\Layout

Layout is responsible for:

• HTML document structure

• <head> metadata

• SEO tags

• Open Graph tags

• Twitter cards

• Navigation

• Stylesheet linking
• 
All metadata is passed explicitly from handlers.
There is no global state.

# Metadata Flow
Metadata originates in front matter, flows through the system unchanged, and is rendered in the layout.

Markdown Front Matter 

↓ Resolver 

↓ Handler 

↓ View 

↓ Layout 

↓ HTML <head> 

Supported metadata includes:

• title

• description

• date

• updated

• slug

• draft

• navigation flags

# Navigation

Navigation is built from page metadata:

nav: true nav_order: 2 

Only pages that opt-in appear in navigation.

Navigation logic lives in: WebholeInk\Core\Navigation 

There is no auto-discovery or guessing.

# HTTP & Caching Model

Responses support:

• ETag

• Last-Modified

• Conditional requests (304 Not Modified)

• Explicit cache control

Caching is deterministic and content-based.

No application-level cache store exists.

# Feeds & Sitemap

WebholeInk generates feeds dynamically:

• RSS 2.0 (/feed.xml)

• JSON Feed v1.1 (/feed.json)

• Sitemap (/sitemap.xml)

All are built from the same resolvers used by pages and posts.

There is no duplication of logic.
---

# Static Assets & Images

WebholeInk enforces a strict separation between **content** and **runtime assets**.

### Non-Negotiable Rule

**All images and static media MUST live under the `public/` directory.**

public/ media/

Anything outside `public/` is not web-accessible and will never be served.

---

### Rationale

The web server is configured with:

root /var/www/webholeink/public;

This is intentional.

It guarantees that:

- Only explicitly exposed files are reachable
- Markdown content is never executed or served directly
- Static assets are handled by the web server, not PHP
- The system remains auditable and predictable

---

### Content vs Assets

| Directory | Purpose | Served by Web Server |
|---------|--------|----------------------|
| `content/` | Markdown source files | ❌ No |
| `public/` | CSS, images, feeds, entry point | ✅ Yes |

Markdown files may **reference** images, but must never **contain** them.

---

### Image Referencing Contract

Images are referenced using absolute paths from the web root:

```
![Example](/media/pages/example.png)

```
No rewriting, copying, or transformation occurs at runtime.
---

## Rendering Responsibility

WebholeInk does not manage image size, layout, or presentation.

All visual behavior is handled by the active theme:
```
main img {
    max-width: 640px;
    height: auto;
}
```
Content remains semantic. Presentation remains centralized.


---

## Explicit Non-Goals

WebholeInk will never:
- Scan content/ for images
- Auto-copy files into public/
- Resize or optimize images
- Provide a media upload pipeline
- Maintain a media registry

These are platform features. WebholeInk is infrastructure.


---

## Architectural Guarantee

This rule will not change without a major version bump.
Static assets live in public/.
Content lives in content/.
There is no overlap by design.

---

### Why this matters

This single rule:

- Prevents entire classes of security bugs
- Eliminates “magic” media behavior
- Keeps deployments boring
- Makes Docker, rsync, and backups trivial

This is **exactly** the kind of constraint that makes WebholeInk durable.

If you want, next we can:
- Add a **one-line reference** in `CONTENT.md`
- Add a **migration note** in `UPGRADE.md`
- Or cut a **v0.1.3 patch** purely for docs hardening

Your call, architect 🧱
# What WebholeInk Does NOT Do

WebholeInk intentionally does not include:

• Databases

• Admin panels

• WYSIWYG editors

• Plugins or extensions

• Themes marketplace

• Users or authentication

• Comments

• Search

• JavaScript frameworks

• Build steps

These are not missing features.

They are rejected features.

# Design Guarantees

WebholeInk guarantees:

• Content is readable without the application

• URLs are stable

• Rendering is deterministic

• Failure modes are obvious

• The system can be understood by reading the code

# Final Note
WebholeInk exists for people who value control over convenience.

If you want drag-and-drop editing, auto-updates, or growth features, this project is not for you.

If you want publishing infrastructure that you can still understand five years from now — welcome.







