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
    private string $brandId;

    public function __construct(string $id, string $name, $brandId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->brandId = $brandId;
    }

    public function getId(): string
    {
        return $this->id;
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