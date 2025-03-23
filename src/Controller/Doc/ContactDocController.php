<?php

namespace App\Controller\Doc;

use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/_doc-only-contact')]
class ContactDocController extends AbstractController
{
#[OA\Post(
    path: '/api/contact',
    summary: 'Soumettre une demande de contact via un formulaire JSON',
    description: 'Ce endpoint permet d\'envoyer une demande de contact sécurisée avec JWT, reCAPTCHA et validation.',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['mail', 'name', 'phone', 'comment', 'recaptchaToken'],
            properties: [
                new OA\Property(property: 'company', type: 'string', example: 'DPI'),
                new OA\Property(property: 'name', type: 'string', example: 'Jean Dupont'),
                new OA\Property(property: 'function', type: 'string', example: 'Responsable IT'),
                new OA\Property(property: 'mail', type: 'string', format: 'email', example: 'jean@dpi.fr'),
                new OA\Property(property: 'phone', type: 'string', example: '0601020304'),
                new OA\Property(property: 'comment', type: 'string', example: 'Bonjour, j’aimerais un site.'),
                new OA\Property(property: 'recaptchaToken', type: 'string', example: 'abcdef...')
            ]
        )
    ),
    responses: [
        new OA\Response(response: 202, description: 'Demande envoyée avec succès'),
        new OA\Response(response: 400, description: 'Erreur de validation ou reCAPTCHA'),
        new OA\Response(response: 429, description: 'Trop de requêtes')
    ],
    security: [
        ['Bearer' => []]
    ],
    tags: ['Contact']
)]
    public function docOnly(): void
    {
    }
}
