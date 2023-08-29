<?php

namespace App\Controller;

use App\Service\BrandService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{

    private BrandService $brandService;
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    #[Route('/api/brand', name: 'api_brand_index', methods: ['GET', 'HEAD'])]
    public function index() : Response {
        return $this->json($this->brandService->getBrands());
    }
}