<?php

namespace Espo\Custom\Classes\RecordHooks\Contact;

use DateTimeImmutable;
use Espo\Core\Record\Hook\SaveHook;
use Espo\ORM\Entity;

class BeforeSave implements SaveHook
{
    public function process(Entity $entity): void
    {
        $birthdate = $entity->get('birthdate');

        if (!$birthdate) {
            $entity->set('estMineur', false);
            $entity->set('emancipe', false);
            $entity->set('responsableLegalId', null);

            return;
        }

        $isMinor = $this->isMinor($birthdate);

        $entity->set('estMineur', $isMinor);

        if ($isMinor) {
            return;
        }

        $entity->set('emancipe', false);
        $entity->set('responsableLegalId', null);
    }

    private function isMinor(string $birthdate): bool
    {
        try {
            $birthdateObject = new DateTimeImmutable($birthdate);
        } catch (\Throwable) {
            return false;
        }

        $majorityDate = (new DateTimeImmutable('today'))->modify('-18 years');

        return $birthdateObject > $majorityDate;
    }
}
