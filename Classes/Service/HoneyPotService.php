<?php
declare(strict_types=1);

namespace Undkonsorten\HoneyPot\Service;

use TYPO3\CMS\Extbase\Mvc\Controller\Argument;
use Undkonsorten\HoneyPot\Validation\HoneyPotValidator;

class HoneyPotService
{

    public function configureHoneyPotForArgument(Argument $argument, $requestArgument, string $propertyName): void
    {
        $argument->getPropertyMappingConfiguration()->skipProperties($propertyName);
        $honeyPotFilledIn = is_array($requestArgument) && isset($requestArgument[$propertyName]) && !empty($requestArgument[$propertyName]);
        $honeyPotValidator = new HoneyPotValidator(['honeyPotFilledIn' => $honeyPotFilledIn, 'propertyPath' => $propertyName]);
        if(method_exists($honeyPotValidator,'setOptions')) {
            $honeyPotValidator->setOptions(['honeyPotFilledIn' => $honeyPotFilledIn, 'propertyPath' => $propertyName]);
        }
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $argument->getValidator()->addValidator($honeyPotValidator);
    }

}
