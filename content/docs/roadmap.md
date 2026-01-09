---
title: Roadmap
description: WebholeInk documentation
draft: false
---

# ROADMAP.md

## WebholeInk Roadmap

WebholeInk is a deliberately constrained publishing system.
This roadmap reflects **intentional evolution**, not feature accumulation.

Stability is the primary feature.

---

## Guiding Principles

All roadmap decisions follow these rules:

- File-first, always
- No databases
- No plugins
- No telemetry
- No auto-magic
- No hidden state
- Explicit over clever
- Boring technology preferred

If a feature violates any of these principles, it does not belong on this roadmap.

---

## Versioning Policy

WebholeInk follows **semantic versioning**:

- **PATCH** — Bug fixes, security updates, documentation corrections
- **MINOR** — Backward-compatible enhancements
- **MAJOR** — Breaking changes (rare, deliberate, documented)

There is no fixed release cadence.
Releases happen when the system is stable.

---

## v0.1.x — Core Stabilization (Current)

**Status:** Active

Focus:
- Locking down core behavior
- Removing ambiguity
- Ensuring reproducibility

Planned work:
- Metadata polish (SEO, OpenGraph, feeds)
- Cache correctness and validation
- Feed stability (RSS + JSON)
- Sitemap correctness
- CLI usability improvements
- Documentation hardening

Non-goals:
- New content types
- UI customization
- Theming flexibility

---

## v0.2.x — Operational Maturity

**Status:** Planned

Focus:
- Running WebholeInk confidently in production
- Making failure modes explicit

Planned work:
- Health check endpoint
- Better error pages (still static, still simple)
- Structured logging hooks (opt-in)
- Improved CLI diagnostics
- Deployment hardening guidance

Non-goals:
- Admin dashboards
- Web-based configuration
- Hosting abstractions

---

## v0.3.x — Content Lifecycle

**Status:** Tentative

Focus:
- Managing content intentionally over time

Possible additions:
- Draft handling improvements
- Scheduled publishing (file-based, optional)
- Content validation warnings
- Archive views

All features must:
- Remain file-based
- Be optional
- Not require background jobs

---

## v1.0 — Stability Contract

**Status:** Future milestone

v1.0 represents:

- Stable routing behavior
- Stable content format
- Stable CLI interface
- Stable metadata contract
- Long-term support expectations

Once v1.0 is released:
- Breaking changes require a major version
- Content written for v1.0 should render correctly for years

---

## Explicit Non-Goals (Permanent)

The following will **never** be added:

- Plugin systems
- Databases
- User accounts
- Admin dashboards
- Visual editors
- Drag-and-drop interfaces
- SaaS integrations
- Analytics or tracking
- Comment systems
- Multi-tenant support
- Growth or engagement features
- Monetization tooling

If you want these features, WebholeInk is not the right tool.

---

## Fork-Friendly Philosophy

WebholeInk is intentionally forkable.

If you need:
- More features
- Different tradeoffs
- Faster iteration

You are encouraged to fork and build on it.

The core project will remain narrow, stable, and boring.

---

## How the Roadmap Changes

The roadmap changes only when:

- A real production need emerges
- The change improves long-term stability
- The change aligns with the philosophy

Popularity is not a deciding factor.

---

## Final Word

WebholeInk is not trying to win a market.
It is trying to **last**.

This roadmap exists to protect that goal.
