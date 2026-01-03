# ROUTER.md (Contract)

This document defines routing behavior in WebholeInk v0.1.x.

## Supported verbs
- GET only.

## Path normalization
- Paths are normalized to a leading `/`
- Trailing slashes do not create separate routes
- Empty path resolves to `/`

## Route registration
- Explicit routes are registered in `public/index.php`
- Explicit routes take precedence over fallback content routing

## Fallback routing
- When enabled, any non-matched path MAY fall back to PageHandler/content routing
- Fallback must be explicit in Router (no hidden magic)

## 404 behavior
If no explicit route matches AND fallback routing cannot resolve content:
- Return a 404 Response
- Theme layout still renders (consistent UX)

## Non-goals
- Regex routes
- Route parameters
- Method overrides
- Middleware

## Contract lock
Any change to these rules requires updating this document first.
