# CONTRIBUTING.md

## Contributing to WebholeInk

Thank you for your interest in contributing to WebholeInk.

Before opening an issue or pull request, **please read this document carefully**.
WebholeInk is intentionally opinionated. Not all contributions are appropriate.

---

## Project Philosophy (Read First)

WebholeInk is:

- File-first
- Database-free
- Minimal by design
- Built for long-term stability
- Explicit over magical
- Boring on purpose

If a contribution conflicts with these goals, it will be rejected —
even if it is well-written or popular elsewhere.

This is not a general-purpose CMS.

---

## What Contributions Are Welcome

### ✅ Accepted Categories

- Bug fixes
- Security improvements
- Performance improvements
- Documentation corrections or expansions
- Test coverage improvements
- CLI tooling that supports existing workflows
- Explicit, opt-in features that do not affect defaults

---

### ❌ Not Accepted

The following will **not** be merged:

- Plugin systems
- Database integrations
- Visual editors or WYSIWYG features
- Tracking, analytics, or telemetry
- Framework dependencies
- Auto-magic configuration
- SaaS integrations
- Growth, engagement, or monetization features

If your idea sounds like WordPress, Ghost, or Medium — it does not belong here.

---

## Contribution Workflow

### 1. Fork the Repository

Work must be done in a fork or feature branch.
Direct pushes to `main` are restricted.

---

### 2. Create a Focused Branch

Use descriptive branch names:
```
fix/page-cache-header docs/update-deployment feat/cli-post-description

```
One concern per branch.

---

### 3. Follow Existing Conventions

Before writing code, review:

- `ARCHITECTURE.md`
- `STYLEGUIDE.md`
- `CONTENT.md`
- Existing source structure

New code must **match the existing style**.
This project values consistency over personal preference.

---

### 4. Keep Changes Small and Explicit

Good pull requests:

- Do one thing
- Explain why
- Avoid refactors unless necessary
- Do not introduce new abstractions casually

If a change requires explanation, document it.

---

### 5. Tests & Verification

If your change affects:

- Routing
- Rendering
- Metadata
- Feeds
- Caching

You **must** explain how it was tested.

Example:

```
Tested by:
- Visiting /about, /posts, /posts/{slug}
- Validating RSS and JSON feeds
- Confirming cache headers with curl -I
```
#  Documentation Changes

Documentation is first-class.

If behavior changes, documentation must be updated in the same pull request.

Outdated docs are considered bugs.

# Issues

Issues are for:

Confirmed bugs

Security concerns

Clear, actionable improvements

Issues are not for:

Feature requests without justification

Opinion polls

“Wouldn’t it be cool if…”

Support questions

If you are unsure, open a discussion first

# Commit Messages

Use clear, descriptive messages:

```
Fix cache invalidation on page updates
Add JSON feed support
Correct sitemap URL duplication
```


Avoid vague messages like:

Update stuff
```
Fix things
Changes
```
# Code of Conduct

Be respectful. 
Be technical. 
Be direct.
WebholeInk assumes contributors are competent adults. There is no separate Code of Conduct file — professionalism is expected.

# Final Note
WebholeInk is intentionally narrow in scope.

If you want to build something larger, faster, or more flexible — this codebase may serve as a foundation, not a destination.

That is acceptable.

Thank you for respecting the boundaries of the project.
