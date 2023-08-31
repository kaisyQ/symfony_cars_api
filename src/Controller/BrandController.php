<?php

namespace App\Controller;

use App\Service\BrandService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/brands')]
class BrandController extends AbstractController
{

    private BrandService $brandService;
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    #[Route('/', name: 'api_v1_brand_index', methods: ['GET'])]
    public function index() : Response {
        return $this->json($this->brandService->getBrands());
    }
}