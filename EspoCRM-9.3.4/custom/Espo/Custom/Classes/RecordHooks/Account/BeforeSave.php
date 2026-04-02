<?php

namespace Espo\Custom\Classes\RecordHooks\Account;

use Espo\Core\Record\Hook\SaveHook;
use Espo\ORM\Entity;

class BeforeSave implements SaveHook
{
    public function process(Entity $entity): void
    {
        $this->syncAgencyRelationStatus($entity);
        $this->syncMainRelationStatus($entity);

        if (!$entity->get('relationStatut')) {
            $entity->set('relationStatut', 'prospect');
        }
    }

    private function syncAgencyRelationStatus(Entity $entity): void
    {
        if ($entity->get('statutCommercialAgence') !== 'client') {
            return;
        }

        $entity->set('statutRelationAgence', 'client');
    }

    private function syncMainRelationStatus(Entity $entity): void
    {
        if (
            !$entity->isAttributeChanged('statutRelationCfa') &&
            !$entity->isAttributeChanged('statutRelationAgence') &&
            !$entity->isAttributeChanged('statutCommercialAgence')
        ) {
            return;
        }

        $cfaStatus = $entity->get('statutRelationCfa');
        $agencyStatus = $entity->get('statutRelationAgence');

        if ($cfaStatus === 'partenaire') {
            $entity->set('relationStatut', 'partenaire');

            return;
        }

        if ($cfaStatus === 'client' || $agencyStatus === 'client') {
            $entity->set('relationStatut', 'client');

            return;
        }

        if ($cfaStatus === 'prospect' && $agencyStatus !== 'client') {
            $entity->set('relationStatut', 'prospect');

            return;
        }

        if ($agencyStatus === 'prospect' && $cfaStatus !== 'client') {
            $entity->set('relationStatut', 'prospect');
        }
    }
}
