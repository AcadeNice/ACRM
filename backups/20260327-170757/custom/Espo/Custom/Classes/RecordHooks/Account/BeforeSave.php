<?php

namespace Espo\Custom\Classes\RecordHooks\Account;

use Espo\Core\Record\Hook\SaveHook;
use Espo\ORM\Entity;

class BeforeSave implements SaveHook
{
    public function process(Entity $entity): void
    {
        $type = $entity->get('accountTypeAcadeNice');
        $status = $entity->get('relationStatut');

        if (!$status) {
            $entity->set('relationStatut', 'prospect');

            return;
        }

        if ($type === 'partenaire' && $status === 'client') {
            $entity->set('relationStatut', 'prospect');

            return;
        }

        if ($type !== 'partenaire' && $status === 'partenaire') {
            $entity->set('relationStatut', 'prospect');
        }
    }
}
