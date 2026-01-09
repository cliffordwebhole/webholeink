---
title: Core
description: WebholeInk documentation
draft: false
---

# CORE.md (Contract)

This document describes the core architecture of WebholeInk v0.1.x.

## Core principles
- Minimal surface area
- File-based content (no database required)
- Explicit routing (no magic auto-discovery unless explicitly enabled)
- Predictable, testable behavior
- Themes are presentation-only

## Runtime flow (high level)
1. `public/index.php` defines `WEBHOLEINK_ENTRY` and loads:
   - `app/bootstrap.php`
   - `app/autoload.php`
2. A `Request` is created from globals.
3. `Router` registers explicit routes.
4. `Router` dispatches to a handler.
5. Handlers return a `Response`.
6. `Response->send()` renders output through the active theme layout.

## Core modules
- `Http/Request` — immutable request snapshot from globals
- `Http/Router` — GET-only routing and fallback routing rules
- `Http/Handlers/*` — request handlers returning Response
- `Http/Response` — status/headers/body; renders through Layout/theme
- `Core/PageResolver` — resolves route → content file
- `Core/Markdown` — converts markdown to HTML (Parsedown)
- `Core/ThemeLoader` — selects active theme
- `Core/View` / `Core/PageView` — safe template rendering

## Non-goals for v0.1.x
- Plugins / extensions system
- Database storage requirements
- Admin UI
- Dynamic route params
- Middleware pipelines

## Stability promise
Within v0.1.x:
- Contracts here are treated as stable unless explicitly revised.
- Behavior changes require updating docs first.
