---
title: Changelog
description: WebholeInk documentation
draft: false
---

# CHANGELOG.md

All notable changes to **WebholeInk** will be documented in this file.

This project follows a **human-readable changelog**, not automated noise.
Only changes that affect behavior, operators, or content are recorded.

---

## [v0.1.0] – 2026-01-06

### Core

- File-first publishing system stabilized
- Markdown + front matter parsing locked
- No database, no runtime writes
- Deterministic routing for pages and posts

### Pages

- Static pages resolved from `content/pages/*.md`
- Home page mapped explicitly to `/`
- Front matter controls title, description, navigation order
- Markdown rendered server-side only

### Posts

- Posts resolved from `content/posts/*.md`
- Slug is authoritative (filename is irrelevant)
- Draft posts excluded via `draft: true`
- Stable post index at `/posts`
- Canonical URLs enforced

### Metadata & SEO

- `<title>` and `<meta description>` unified across site
- Canonical URLs added to all pages and posts
- Open Graph metadata implemented
- Twitter card metadata implemented
- Default OG image support
- Robots meta headers enforced

### Feeds

- RSS feed available at `/feed.xml`
- JSON Feed v1.1 available at `/feed.json`
- Feeds exclude drafts by design
- Descriptions sourced from front matter

### Sitemap & Crawling

- Sitemap available at `/sitemap.xml`
- Draft content excluded
- robots.txt added and aligned with sitemap

### HTTP & Caching

- ETag support enabled
- Last-Modified support enabled
- Conditional requests (`304 Not Modified`) verified
- Cache-Control set to `must-revalidate`
- Browser caching behaves correctly by design

### Security Headers

- Content-Security-Policy enforced
- X-Content-Type-Options enabled
- X-Frame-Options set to DENY
- Referrer-Policy configured
- Permissions-Policy locked down
- X-Robots-Tag enforced

### CLI

- Minimal CLI introduced
- `post:new` command creates posts with front matter
- CLI remains optional and non-required

### Architecture

- Clear separation of:
  - Resolvers
  - Handlers
  - Views
  - Content
- No plugins
- No magic behavior
- No background processes

---

## [Unreleased]

### Planned

- Metadata polish v3 (author, tags, reading time)
- Optional OpenGraph per-post images
- Content validation command
- Export tooling (static snapshot)
- Multi-site support (long-term)

---

## Versioning Policy

- **0.x**: Architecture stabilization
- **1.0**: API + content contract frozen
- Breaking changes are avoided once content contracts are declared stable

---

## Philosophy

If a change:
- Is not observable
- Does not affect content
- Does not affect operators

It does not belong in this file.
