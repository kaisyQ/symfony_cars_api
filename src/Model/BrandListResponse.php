<?php

namespace App\Model;

class BrandListResponse
{

    /**
     * @var BrandListItem[]
     */
    private array $items;

    /**
     * @param BrandListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return BrandListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

}