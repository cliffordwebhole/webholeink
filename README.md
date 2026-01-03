# WebholeInk

**WebholeInk** is a minimal, developer-first publishing engine.

No plugins.  
No databases.  
No magic.

Just files, clear contracts, and full control.

---

## 🚀 Status

**v0.1.0 — Core Stable**

The core engine is complete and locked.

This release establishes:
- Routing
- Handlers
- Content resolution
- Theming
- Navigation
- Markdown rendering
- View and layout contracts

No new features will be added to core without a version bump.

---

## 🎯 Philosophy

WebholeInk exists to solve one problem well:

> **Publish content without surrendering control.**

Everything is explicit.
Everything is readable.
Everything is owned by the developer.

There is no admin panel.
There is no plugin system.
There is no database requirement.

If it’s not in the filesystem, it doesn’t exist.

---

## 🧱 Architecture Overview

public/         → HTTP entry point (only public files) app/            → Core engine (locked) content/        → Markdown content (pages, posts) config/         → Explicit configuration docs/           → Contracts & documentation
Core responsibilities are split cleanly:

- **Router** → maps paths to handlers
- **Handlers** → decide *what* to render
- **PageResolver** → resolves content files
- **View / PageView** → renders templates safely
- **Layout** → wraps content with theme chrome
- **Themes** → presentation only (no logic)

---

## 📝 Content Model

Content is file-based and predictable.
content/ └── pages/ ├── home.md ├── about.md ├── philosophy.md └── page.md

- URLs map directly to filenames
- `/about` → `content/pages/about.md`
- Markdown is parsed at runtime
- No front-matter required (by design)

---

## 🎨 Theming

Themes are PHP templates, not magic.

app/themes/default/ ├── layout.php ├── home.php ├── page.php ├── navigation.php ├── footer.php └── assets/

- Themes do **presentation only**
- Logic lives in handlers and core
- Assets are served from `public/themes/`

---

## 📚 Contracts (Locked)

Core behavior is defined by explicit contracts:

- `CORE.md` – system architecture
- `ROUTES.md` – routing rules
- `HANDLERS.md` – handler contract
- `CONTENT.md` – content resolution rules
- `VIEW.md` – view rendering rules
- `NAVIGATION.md` – navigation behavior
- `THEMES.md` – theming constraints

If it’s not documented, it’s not supported.

---

## 🔒 Stability Guarantee

This release is **core-stable**.

That means:
- No breaking changes without a version bump
- No silent behavior changes
- No scope creep

Future work will build **on top of** this foundation, not rewrite it.

---

## 🛠 Requirements

- PHP 8.2+
- Nginx or compatible web server
- No database
- No extensions beyond standard PHP

---

## 📦 Backup & Recovery

WebholeInk is intentionally easy to back up:

- Filesystem snapshot
- Git repository
- No state hidden elsewhere

If you can copy a directory, you can restore the site.

---

## 🧭 Roadmap

**v0.2.0 (Planned)**
- Collections / posts
- Metadata (optional, explicit)
- Pagination helpers

Core principles will not change.

---

## 🐝 Built By

Clifford Webhole  
with Houston as copilot ☺️

---

**WebholeInk**  
_Developer-first publishing, without compromise._


## Documentation
- [Core Architecture](docs/CORE.md)
- [Routing Rules](docs/ROUTER.md)
- [Handler Contract](docs/HANDLERS.md)
- [Content Rules](docs/CONTENT.md)
- [Themes Contract](docs/THEMES.md)
- [View Contract](docs/VIEW.md)
- [Navigation Contract](docs/NAVIGATION.md)
- [Project Status](docs/STATUS.md)

## 📄 License

WebholeInk is open-source software licensed under the MIT License.
