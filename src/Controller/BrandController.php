<?php

namespace App\Controller;

use App\Service\BrandService;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route(path: '/index', name: 'api_v1_brand_index', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function index() : Response {
        try {
            return $this->json($this->brandService->getBrands());

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    #[Route(path: '/create', name: 'api_v1_brand_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response {
        try {
            $content = json_decode($request->getContent());

            return $this->json($this->brandService->createBrand($content->name));

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    #[Route(path: '/index/names', name: 'api_v1_brand_index_names', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function names() : Response {

        try {

            return $this->json($this->brandService->getBrandNames());

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

}