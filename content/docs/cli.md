---
title: Cli
description: WebholeInk documentation
draft: false
---

# WebholeInk CLI 

The WebholeInk CLI is a minimal command-line tool designed to manage content in a **file-first, database-free** workflow. It is intentionally simple, predictable, and scriptable.

 --- 
## Philosophy The CLI exists to: 

- Create content consistently 

- Enforce front-matter structure 

- Avoid hidden state or metadata 

- Remain optional (everything still works by editing files manually)

 The CLI **never mutates existing content automatically**. 

--- 

## Location 

```
text app/cli/webholeink.php 

```
The CLI is written in PHP and runs locally.

## Usage

php app/cli/webholeink.php <command> [arguments] 

## Available Commands

### post:new

Create a new blog post with front matter.
```
php app/cli/webholeink.php post:new "Hello World" 

```
### Prompt Flow

The CLI will prompt for:

• Post title (argument)

• Description (required)

• Draft status (default: true)

Example interaction:

Title: Hello World Description: 

A short introduction to WebholeInk 

Draft? (y/N): n 

### Generated File

content/posts/YYYY-MM-DD-hello-world.md 

### Generated Front Matter

--- title: Hello World 

description: A short introduction to WebholeInk 

date: 2026-01-04 

slug: hello-world draft: false -

-- 
### Draft Handling

• draft: true → excluded from:

• Post index

• Feeds

• Sitemap

• Direct routing

• draft: false → published immediately

Drafts can safely exist on disk without exposure.

### Slug Rules

Slugs are:

• Lowercase

• Hyphenated

• Derived from title unless overridden manually

• Used for routing and URLs

Example:

/posts/hello-world 

### Manual Overrides

The CLI does not prevent manual editing.

You may safely:

• Edit front matter

• Change slugs

• Adjust dates

• Remove draft flags

The runtime will respect file contents.

##  Non-Goals

The CLI intentionally does not:

• Edit existing posts

• Delete content

• Publish automatically

• Manage users

• Touch configuration

• Perform network operations

##  Automation & Scripting

Because the CLI is deterministic and non-interactive when piped, it can be used in scripts:
```
echo "n" | php app/cli/webholeink.php post:new "Automated Post" 

```
## Failure Modes

The CLI will exit with a non-zero status if:

• Required arguments are missing

• Files cannot be written

• Invalid input is detected

Errors are printed plainly.

## Future Commands (Planned)

• post:list

• post:validate

• cache:clear

• feed:build

• sitemap:build

These will remain optional and non-intrusive.

## Summary

The WebholeInk CLI is:

• Optional

• Predictable

• File-first

• Safe by default

• Boring on purpose

If you can use mkdir and nano, you already understand it.

--- 
