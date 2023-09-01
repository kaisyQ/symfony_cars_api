<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
class UpdateCarRequest
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $id;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $name;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $brandName;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $wheelPosition;

    /**
     * @param string $id
     * @param string $name
     * @param string $brandName
     * @param string $wheelPosition
     */
    public function __construct(string $id, string $name, string $brandName, string $wheelPosition)
    {
        $this->id = $id;
        $this->name = $name;
        $this->brandName = $brandName;
        $this->wheelPosition = $wheelPosition;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBrandName(): string
    {
        return $this->brandName;
    }

    public function getWheelPosition(): string
    {
        return $this->wheelPosition;
    }

}