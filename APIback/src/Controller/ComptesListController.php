<?php

namespace App\Controller;

use App\Entity\Comptes;
use App\Repository\ComptesRepository;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ComptesListController extends AbstractController
{
    #[Route('/comptesList', name: 'get_comptes', methods: ['GET'])]
    public function getComptes(ComptesRepository $comptesRepository, SerializerInterface $serializer): JsonResponse
    {
        $comptes = $comptesRepository->findAll();

        $data = $serializer->serialize($comptes, 'json', ['groups' => 'compte:read']);

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/comptes', name: 'add_compte', methods: ['POST'])]
    public function addCompte(Request $request, EntityManagerInterface $entityManager, RoleRepository $roleRepository): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $compte = new Comptes();
        $compte->setIdentifiant($content['identifiant']);
        $compte->setEmail($content['email']);
        $compte->setNumTel($content['numTel']);
        $compte->setMotDePasse($content['motDePasse']); // Ensure password is hashed

        // Set NumRole to 2
        $role = $roleRepository->find(2);
        if (!$role) {
            return $this->json(['error' => 'Role with id=2 not found'], 404);
        }
        $compte->setNumRole($role);

        $entityManager->persist($compte);
        $entityManager->flush();

        return $this->json(['message' => 'Compte added successfully'], 201);
    }

    #[Route('/comptesList/{id}', name: 'edit_compte', methods: ['PUT','GET'])]
    public function editCompte(int $id, Request $request, ComptesRepository $comptesRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $compte = $comptesRepository->find($id);

        if (!$compte) {
            return $this->json(['error' => 'Compte not found'], 404);
        }

        $content = json_decode($request->getContent(), true);

        if (isset($content['identifiant'])) {
            $compte->setIdentifiant($content['identifiant']);
        }
        if (isset($content['email'])) {
            $compte->setEmail($content['email']);
        }
        if (isset($content['numTel'])) {
            $compte->setNumTel($content['numTel']);
        }
        if (isset($content['motDePasse'])) {
            $compte->setMotDePasse($content['motDePasse']); // Ensure password is hashed
        }
        if (isset($content['numRole'])) {
            $compte->setNumRole($content['numRole']); // Update NumRole if provided
        }

        $entityManager->flush();

        return $this->json(['message' => 'Compte updated successfully'], 200);
    }

    #[Route('/comptesList/{id}', name: 'delete_compte', methods: ['DELETE'])]
    public function deleteCompte(int $id, ComptesRepository $comptesRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $compte = $comptesRepository->find($id);

        if (!$compte) {
            return $this->json(['error' => 'Compte not found'], 404);
        }

        $entityManager->remove($compte);
        $entityManager->flush();

        return $this->json(['message' => 'Compte deleted successfully'], 200);
    }
}