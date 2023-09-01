<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
class CreateCarRequest
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $name;
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $brandName;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $wheelPosition;


    public function __construct(string $name, string $brandName, string $wheelPosition)
    {
        $this->name = $name;
        $this->brandName = $brandName;
        $this->wheelPosition = $wheelPosition;
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