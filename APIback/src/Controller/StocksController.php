<?php

namespace App\Controller;

use App\Entity\Stocks;
use App\Entity\Boisson;
use App\Repository\StocksRepository;
use App\Repository\BoissonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StocksController extends AbstractController
{
    #[Route('/stockslist', name: 'get_stocks', methods: ['GET'])]
    public function getStocks(StocksRepository $stocksRepository): JsonResponse
    {
        $stocks = $stocksRepository->findAll();

        $data = array_map(fn($stock) => [
            'id' => $stock->getId(),
            'quantité' => $stock->getQuantité(),
            'boisson' => $stock->getNumBoisson() ? [
                'id' => $stock->getNumBoisson()->getId(),
                'nom' => $stock->getNumBoisson()->getNom(),
                'prix' => $stock->getNumBoisson()->getPrix(),
            ] : null,
        ], $stocks);

        return $this->json($data, 200);
    }

    #[Route('/stockslist', name: 'add_stock', methods: ['POST'])]
    public function addStock(Request $request, EntityManagerInterface $entityManager, BoissonRepository $boissonRepository): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $stock = new Stocks();
        $stock->setQuantité($content['quantité']);

        // Set the associated Boisson
        $boisson = $boissonRepository->find($content['numBoisson']);
        if (!$boisson) {
            return $this->json(['error' => 'Boisson not found'], 404);
        }
        $stock->setNumBoisson($boisson);

        $entityManager->persist($stock);
        $entityManager->flush();

        return $this->json(['message' => 'Stock added successfully'], 201);
    }

    #[Route('/stockslist/{id}', name: 'edit_stock', methods: ['PUT'])]
    public function editStock(int $id, Request $request, StocksRepository $stocksRepository, BoissonRepository $boissonRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $stock = $stocksRepository->find($id);

        if (!$stock) {
            return $this->json(['error' => 'Stock not found'], 404);
        }

        $content = json_decode($request->getContent(), true);

        if (isset($content['quantité'])) {
            $stock->setQuantité($content['quantité']);
        }

        if (isset($content['numBoisson'])) {
            $boisson = $boissonRepository->find($content['numBoisson']);
            if (!$boisson) {
                return $this->json(['error' => 'Boisson not found'], 404);
            }
            $stock->setNumBoisson($boisson);
        }

        $entityManager->flush();

        return $this->json(['message' => 'Stock updated successfully'], 200);
    }

    #[Route('/stockslist/{id}', name: 'delete_stock', methods: ['DELETE'])]
    public function deleteStock(int $id, StocksRepository $stocksRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $stock = $stocksRepository->find($id);

        if (!$stock) {
            return $this->json(['error' => 'Stock not found'], 404);
        }

        $entityManager->remove($stock);
        $entityManager->flush();

        return $this->json(['message' => 'Stock deleted successfully'], 200);
    }
}