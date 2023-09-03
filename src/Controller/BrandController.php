<?php

namespace App\Controller;

use App\Model\BrandListResponse;
use App\Service\BrandService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

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
    #[OA\Response(
        response: 200,
        description: 'Return all brands',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: BrandListResponse::class))
        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Returns a message about the error that occurred',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    public function index() : Response {
        try {
            return $this->json($this->brandService->getBrands(), Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    #[Route(path: '/create', name: 'api_v1_brand_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    #[OA\Response(
        response: 200,
        description: 'Return a name of the created brand',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'brandName', type: 'string') ],
            type: 'object'

        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Returns a message about the error that occurred',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'
        )
    )]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'name', type: 'string') ],
            type: 'object'
        )
    )]
    public function create(Request $request): Response {
        try {
            $content = json_decode($request->getContent());

            return $this->json($this->brandService->createBrand($content->name), Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    #[Route(path: '/index/names', name: 'api_v1_brand_index_names', methods: ['GET'])]
    #[IsGranted('PUBLIC_ACCESS')]
    #[OA\Response(
        response: 200,
        description: 'Return a list of brand names',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(type: 'string')
        )
    )]
    #[OA\Response(
        response: 500,
        description: 'Returns a message about the error that occurred',
        content: new OA\JsonContent(
            properties: [ new OA\Property(property:'message', type: 'string') ],
            type: 'object'

        )
    )]
    public function names() : Response {
        try {

            return $this->json($this->brandService->getBrandNames(), Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

}