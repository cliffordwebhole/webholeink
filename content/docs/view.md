---
title: View
description: WebholeInk documentation
draft: false
---

# VIEW.md (Contract)

View rendering must be safe, predictable, and filesystem-scoped.

## Scope
- Templates can only be loaded from the active theme directory
- Template names are logical (e.g. `home`, `page`) not raw file paths

## Variables
- Templates receive only the variables explicitly passed in
- No implicit globals are required for template correctness

## Failure behavior
- Missing templates raise a RuntimeException (v0.1.x)
- This is acceptable for early-stage debugging

## Output
- Views return a string
- They do not echo directly

## Contract lock
Any change to view resolution or allowed scope requires updating this doc first.
