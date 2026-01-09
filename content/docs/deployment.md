---
title: Deployment
description: WebholeInk documentation
draft: false
---

# Deployment Guide

This document describes how to deploy WebholeInk in production.

WebholeInk is intentionally simple to deploy. 

There are no build steps, background services, or external dependencies 

beyond a standard web stack.

If you can deploy PHP behind Nginx, you can deploy WebholeInk.

# Deployment Philosophy

WebholeInk follows the same philosophy in deployment as it does in architecture:

Boring infrastructure

No magic

Explicit configuration

Operator-controlled

Easy to reason about

The goal is not convenience — it is predictability and longevity.


# Minimum Requirements

Server

Linux (Ubuntu/Debian recommended)

Root or sudo access

Software

Nginx or OpenResty

PHP 8.2+ (8.3 recommended)

PHP extensions:

mbstring

yaml

ctype

json

No database is required.

# Directory Layout

A typical production layout:

/var/www/webholeink/ 

├── app/ 

├── content/-->pages/ -->posts/

├── public/ ----> index.php---->feed.xml---->feed.json--->sitemap.xml ------->robots.txt 

└── nginx/ 

Only the public/ directory is web-accessible.

# Web Root Configuration
Your web server must point to:

/var/www/webholeink/public 

Never expose:

• /app

• /content

• /nginx

# Nginx Configuration (Recommended)

Minimal, production-safe example:

```
server

{
    listen 80;
    
    server_name yoursite.com;
    

    root /var/www/webholeink/public;
    
    index index.php;
    

    location / {
    
        try_files $uri $uri/ /index.php?$query_string;
        
    }


    location ~ \.php$ {
    
        include fastcgi_params;
        
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        
        fastcgi_param DOCUMENT_ROOT $document_root;
        
        fastcgi_pass php-fpm:9000;
        
    }
    

    location ~ /\. {
    
        deny all;
        
    }
    }
```
  WebholeInk does not require rewrite rules or framework-specific routing.

  # HTTPS

TLS termination is handled at the web server or proxy level.

WebholeInk:

• Does not manage certificates

• Does not enforce HTTPS internally

• Works behind reverse proxies

Use:

• Let’s Encrypt

• Cloudflare

• Nginx TLS

• Load balancer TLS

# HTTP Headers
WebholeInk sets security and SEO headers at the application layer.

This ensures:

• Headers work regardless of proxy

• Behavior is version-controlled

• No reliance on server-specific config

Headers include:

• Content-Security-Policy

• X-Content-Type-Options

• X-Frame-Options

• Referrer-Policy

• Permissions-Policy

• X-Robots-Tag

• Cache headers (ETag, Last-Modified)

You may add additional headers at the web server if desired.

# Caching Strategy

WebholeInk uses conditional HTTP caching, not application caches.

### Supported

• ETag

• Last-Modified

• 304 Not Modified

### Not Used

• Redis

• Memcached

• Page caches

• Static pre-generation

Caching correctness is prioritized over performance tricks.

# Content Deployment

Publishing is file-based.

To deploy content:

git pull 

or

rsync content/ server:/var/www/

webholeink/content/ 

No rebuilds.

No migrations.

No cache clears.

# Draft Handling

Drafts are controlled via front matter:
draft: true 

Drafts:

• Do not appear in posts index

• Do not appear in feeds

• Do not appear in sitemap

• Return 404 if accessed directly

There is no admin toggle or publish button.

# Feeds & Sitemap

WebholeInk dynamically generates:

• /feed.xml (RSS 2.0)

• /feed.json (JSON Feed v1.1)

• /sitemap.xml

No cron jobs are required.

# robots.txt

A default robots.txt is included:

User-agent: * 

Allow: / Sitemap: https://webholeink.org/sitemap.xml 

You may customize this as needed.

# Updates

Updating WebholeInk is a git operation:

git pull 

There are:

• No schema changes

• No migrations

• No upgrade scripts

If a change breaks something, it is visible immediately.

# Rollback Strategy

Rollback is trivial:

git checkout <previous-tag> 

Content is never altered by the application.

# Monitoring & Logging

WebholeInk relies on standard server logging:

• Nginx access/error logs

• PHP-FPM logs

The application does not include internal logging systems.

# Backups

Backups are simple because data is simple.

Back up:

• content/

• .md files

• Git repository

You do not need database dumps.

# Scaling

WebholeInk scales vertically by default.

Horizontal scaling is possible because:

• There is no shared state

• There is no database

• Content is read-only at runtime

Load balancers and read-only replicas work without modification.

# Failure Modes

WebholeInk fails loudly and visibly:

• Missing files → 404

• Syntax errors → PHP error

• Invalid Markdown → rendered as-is
• 
There are no silent failures.

# What This Deployment Does NOT Do

• No zero-downtime deploys

• No CI/CD requirements

• No background workers

• No queue systems

• No asset pipelines

Those are not omissions — they are intentional exclusions.

# Final Note

If you can SSH into a server and

understand Nginx, you already know 

how to deploy WebholeInk.

That is the point.

