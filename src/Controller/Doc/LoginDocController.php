<?php

namespace App\Controller\Doc;

use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/_doc-only-login')]
class LoginDocController extends AbstractController
{
    #[OA\Post(
        path: '/api/login',
        summary: 'Obtenir un token JWT',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['username', 'password'],
                properties: [
                    new OA\Property(property: 'username', type: 'string', example: 'admin'),
                    new OA\Property(property: 'password', type: 'string', example: 'password')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Token JWT',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGci...')
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Identifiants invalides')
        ]
    )]
    public function docOnly(): void
    {
    }
}
