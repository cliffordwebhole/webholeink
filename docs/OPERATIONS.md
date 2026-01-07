# Purpose

This document describes **how to operate, maintain, and troubleshoot WebholeInk**
in a production environment.

It is written for operators who value:

- Predictability

- Minimalism

- File-first control

- Zero magic

This is **not** a marketing document.

---

# Supported Operating Model

WebholeInk is designed to run as:

- A **single PHP application**

- Behind **Nginx / OpenResty**

- With **no database**

- Using **Markdown files on disk**

- Deployed via **Git + pull requests**

If your setup requires background workers, queues, or databases,
you are outside the supported model.

---

# Directory Layout (Operational View)

/var/www/webholeink/
├── app/                 # Application code (read-only in prod)

├── content/             # Markdown content (source of truth)

│   ├── pages/

│   └── posts/

├── public/              # Web root

│   ├── index.php


│   ├── feed.xml

│   ├── feed.json

│   ├── sitemap.xml

│   └── robots.txt

├── nginx/               # Reference configs (not live state)

└── logs/                # Optional (if enabled)

### Rule:

If it’s not in content/, it is not content.

# Deployment Workflow (Recommended)

1.Make changes locally

Edit Markdown files

Edit PHP code

Run local smoke tests

2.Commit via feature branch

```
git checkout -b feature/my-change
git commit -am "Describe the change"
```

3.Open a Pull Request

All changes should flow through PRs

Even solo projects benefit from review history

4. Merge to main

main represents production

Tags represent releases

5. Deploy via pull

```
git pull origin main
```
No build step required.

# Content Operations

Creating Pages

Location: content/pages/*.md

Filename defines the route

home.md maps to /

Example front matter:

```
---

title: About

description: About WebholeInk

nav: true

nav_order: 2

---
```
# Creating Posts

Location: content/posts/*.md

Slug must be explicit


```
---
title: Core Stable Release

description: WebholeInk v0.1.0 core stable release

date: 2026-01-04

slug: core-stable

draft: false

---
```
### Draft Handling

draft: true → excluded everywhere

Absence of draft → treated as published

No implicit publishing rules

# Feeds & Indexes

WebholeInk exposes:

/posts – HTML index

/feed.xml – RSS 2.0

/feed.json – JSON Feed v1.1

/sitemap.xml – XML Sitemap

Feeds:

Exclude drafts

Sort by date DESC

Use front-matter metadata only

# Caching Behavior

HTTP Headers

WebholeInk emits:

ETag

Last-Modified

Cache-Control: public, must-revalidate

# Operator Expectations

Browsers will cache aggressively

Private tabs bypass cache

curl with conditional headers validates correctness
Example:

```
curl -I https://webholeink.org/about
```
```
curl -I \
  -H 'If-None-Match: "etag-value"' \
  https://webholeink.org/about
```
304 Not Modified is expected behavior.

# Browser Cache Invalidation (Operator)

When testing changes:

Hard refresh: Ctrl + Shift + R

Or disable cache in DevTools

Or use private/incognito window

This is not a bug.

# Logging & Errors

PHP Errors

Fatal errors halt request

Output is deterministic

No recovery layers

Recommended:

Enable error logging

Disable display errors in production

# 404 Handling

Pages and posts return themed 404s

Correct HTTP status is preserved

#Security Model

WebholeInk assumes:

HTTPS is terminated upstream

Nginx/OpenResty handles TLS

PHP runs with minimal permissions

Built-in protections:

No user input persistence

No uploads

No authentication surface

No admin panel


# Backup Strategy

What to Back Up

content/

Git repository

### What NOT to Back Up

Generated feeds

Sitemap

Cache headers

Vendor state

A simple Git mirror is sufficient.

# Upgrades

Safe Upgrade Path

Pull latest main

Review CHANGELOG / PRs

Test locally

Deploy

There are no migrations.

#Anti-Goals (Operational)

WebholeInk explicitly avoids:

Background workers

Cron jobs

Queue systems

Cache invalidation layers

Runtime configuration mutation

Web-based administration

If you need those, use a different tool.

# Operator Responsibility

You are responsible for:

Server security

TLS configuration

DNS

Backups

Monitoring

WebholeInk handles publishing, not infrastructure.

# Final Note

If you can’t explain your deployment on a whiteboard, it’s too complicated.
WebholeInk exists so your words outlive your stack.
