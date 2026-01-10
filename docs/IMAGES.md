# WebholeInk Images

WebholeInk supports images as first-class, static assets.
Images are intentionally simple, predictable, and file-based.

There is no media library, no upload UI, and no transformation pipeline.
If you can place a file on disk, WebholeInk can render it.

---

## Core Principles

- Images are **static files**
- Images are **served directly by the web server**
- Images are **referenced explicitly in content**
- Layout and scaling are **theme responsibilities**
- Content authors do **not control presentation logic**

This ensures long-term stability and eliminates surprises.

---

## Supported Image Formats

WebholeInk does not restrict formats, but the following are recommended:

- `.png` — icons, diagrams, screenshots
- `.jpg` / `.jpeg` — photographs
- `.webp` — optimized modern images (optional)
- `.svg` — icons and simple graphics (use carefully)

Animated images (e.g. GIFs) are allowed but discouraged.

---

## Directory Structure

Images should live under the `public/media/` directory.

Recommended structure:

public/ media/    pages/ posts/ docs/

Examples:

- Page images: `public/media/pages/`
- Documentation images: `public/media/docs/`
- Post images: `public/media/posts/`

The directory structure is a convention, not a requirement — but consistency is strongly encouraged. However all media must be inside your public folder.

---

## Referencing Images in Markdown

Images are referenced using **absolute paths** from the web root.

### Markdown syntax

```
![Alt text](/media/pages/example.png)
```
HTML syntax (allowed)
```
<img src= " /media/pages/example.png" alt="Example ">
```
HTML is permitted when needed, but Markdown is preferred.


---

## Image Sizing & Layout

Image sizing is controlled by the theme, not by content.

By default,  all WebholeInk themes should enforce:

main img {
    max-width: 640px;
    height: auto;
}

This ensures:

Consistent layout across pages

Mobile-friendly rendering

Predictable appearance regardless of source image size


Authors should not use inline styles for sizing.


---

## Captions (Optional)

WebholeInk does not provide native caption syntax. If captions are required, use standard HTML:
```
<figure>
  <img src= "/media/pages/example.png" alt="Example" >
  <figcaption>Example caption</figcaption>
</figure>
```
Caption styling is theme-dependent.


---

Accessibility

All images must include alt text.

Good:
```
![WebholeInk architecture diagram](/media/docs/architecture.png)
```
Bad:
```
![](/media/docs/architecture.png)
```
Alt text should describe the meaning of the image, not the filename.


---

## What WebholeInk Does Not Do

WebholeInk intentionally does not:

Resize images dynamically

Generate thumbnails

Optimize images

Lazy-load images

Rewrite image URLs

Provide a media editor


These responsibilities belong to the author and the deployment environment.


---

## Recommended Workflow

1. Prepare images locally


2. Optimize them before upload (optional but encouraged)


3. Place them under content/media/


4. Reference them explicitly in Markdown


5. Let the theme handle presentation



No additional steps required.


---

## Stability Guarantee

Image handling is part of WebholeInk’s stable contract.

Future versions will not introduce hidden processing, rewriting, or implicit behavior around images.

If an image works today, it will work the same way years from now.


---

