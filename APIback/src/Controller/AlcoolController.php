<?php

namespace App\Controller;


use App\Repository\AlcoolsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\jsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class AlcoolController extends AbstractController{
    #[Route('/alcools', name: 'app_alcool')]
    public function index(AlcoolsRepository $alcoolsRepository): JsonResponse
    {
        $alcools = $alcoolsRepository->findAll();

        // Transformer les entités en tableau
        $data = array_map(fn($alcools) => [
            'id' => $alcools->getId(),
            
            'NomAlcool' => $alcools->getNomAlcool(),
        ], $alcools);

        return $this->json($data);
    }
}
