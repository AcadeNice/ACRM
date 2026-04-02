<?php

namespace Espo\Custom\Classes\Organisation;

use DateTimeImmutable;
use Espo\ORM\EntityManager;
use Espo\ORM\Repository\Option\SaveOption;

class ContratStatsUpdater
{
    public function __construct(
        private EntityManager $entityManager,
    ) {}

    public function updateForAccountId(?string $accountId): void
    {
        if (!$accountId) {
            return;
        }

        $account = $this->entityManager->getRepository('Account')->getById($accountId);

        if (!$account) {
            return;
        }

        $signedRelation = $this->entityManager
            ->getRepository('Account')
            ->getRelation($account, 'contrats')
            ->where(['statutContrat' => 'signe']);

        $thresholdDate = (new DateTimeImmutable('today'))
            ->modify('-12 months')
            ->format('Y-m-d');

        $signedLast12MonthsRelation = $this->entityManager
            ->getRepository('Account')
            ->getRelation($account, 'contrats')
            ->where([
                'statutContrat' => 'signe',
                'dateDebut>=' => $thresholdDate,
            ]);

        $latestSignedContrat = $this->entityManager
            ->getRepository('Account')
            ->getRelation($account, 'contrats')
            ->where(['statutContrat' => 'signe'])
            ->order('dateDebut', 'DESC')
            ->findOne();

        $account->set('nbContratsSignes', $signedRelation->count());
        $account->set('nbContrats12Mois', $signedLast12MonthsRelation->count());
        $account->set(
            'dernierContratSigneLe',
            $latestSignedContrat?->get('dateDebut')
        );

        $this->entityManager->saveEntity($account, [
            SaveOption::SKIP_ALL => true,
        ]);
    }
}
