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
    private string $brandId;


    public function __construct(string $name, string $brandId)
    {
        $this->name = $name;
        $this->brandId = $brandId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBrandId(): string
    {
        return $this->brandId;
    }

}