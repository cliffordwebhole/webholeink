# Contributing to WebholeInk

Thank you for your interest in contributing to **WebholeInk**.

WebholeInk is intentionally minimal.  
Contributions are welcome — but **only when they respect the project’s boundaries**.

Please read this document carefully before opening an issue or pull request.

---

## 🧱 Project Philosophy

WebholeInk is built on these principles:

- File-based content
- Explicit behavior
- No magic
- No plugins
- No silent abstraction
- No hidden state

If a proposed change violates these principles, it will not be accepted.

---

## 🔒 Core Stability

The **core engine is locked** as of:

> **v0.1.0-core-stable**

This includes (but is not limited to):

- Routing
- Handlers
- Content resolution
- View system
- Layout
- Navigation
- Theme loading

Changes to core behavior **require discussion before code**.

Do **not** submit pull requests that alter core contracts without opening an issue first.

---

## 📚 Contracts First

Behavior in WebholeInk is defined by explicit contracts located in `/docs`.

Examples:
- `CORE.md`
- `ROUTES.md`
- `HANDLERS.md`
- `CONTENT.md`
- `VIEW.md`
- `NAVIGATION.md`
- `THEMES.md`

If a change is not reflected in the documentation, it is incomplete.

**Documentation updates must accompany behavior changes.**

---

## 🧪 What Is Welcome

Contributions that are welcome without prior approval:

- Documentation improvements
- Typo fixes
- Clarifications
- Examples
- New themes
- CSS improvements
- Optional tooling (outside core)

---

## 🚫 What Is Not Accepted

The following will be rejected without review:

- Plugin systems
- Admin dashboards
- Databases added to core
- Implicit behavior
- Hidden configuration
- Auto-magic conventions
- Framework-style abstractions

WebholeInk is **not** trying to compete with WordPress or Laravel.

---

## 🧭 Feature Proposals

If you want to propose a feature:

1. Open an issue
2. Describe the problem clearly
3. Explain why it belongs *outside* or *on top of* core
4. Reference existing contracts

No code first. Discussion first.

---

## 🛠 Development Guidelines

- PHP 8.2+
- No external dependencies unless justified
- No global state
- Clear naming
- Small files
- Predictable behavior

Readable code beats clever code.

---

## 📄 License

By contributing, you agree that your contributions will be licensed under the **MIT License**, the same license as the project.

---

## 🐝 Final Note

WebholeInk is intentionally opinionated.

If you love minimal systems, you’re in the right place.  
If you want batteries included, this project is not for you — and that’s okay.

Thank you for respecting the craft.

— Clifford Webhole
