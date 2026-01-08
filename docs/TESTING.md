# TESTING.md

## WebholeInk Testing Philosophy

WebholeInk is designed to be predictable, boring, and auditable.

Testing exists to **protect invariants**, not to chase coverage metrics or simulate user behavior that WebholeInk explicitly does not support.

If a test does not protect a long-term guarantee, it does not belong here.

---

## What Testing Is For

Testing in WebholeInk exists to ensure:

- Content renders consistently
- Metadata contracts remain stable
- Routing behavior never changes silently
- File-based workflows continue to work
- Cache and feed behavior is correct
- Errors fail loudly and explicitly

---

## What Testing Is NOT For

WebholeInk does **not** test:

- UI interactions
- Browser-specific behavior
- User workflows
- Performance micro-optimizations
- Styling or visual layout
- Third-party integrations

Those concerns are outside the scope of this project.

---

## Core Invariants (Must Never Break)

The following invariants define WebholeInk.  
Any change that violates these **must not be merged**.

---

### 1. File-First Content

- All content lives on disk
- No database dependencies
- Markdown files are the source of truth
- Deleting a file deletes the content
- Moving a file moves the content

**Invariant:**  
If the filesystem is correct, the site is correct.

---

### 2. Deterministic Routing

- `/` maps to `content/pages/home.md`
- `/about` maps to `content/pages/about.md`
- `/posts/{slug}` resolves by front-matter `slug`
- No implicit redirects
- No guessing

**Invariant:**  
The same URL must always resolve the same content.

---

### 3. Explicit Metadata

Metadata must be:

- Declared in front matter
- Optional, but never inferred silently
- Passed explicitly to the layout
- Rendered consistently across pages and posts

Required metadata fields:
- `title`
- `description` (recommended)
- `date` (posts)
- `slug` (posts)

**Invariant:**  
Metadata is never guessed.

---

### 4. Draft Handling

- Posts marked `draft: true` are excluded
- Drafts never appear in:
  - Post index
  - Feeds
  - Sitemap
- Drafts may exist on disk indefinitely

**Invariant:**  
Draft content is invisible unless explicitly published.

---

### 5. Markdown Rendering

- Markdown must render to valid HTML
- Raw Markdown must never leak to output
- Front matter must never appear in output
- Markdown parsing errors must not corrupt layout

**Invariant:**  
Rendered HTML is always clean and predictable.

---

### 6. Layout Integrity

- Layout wraps content exactly once
- No nested layouts
- No duplicated `<html>`, `<head>`, or `<body>` tags
- Navigation is always rendered explicitly

**Invariant:**  
Each request produces a single, valid HTML document.

---

### 7. Caching Correctness

- `ETag` must reflect rendered output
- `Last-Modified` must reflect source file changes
- `304 Not Modified` must be honored correctly
- Cache headers must never hide updates

**Invariant:**  
Caches may optimize delivery, never correctness.

---

### 8. Feed Accuracy

Feeds must:

- Reflect published posts only
- Include correct URLs
- Include correct publication dates
- Include descriptions when available

Supported feeds:
- RSS (`feed.xml`)
- JSON Feed (`feed.json`)

**Invariant:**  
Feeds must never lie.

---

### 9. Sitemap Accuracy

- Sitemap must include:
  - Pages
  - Published posts
- Sitemap must exclude:
  - Drafts
  - Non-existent URLs
- URLs must be canonical

**Invariant:**  
The sitemap must match reality.

---

## Recommended Test Types

WebholeInk favors **simple, explicit tests**.

Recommended approaches:

### Manual Verification (Primary)

- `curl` for headers
- `curl` for content output
- File edits + refresh
- Cache revalidation checks

Example:
```bash
curl -I https://example.com/about
curl https://example.com/posts/example-post
