---
title: Installation
description: How to install and configure WebholeInk
draft: false
---

# Installing WebholeInk

WebholeInk is a file-first publishing engine.
There is no database, no admin panel, and no build step.

Installation is about **placing files** and **setting site identity**.

---

## Requirements

- PHP 8.2+
- A web server (Nginx recommended)
- File system access (SSH or local)
- Git (optional but recommended)

No database is required.

---

## Directory Layout

A typical installation looks like this:

/var/www/webholeink  
├── app/  
├── content/  
├── public/  
├── nginx/  
├── docker-compose.yml (optional)  

The web server **must point to**:
/var/www/webholeink/public
---

## Step 1: Configure Site Identity (REQUIRED)

Before serving traffic, you **must** configure your site identity.

Edit: app/config/site.php

```
<?php

return [
    'name'        => 'My Site',
    'url'         => 'https://example.com',
    'description' => 'My WebholeInk site',
];
```
## Why this matters
This file controls:
- Canonical URLs
- RSS feed URLs
- JSON feed URLs
- Sitemap URLs
- Metadata and SEO output
If this file is not updated, your site may incorrectly reference another domain.

## Step 2: Configure Theme (Optional)
Themes are author-controlled.
Edit app/config/theme.php
```
<?php

return [ 
    'available' => ['classic', 'light', 'dark'],
    'default'   => 'classic',
    'active'    => 'dark',
];
```
Visitors cannot switch themes. The site owner controls theme selection.

## Step 3: Add Content
Content lives in plain Markdown files.
### Pages 
In content/pages/
```
content/pages/about.md
content/pages/philosophy.md
```
### Posts 
In content/posts/
Example:
```
content/posts/2026-01-04-my-first-post.md
```
Draft posts are excluded automatically:
```
Yaml
draft: true
```
## Step 4: Media Files
Static media (images, files) must live under: public/media/
```
public/media/pages/logo.png
```
Markdown reference:
```
![Logo](/media/pages/logo.png)
```
Do not place media inside content/.

## Step 5: Deploy
Deployment is file-based.
To deploy changes:
```
git pull
```
```
rsync -av content/ server:/var/www/webholeink/content/
```
- No rebuilds.
- No migrations.
- No cache clears.

Changes are live immediately.

## Verifying Installation
Check the following URLs:
- / — homepage
- /about — page rendering
- /posts — post index
- /feed.xml — RSS feed
- /feed.json — JSON feed
- /sitemap.xml — sitemap

All URLs should reference your configured domain.

## Common Mistakes
- Forgetting to update app/config/site.php
- Pointing the web server to the project root instead of /public
- Placing images inside content/
- Editing theme CSS instead of theme variables

## Philosophy Reminder
- WebholeInk favors:
- Explicit configuration
- Predictable behavior
- Long-term stability
- 
If something feels “automatic”, it probably isn’t WebholeInk.



