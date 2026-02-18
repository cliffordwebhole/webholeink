---
title: Search
description: Static full-text search system in WebholeInk
date: 2026-02-18
draft: false
---

# Search System

WebholeInk includes a lightweight static full-text search engine.

It requires **no database** and performs fast in-memory matching using a prebuilt JSON index.

## How It Works

1. Content is scanned from:
   - `/content/posts`
   - `/content/pages`
   - `/content/docs`

2. The CLI tool builds: public/storage/search-index.json

3. `/search?q=term` loads the index and performs weighted matching:
   - Title matches = higher weight
   - Body matches = lower weight
   - Multi-word queries supported

## Build the Index

Run inside the project root:
```
php bin/build-search-index.php
```

This will:
Scan markdown files
Extract front matter
Convert markdown to plain text
Generate excerpt descriptions
Sort by date
Write search-index.json

## Search Route
/search?q=linux

### The handler:
app/Http/Handlers/SearchHandler.php

## Index Structure
Each indexed item contains:
```
{
  "type": "posts|pages|docs",
  "title": "Post Title",
  "slug": "post-slug",
  "url": "/posts/post-slug",
  "date": "2026-01-01",
  "description": "Excerpt",
  "text": "Full plain text body"
}
```
## Why Static Search?

- No database
- No indexing service
- No third-party dependency
- Works on shared hosting
- Fast for small/medium sites
- Fully portable

## Limitations

- No fuzzy matching
- No stemming
- Index must be rebuilt after content updates

## Future Enhancements

- Result highlighting
- Pagination
- API endpoint /api/search
- Automatic index rebuild hook
- Tag-based filtering
