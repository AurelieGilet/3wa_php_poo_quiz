<?php

namespace App\Validation;

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
                        case substr($rule, 0, 3) === 'min':
                            $this->min($name, $this->data[$name], $rule);
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
            $this->errors[$name][] = 'Ce champ est requis';
        }
    }

    private function emailValidation(string $name, string $value): void
    {
        $value = trim($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name][] = 'Cet email est invalide';
        }
    }

    private function passwordValidation(string $name, string $value): void
    {
        $pattern = '/(.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$)/';

        if (!preg_match($pattern, $value)) {
            $this->errors[$name][] = 'Votre mot de passe doit faire au minimum 8 caractères 
            et contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial';
        }
    }

    private function min(string $name, string $value, string $rule): void
    {
        // match all digits in the string
        preg_match_all('/(\d+)/', $rule, $matches);

        $limit = (int)$matches[0][0];

        if (strlen($value) < $limit) {
            $this->errors[$name][] = 'Ce champ doit faire au minimum ' . $limit . ' caractères';
        }
    }
}
