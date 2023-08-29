<?php

namespace App\Model;

class CarListItem
{
    private int $id;
    private string $name;
    private string $slug;
    private BrandListItem $brand;

    public function __construct($id, $name, $slug, $brand)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->brand = $brand;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getBrand(): BrandListItem {
        return $this->brand;
    }
}