<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
class UpdateCarRequest
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private int $id;
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
     * @param int $id
     * @param string $name
     * @param string $brandName
     * @param string $wheelPosition
     */
    public function __construct(int $id, string $name, string $brandName, string $wheelPosition)
    {
        $this->id = $id;
        $this->name = $name;
        $this->brandName = $brandName;
        $this->wheelPosition = $wheelPosition;
    }

    public function getId(): int
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