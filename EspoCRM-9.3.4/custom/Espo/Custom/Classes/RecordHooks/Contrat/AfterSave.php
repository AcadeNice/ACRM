<?php

namespace Espo\Custom\Classes\RecordHooks\Contrat;

use Espo\Core\Record\Hook\SaveHook;
use Espo\Custom\Classes\Organisation\ContratStatsUpdater;
use Espo\ORM\Entity;

class AfterSave implements SaveHook
{
    public function __construct(
        private ContratStatsUpdater $contratStatsUpdater,
    ) {}

    public function process(Entity $entity): void
    {
        $accountId = $entity->get('accountId');
        $fetchedAccountId = $entity->isNew() ? null : $entity->getFetched('accountId');

        $this->contratStatsUpdater->updateForAccountId($accountId);

        if ($fetchedAccountId && $fetchedAccountId !== $accountId) {
            $this->contratStatsUpdater->updateForAccountId($fetchedAccountId);
        }
    }
}
