<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class IdsessionController extends AbstractController
{
    #[Route('/user/id', name: 'get_user_id', methods: ['GET'])]
    public function getUserId(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'User not logged in'
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'userId' => $user->getId()
        ]);
    }
}
