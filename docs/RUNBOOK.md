
# This runbook defines **how to respond to operational issues** in WebholeInk.

It is intentionally boring, explicit, and linear.

If something breaks: 

- Follow this document

- Do not improvise

- Do not add complexity under pressure
  
# Scope 

This runbook covers: 

- Site availability issues 

- Content rendering issues 

- Feed / sitemap issues 

- Caching confusion

 - Deployment mistakes 

- Git / branch recovery It does **not** cover:

 - Infrastructure provisioning

 - TLS certificate issuance 

- DNS provider outages --- 

# Golden Rule > **If content exists on disk and Git history is intact, the site is recoverable.*

### Quick Health Check (First 60 Seconds) 

Run these **in order**: 

```
curl -I https://yoursite.com/ 

```
Expected:
• 200 OK

• HTML content-type

• Security headers present

```
curl https://yoursite.com/about | head -n 20 

```
Expected:

• Valid HTML

• Parsed Markdown (no raw ** or ---)

```
curl https://yoursite.com/feed.xml 

```
Expected:

• Valid RSS XML

• Items listed

• No PHP warnings

# Incident: Site Returns 500 Error

### Step 1: Check PHP container

docker ps 

Ensure PHP-FPM container is running.

```
docker logs webholeink_app --tail=50 

```

Look for:

• Fatal errors

• Parse errors

• Missing files

# Step 2: Identify last change

```
git log -1 --oneline 

```

If the error correlates with a recent commit:

• Revert or reset
```
git reset --hard HEAD~1 

```

# Incident: 

### Pages Show Raw Markdown Cause

Markdown parsing failed or was bypassed.

### Checklist

• Verify PageResolver output:

```
php -r " require 'app/bootstrap.php'; require 'app/autoload.php'; use WebholeInk\Core\PageResolver; var_dump((new PageResolver(WEBHOLEINK_ROOT.'/content'))->resolve('about')); " 

```
• body should be raw Markdown

• Handler must convert to HTML

• Verify PageHandler is using Markdown::parseWithFrontMatter

• Clear browser cache (see caching section)

# Incident: Browser Shows Old Content
Important

This is expected behavior.

WebholeInk uses:

• ETag

• Last-Modified

• must-revalidate

Fix (Operator)

• Hard refresh: Ctrl + Shift + R

• Or use private window

• Or disable cache in DevTools

### Validate with curl

```
curl -I https: //yoursite.com/about curl -I \ -H 'If-None-Match: "<etag>"' \ https://yoursite.com/about 

```
304 Not Modified means caching works.

# Incident: Post Missing from /posts
Checklist

• Verify front matter:

slug: correct-slug draft: false 

• draft: true excludes post

• Missing slug excludes post

• Verify resolver output:

```
php -r " require 'app/bootstrap.php'; require 'app/autoload.php'; use WebholeInk\Core\PostResolver; var_dump((new PostResolver('content/posts'))->index()); " 

```
• Ensure slug matches URL exactly:

/posts/{slug} 

# Incident: 404 on Valid Post URL

Likely Causes

• Slug mismatch

• Draft flag accidentally set

• File renamed without updating slug

Resolution

• Slug in front matter is authoritative

• Filename is irrelevant

# Incident: Feeds Missing Items
Checklist

• Drafts are excluded by design

• Feeds use same resolver as posts index

Verify:

```
curl https://yoursite.com/feed.xml curl https://yoursite.com/feed.json 

```
Look for:

• Empty <item> lists

• Missing descriptions

# Incident: Sitemap Incorrect

Expected Behavior

Sitemap includes:

• Home

• Pages

• Published posts

Drafts are excluded.

Validate

```
curl https://yoursite.com.org/sitemap.xml 

```
# Incident: Deployment Went Wrong

### Safe Recovery


```
git fetch origin git reset --hard origin/main 

```

This restores production to last known good state.


# Incident: Git Branch Chaos

### Identify merged branches

```
git branch --merged main git branch -r --merged origin/main 

```
### Safe cleanup (local)


```
git branch -d branch-name 

```

### Safe cleanup (remote)

```
git push origin --delete branch-name 

```
Never delete:

• main

• Tagged releases

# Emergency Read-Only Mode

If needed:

• Do nothing

WebholeInk is read-only by design. There is no write surface to disable.

# What NOT To Do During Incidents

• Do not add features

• Do not refactor

• Do not “optimize”

• Do not bypass caching

• Do not edit production files manually

Fix → Commit → Deploy.

# Escalation Policy

If you cannot explain the failure after:

• Reading logs

• Reviewing last commit

• Verifying content files

Stop and rollback.

# Final Principle

WebholeInk is boring on purpose.

If an incident feels exciting, you’re doing it wrong.










