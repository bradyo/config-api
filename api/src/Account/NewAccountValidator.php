<?php
namespace Api\Account;

use Api\Validation\ValidationError;

class NewAccountValidator
{
    /**
     * @param NewAccount $newAccount
     * @return ValidationError[]
     */
    public function validate(NewAccount $newAccount)
    {
        $errors = [];
        if (empty($newAccount->getName())) {
            $errors[] = new ValidationError('name', 'cannot be empty');
        }
        if (empty($newAccount->getContactEmailAddress())) {
            $errors[] = new ValidationError('contact_email_address', 'cannot be empty');
        }
        return $errors;
    }
}