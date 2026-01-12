<?php

declare(strict_types=1);

return [
    /*
     |--------------------------------------------------------------------------
     | Active Theme
     |--------------------------------------------------------------------------
     |
     | The active visual theme for this site.
     | This is a publisher-controlled setting.
     |
     | Allowed values:
     | - classic  (v0.1.0 original theme)
     | - dark     (dark variant)
     | - light    (light variant)
     |
     */

    'active' => 'light',

    /*
     |--------------------------------------------------------------------------


   /*

     | Default Theme (Hard Fallback)
     |--------------------------------------------------------------------------
     |
     | Used if the active theme is missing, invalid,
     | or its stylesheet cannot be found.
     |
     | This should always point to a known-good theme.
     |
     */

    'default' => 'classic',

    /*
     |--------------------------------------------------------------------------
     | Available Themes
     |--------------------------------------------------------------------------
     |
     | Explicitly declared themes prevent silent breakage
     | and make validation trivial.
     |
     */

    'available' => [
        'classic',
        'dark',
        'light',
    ],
];
