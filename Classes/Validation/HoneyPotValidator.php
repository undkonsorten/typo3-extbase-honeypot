<?php
declare(strict_types=1);

namespace Undkonsorten\HoneyPot\Validation;

use TYPO3\CMS\Extbase\Validation\Error;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class HoneyPotValidator extends AbstractValidator
{

    protected $supportedOptions = [
        'honeyPotFilledIn' => [false, 'Boolean value', 'boolean'],
        'propertyPath' => ['_hp', 'Property Path for assigning the error', 'string'],
    ];

    protected function isValid($value): void
    {
        if ($this->getOptions()['honeyPotFilledIn']) {
            $propertyPath = $this->getOptions()['propertyPath'];
            $this->result->forProperty($propertyPath)
                ->addError(new Error('Do not fill in this field!', 1663185337));
        }
    }
}
