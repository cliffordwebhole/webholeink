---
title: Upgrade
description: WebholeInk documentation
draft: false
---

# UPGRADE.md

## Upgrade Guide

WebholeInk is designed so upgrades are **boring, explicit, and reversible**.

There are:
- No migrations
- No background upgrade steps
- No database changes
- No hidden state

Upgrading WebholeInk is a controlled file replacement process.

---

## Versioning Policy

WebholeInk follows **semantic versioning** with intent:

- **MAJOR** — Architectural or contract changes
- **MINOR** — New features that do not break content
- **PATCH** — Bug fixes, security, or performance improvements

Example:

0.1.0 → v0.2.0   (minor) v0.2.0 → v1.0.0   (major)

---

## Before You Upgrade

Always do the following **before pulling a new version**:

1. **Back up your repository**
```
git status
git commit -am "pre-upgrade backup"
```
2.Back up your content directory
```
tar -czf content-backup.tar.gz content/

```
3.Confirm clean working tree
```
git status

```
If your working tree is not clean, stop.

# Standard Upgrade Process

1. Review the CHANGELOG
   
-Read CHANGELOG.md for:

-Breaking changes

-Content contract updates

-Handler or routing changes

Never upgrade blindly.


2.Pull the Latest Version
```
git fetch origin
git checkout main
git pull origin main

```
3. Review Content Contract Changes

If the release mentions changes to:

Front matter keys

Required metadata

Draft handling

Feed behavior

Review and update your content files accordingly.

Your content is your responsibility.

4. Validate Locally

Start the site locally or in staging and verify:

Pages render correctly

Posts index loads

Single posts resolve

Feeds (/feed.xml, /feed.json)

Sitemap (/sitemap.xml)

Metadata output

Recommended checks:
```
curl -I /
curl /posts
curl /feed.xml
```
5. Deploy

Once verified:

Deploy the updated code

Restart PHP / containers if applicable

Clear any external caches (CDN, browser)

WebholeInk itself does not cache content internally.

# Handling Breaking Changes (MAJOR Versions)

If upgrading across a major version:

Expect content contract changes

Expect routing or handler changes

Expect metadata behavior changes

Major upgrades may require:

Updating front matter

Renaming fields

Adjusting custom themes

These changes will always be documented.

# Rollback Strategy

If something goes wrong:
```
git reset --hard <previous-tag>
```
Restore your content backup if necessary.

Because WebholeInk is file-first, rollback is immediate.

# What Never Changes

Upgrades will never introduce:

A database

Remote dependencies

Auto-migrations

Background processes

Hidden state

Telemetry

If a proposed change violates this, it will not ship.

# Operator Responsibility

WebholeInk assumes:

You read release notes

You control your server

You understand your content

The project will not attempt to protect you from ignoring upgrades.

# Final Note

If an upgrade feels risky, complicated, or surprising:

That is a bug.

Please report it.
