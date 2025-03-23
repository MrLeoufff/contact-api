<?php

namespace App\Controller\Api;

use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ContactFormValidator;
use App\Controller\Doc\LoginDocController;
use App\Controller\Doc\ContactDocController;


final class ContactController extends AbstractController{
    #[Route('/api/contact', name: 'api_contact', methods: ['POST'])]

    public function contact(
        Request $request, 
        MailerInterface $mailer,
        ContactFormValidator $validator,
        RateLimiterFactory $contactApiLimiter
        ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $errors = $validator->validate($data);

        if (count ($errors) > 0) {
            return $this->json(['error' => $errors], 400);
        }

        $limiter = $contactApiLimiter->create($request->getClientIp());

        if (!$limiter->consume(1)->isAccepted()) {
            return $this->json(['error' => "T'abuse tonton, tranquille sur les mails."], 429);
        }

        $email = (new TemplatedEmail())
            ->from (new Address('contact@dpi.fr', 'DPI Contact'))
            ->to ('contact@dpi.fr')
            ->subject('Nouvelle demande de contact')
            ->htmlTemplate('api/contact/demande-contact.html.twig')
            ->context([
                'formData' => $data,
            ]);

            $mailer->send($email);

            return $this->json(['status'=> 'Mama la beauté du mail'],202);
    }
}
