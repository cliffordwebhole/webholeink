<?php
declare(strict_types=1);

namespace WebholeInk\Core;

final class Navigation
{
    private PageResolver $resolver;

    public function __construct(PageResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @return array<int,array{label:string,path:string,order:int}>
     */
    public function items(): array
    {
        // Base navigation from pages
        $items = $this->resolver->navigationItems();
       // Inject Docs index
       $items[] = [
           'label' => 'Docs',
           'path'  => '/docs',
           'order' => 9,
        ];


        // Inject Posts index
        $items[] = [
            'label' => 'Posts',
            'path'  => '/posts',
            'order' => 10,
        ];

        usort($items, static function (array $a, array $b): int {
            return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
        });

        return $items;
    }
}
