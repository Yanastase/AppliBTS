<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Comptes;
use App\Entity\Boisson;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PanierListController extends AbstractController
{
    #[Route('/panierList', name: 'get_panier', methods: ['GET'])]
    public function getPanier(PanierRepository $panierRepository): JsonResponse
    {
        $paniers = $panierRepository->findAll();

        // Transform the data to include details from Panier, Comptes, and Boisson
        $data = array_map(fn($panier) => [
            'id' => $panier->getId(),
            'Quantity' => $panier->getQuantity(),
            'CreationPanier' => $panier->getCreationPanier()->format('Y-m-d H:i:s'),
            'NumCompte' => $panier->getNumCompte() ? [
                'id' => $panier->getNumCompte()->getId(),
                'identifiant' => $panier->getNumCompte()->getIdentifiant(),
                'email' => $panier->getNumCompte()->getEmail(),
                'numTel' => $panier->getNumCompte()->getNumTel(),
            ] : null, // Handle cases where NumCompte is null
            'Boisson' => $panier->getNumProduit() ? [
                'id' => $panier->getNumProduit()->getId(),
                'nom' => $panier->getNumProduit()->getNom(),
                'logo' => $panier->getNumProduit()->getLogo(),
                'prix' => $panier->getNumProduit()->getPrix(),
            ] : null, // Handle cases where Boisson is null
        ], $paniers);

        return $this->json($data, 200);
    }

    #[Route('/panieradd', name: 'add_to_panier', methods: ['POST'])]
    public function addToPanier(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        if (!isset($content['quantity']) || !isset($content['numCompte']) || !isset($content['numBoisson'])) {
            return $this->json(['error' => 'Invalid data'], 400);
        }

        $compte = $entityManager->getRepository(Comptes::class)->find($content['numCompte']);
        if (!$compte) {
            return $this->json(['error' => 'Compte not found'], 404);
        }

        $boisson = $entityManager->getRepository(Boisson::class)->find($content['numBoisson']);
        if (!$boisson) {
            return $this->json(['error' => 'Boisson not found'], 404);
        }

        $panier = new Panier();
        $panier->setQuantity($content['quantity']);
        $panier->setNumCompte($compte);
        $panier->setNumProduit($boisson);
        $panier->setCreationPanier(new \DateTime()); // Set the current date and time

        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->json(['message' => 'Item added to panier'], 201);
    }

    #[Route('/panier/{id}', name: 'delete_from_panier', methods: ['DELETE'])]
    public function deleteFromPanier(int $id, PanierRepository $panierRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $panier = $panierRepository->find($id);

        if (!$panier) {
            return $this->json(['error' => 'Item not found'], 404);
        }

        $entityManager->remove($panier);
        $entityManager->flush();

        return $this->json(['message' => 'Item removed from panier'], 200);
    }

    #[Route('/panier/{id}', name: 'edit_panier', methods: ['PUT'])]
    public function editPanier(int $id, Request $request, PanierRepository $panierRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $panier = $panierRepository->find($id);

        if (!$panier) {
            return $this->json(['error' => 'Item not found'], 404);
        }

        $content = json_decode($request->getContent(), true);

        if (isset($content['quantity'])) {
            $panier->setQuantity($content['quantity']);
        }

        if (isset($content['numBoisson'])) {
            $boisson = $entityManager->getRepository(Boisson::class)->find($content['numBoisson']);
            if (!$boisson) {
                return $this->json(['error' => 'Boisson not found'], 404);
            }
            $panier->setNumProduit($boisson);
        }

        $entityManager->flush();

        return $this->json(['message' => 'Item updated successfully'], 200);
    }
}