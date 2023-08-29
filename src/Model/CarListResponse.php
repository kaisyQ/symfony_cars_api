<?php

namespace App\Model;

class CarListResponse
{
    /**
     * @var CarListItem[]
     */
    private array $items;

    /**
     * @param CarListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return CarListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}