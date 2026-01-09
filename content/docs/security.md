---
title: Security
description: WebholeInk documentation
draft: false
---

# SECURITY.md

## Security Policy

WebholeInk is designed to be **secure by architecture**, not by add-ons.

There is:
- No database
- No user authentication
- No plugins
- No remote execution
- No background workers
- No writable runtime state

Security vulnerabilities are therefore limited in scope by design.

---

## Supported Versions

Only the **latest release on `main`** is supported.

WebholeInk does not provide security backports for older versions.

| Version | Supported |
|--------|-----------|
| v0.x   | ✅ Yes (latest only) |
| < v0.x | ❌ No |

---

## Threat Model

WebholeInk assumes:

- The operator controls the server
- The operator controls file permissions
- The content directory is trusted input
- There are **no untrusted users**

This project is **not** intended for:
- Multi-tenant hosting
- User-generated content
- Admin panels
- Public write access

If you need those features, this is the wrong tool.

---

## Built-In Protections

### Architecture

- File-first content model (read-only at runtime)
- Deterministic routing
- No eval, no dynamic includes
- No template logic execution
- Explicit handler resolution

### HTTP Security

- Content Security Policy (CSP)
- X-Frame-Options: `DENY`
- X-Content-Type-Options: `nosniff`
- Referrer-Policy enforced
- Permissions-Policy locked down
- Robots directives explicitly set

### Content Handling

- Markdown rendered server-side
- HTML output escaped by default
- Front matter parsed deterministically
- Draft content excluded from:
  - Pages
  - Posts
  - Feeds
  - Sitemap

### Caching Safety

- ETag + Last-Modified support
- Conditional requests verified
- No shared mutable cache state

---

## Reporting a Vulnerability

If you believe you have found a security issue:

1. **Do not open a public issue**
2. **Do not disclose the issue publicly**

Instead, contact:

📧 **security@cliffordswebhole.com**

Please include:
- A clear description of the issue
- Steps to reproduce (if applicable)
- Expected vs actual behavior
- Any relevant logs or stack traces

You will receive an acknowledgment within **72 hours**.

---

## Disclosure Policy

- Valid security issues will be confirmed privately
- Fixes will be released before public disclosure
- Credit will be given unless anonymity is requested

---

## Non-Goals

The following are **explicitly out of scope**:

- CSRF protection (no forms, no state)
- SQL injection (no database)
- XSS via user input (no user input)
- Authentication bypass (no authentication)
- Role-based access control

---

## Final Notes

WebholeInk favors:
- Predictability over flexibility
- Transparency over abstraction
- Fewer features over larger attack surfaces

If a feature increases attack surface without improving reliability,
it will not be accepted.

Security is a property of **simplicity**.

---
