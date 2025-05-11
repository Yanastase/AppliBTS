<?php

namespace App\Controller;

use App\Repository\BoissonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BoissonController extends AbstractController
{
    #[Route('/boissonList', name: 'app_boisson')]
    public function index(BoissonRepository $boissonRepository): JsonResponse
    {
        $boissons = $boissonRepository->findAll();

        // Transform the entities into an array
        $data = array_map(fn($boisson) => [
            'id' => $boisson->getId(),
            'nom' => $boisson->getNom(),
            'logo' => $boisson->getLogo(),
            'prix' => $boisson->getPrix(),
            'dateProduction' => $boisson->getDateProduction(),
                   ], $boissons);

        return $this->json($data);
    }
}

