<?php

namespace App\Model;

use App\Model\UserListItem;

class UserListResponse
{
    private array $items;

    /**
     * @param UserListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}