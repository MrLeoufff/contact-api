<?php

namespace App\Service;

class ContactFormValidator
{
    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['mail'] ?? null) || !filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = 'Adresse mail manquante ou invalide.';
        }

        if (empty($data['name'] ?? null)) {
            $errors['name'] = 'Le nom est manquant.';
        }

        if (empty($data['phone'] ?? null) || !preg_match('/^0[1-9]([-. ]?[0-9]{2}){4}$/', $data['phone'])) {
            $errors['phone'] = '
            Le numéro de téléphone est manquant ou invalide. Il doit être au format 0X XX XX XX XX.';   
        }

        if (empty($data['comment'] ?? null)) {
            $errors['comment'] = 'Le commentaire est manquant.';
        }

        if (empty($data['recaptchaToken'] ?? null)) {
            $errors[] = 'Le reCAPTCHA est requis.';
        }

        return $errors;
    }
}