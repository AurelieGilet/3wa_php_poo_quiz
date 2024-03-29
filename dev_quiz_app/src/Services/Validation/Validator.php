<?php

namespace App\Services\Validation;

class Validator
{
    private $data;
    private $errors;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules): ?array
    {
        foreach ($rules as $name => $rulesArray) {
            if (array_key_exists($name, $this->data)) {
                foreach ($rulesArray as $rule) {
                    switch ($rule) {
                        case 'required':
                            $this->required($name, $this->data[$name]);
                            break;
                        case 'emailValidation':
                            $this->emailValidation($name, $this->data[$name]);
                            break;
                        case 'passwordValidation':
                            $this->passwordValidation($name, $this->data[$name]);
                            break;
                        case 'updatePassword':
                            $this->updatePassword(
                                $name,
                                $this->data[$name],
                                $this->data[$name . 'Repeat']
                            );
                            break;
                        case substr($rule, 0, 3) === 'min':
                            $this->min($name, $this->data[$name], $rule);
                            break;
                        case 'answersMin':
                            $this->minAnswers(
                                $name,
                                $this->data[$name],
                            );
                            break;
                        case 'isGoodAnswer':
                            $this->isGoodAnswer(
                                $name,
                                $this->data[$name]
                            );
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
        }

        return $this->getErrors();
    }

    private function getErrors(): ?array
    {
        return $this->errors;
    }

    private function required(string $name, string $value): void
    {
        $value = trim($value);

        if (!isset($value) || is_null($value) || empty($value)) {
            $this->errors[$name][] = 'Ce champ est requis.';
        }
    }

    private function emailValidation(string $name, string $value): void
    {
        $value = trim($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name][] = 'Cet email est invalide.';
        }
    }

    private function passwordValidation(string $name, string $value): void
    {
        $pattern = '/(.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$)/';

        if (!preg_match($pattern, $value)) {
            $this->errors[$name][] = 'Votre mot de passe doit faire au minimum 8 caractères 
            et contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.';
        }
    }

    private function updatePassword(string $name, string $value, string $repeatValue)
    {
        // If none of the password fields contains value, the user doesn't wish to change it
        // No need to go through the verifications
        if (!trim($value)) {
            return;
        }

        if (trim($value) && !trim($repeatValue) || !trim($value) && trim($repeatValue)) {
            $this->errors[$name][] = 'Pour modifier votre mot de passe, les 2 champs doivent être remplis.';
        }

        if (trim($value) !== trim($repeatValue)) {
            $this->errors[$name][] = 'Votre nouveau mot de passe ne correspond pas, 
            veuillez entrer 2 fois la même valeur.';
        }

        $this->passwordValidation($name, $value);
    }

    private function min(string $name, string $value, string $rule): void
    {
        // match all digits in the string
        preg_match_all('/(\d+)/', $rule, $matches);

        $limit = (int)$matches[0][0];

        if (strlen($value) < $limit) {
            $this->errors[$name][] = 'Ce champ doit faire au minimum ' . $limit . ' caractères.';
        }
    }

    private function minAnswers(string $name, array $values): void
    {
        $nbAnswers = 0;

        foreach ($values as $value) {
            if (trim($value['content']) !== '') {
                $nbAnswers++;
            }
        }

        if ($nbAnswers < 2) {
            $this->errors[$name][] = "Vous devez renseigner au moins 2 réponses pour cette question.";
        }
    }

    private function isGoodAnswer(string $name, array $values): void
    {
        $nbGoodAnswers = 0;
        $wrongGoodAnswer = false;

        foreach ($values as $value) {
            if (isset($value['goodAnswer'])) {
                $nbGoodAnswers++;
            }

            if (isset($value['goodAnswer']) && trim($value['content']) === '') {
                $wrongGoodAnswer = true;
            }
        }
        
        if ($nbGoodAnswers === 0) {
            $this->errors[$name][] = "Vous devez choisir une des réponses comme étant la bonne.";
        }

        if ($nbGoodAnswers > 1) {
            $this->errors[$name][] = "Une seule des réponse peut être la bonne, merci de n'en sélectionner qu'une.";
        }

        if ($wrongGoodAnswer) {
            $this->errors[$name][] = "La réponse que vous avez indiquée comme étant la bonne est vide.";
        }
    }
}
