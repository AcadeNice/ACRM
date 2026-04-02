<?php

namespace Espo\Custom\Classes\RecordHooks\Contrat;

use Espo\Core\Record\DeleteParams;
use Espo\Core\Record\Hook\DeleteHook;
use Espo\Custom\Classes\Organisation\ContratStatsUpdater;
use Espo\ORM\Entity;

class AfterDelete implements DeleteHook
{
    public function __construct(
        private ContratStatsUpdater $contratStatsUpdater,
    ) {}

    public function process(Entity $entity, DeleteParams $params): void
    {
        $this->contratStatsUpdater->updateForAccountId($entity->get('accountId'));
    }
}
