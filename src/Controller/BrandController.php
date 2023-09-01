<?php

namespace App\Controller;

use App\Service\BrandService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/api/v1/brands')]
class BrandController extends AbstractController
{

    private BrandService $brandService;
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    #[Route('/index', name: 'api_v1_brand_index', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function index() : Response {
        return $this->json($this->brandService->getBrands());
    }

    #[Route('/index/names', name: 'api_v1_brand_index_names', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function names() : Response {
        return $this->json($this->brandService->getBrandNames());
    }
}