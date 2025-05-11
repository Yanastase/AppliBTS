<?php

namespace App\Controller;

use App\Repository\ComptesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class AuthController extends AbstractController
{
    #[Route('/auth', name: 'auth', methods: ['POST'])]
    public function auth(Request $request, ComptesRepository $comptesRepository, SessionInterface $session): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $compte = $comptesRepository->findOneBy(['Email' => $email]);

        if (!$compte || $compte->getMotDePasse() !== $password) {
            return $this->json(['error' => 'Invalid credentials'], 401);
        }

        // Retrieve the role ID (num_role_id) from the NumRole property
        $role = $compte->getNumRole();
        $roleId = $role ? $role->getId() : null;

        // Store user details in the session
        $session->set('user_id', $compte->getId());
        $session->set('user_email', $compte->getEmail());
        $session->set('user_role_id', $roleId);

        // Return the user details, including the role ID
        return $this->json([
            'message' => 'Login successful',
            'userId' => $compte->getId(),
            'roleId' => $roleId,
        ]);
    }
}