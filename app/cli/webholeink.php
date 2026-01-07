#!/usr/bin/env php
<?php

declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    exit("CLI only.\n");
}

$argv = $_SERVER['argv'];
$command = $argv[1] ?? null;

if ($command === null) {
    echo "WebholeInk CLI\n";
    echo "Usage:\n";
    echo "  post:new \"Post Title\"\n";
    exit(0);
}

$root = dirname(__DIR__, 2);
$postsDir = $root . '/content/posts';

if (!is_dir($postsDir)) {
    mkdir($postsDir, 0755, true);
}

switch ($command) {

    /**
     * --------------------------------------------------
     * post:new "Title"
     * --------------------------------------------------
     */
    case 'post:new':

        $title = $argv[2] ?? null;

        if (!$title) {
            echo "Usage:\n";
            echo "  post:new \"Post Title\"\n";
            exit(1);
        }

        // Prompt for description
        echo "Enter description (optional): ";
        $description = trim(fgets(STDIN));

        $date = date('Y-m-d');
        $slug = strtolower(
            trim(
                preg_replace('/[^a-z0-9]+/i', '-', $title),
                '-'
            )
        );

        $filename = "{$date}-{$slug}.md";
        $path = $postsDir . '/' . $filename;

        if (file_exists($path)) {
            echo "Post already exists:\n  {$path}\n";
            exit(1);
        }

        // Build front matter
        $frontMatter = "---\n";
        $frontMatter .= "title: {$title}\n";

        if ($description !== '') {
            $frontMatter .= "description: {$description}\n";
        }

        $frontMatter .= <<<MD
date: {$date}
slug: {$slug}
published: false
---

MD;

        $content = <<<MD
# {$title}

Write here.

MD;

        file_put_contents($path, $frontMatter . $content);

        echo "Post created:\n";
        echo "  {$path}\n";
        exit(0);

    default:
        echo "Unknown command: {$command}\n";
        exit(1);
}
