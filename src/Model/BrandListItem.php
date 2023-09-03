<?php

namespace App\Model;

class BrandListItem
{
    private int $id;

    private string $name;

    private string $wheelPosition;

    private string $slug;

    public function __construct($id, $name, $wheelPosition, $slug)
    {
        $this->id = $id;
        $this->name = $name;
        $this->wheelPosition = $wheelPosition;
        $this->slug = $slug;
    }

    public function getId () : int {
        return $this->id;
    }

    public function setId(int $id) : self
    {
        $this->id = $id;
        return $this;
    }

    public function getName () : string {
        return $this->name;
    }

    public function getWheelPosition () : string {
        return $this->wheelPosition;
    }

    public function getSlug () : string {
        return $this->slug;
    }

}