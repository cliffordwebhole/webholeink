---
title: Handlers
description: WebholeInk documentation
draft: false
---

# HANDLERS.md (Contract)

Handlers are the only place where a Request becomes a Response.

## Handler contract
- Input: `WebholeInk\Http\Request`
- Output: `WebholeInk\Http\Response`
- No direct `echo`
- No header output
- No `exit/die`

## Responsibilities
- Validate request intent (v0.1: minimal)
- Choose content source (static HTML or markdown via PageResolver)
- Return Response with body + status + headers

## Non-goals (v0.1.x)
- Middleware-like behavior
- Authentication
- Sessions
- Admin actions

## Handler types (current)
- `HomeHandler` — renders home page (usually content/pages/home.md via PageResolver)
- `PageHandler` — resolves any content-backed page via PageResolver

## Errors
- Handlers should return a 404 Response for missing content
- Unexpected exceptions are allowed to bubble in v0.1 (debug-friendly)

## Contract lock
No behavior changes without updating this doc.
