<?php

namespace Espo\Custom\Classes\RecordHooks\Candidature;

use DateTimeImmutable;
use Espo\Core\Record\Hook\SaveHook;
use Espo\ORM\Entity;
use Espo\ORM\EntityManager;

class BeforeSave implements SaveHook
{
    private const FINAL_STATUSES = [
        'acceptee',
        'refuseeEntreprise',
        'refuseeCandidat',
        'abandonnee',
        'transformeeContrat',
    ];

    public function __construct(
        private EntityManager $entityManager,
    ) {}

    public function process(Entity $entity): void
    {
        $this->syncWorkflowStatus($entity);

        $contactId = $entity->get('contactId');
        $opportunityId = $entity->get('opportunityId');

        if (!$contactId || !$opportunityId) {
            return;
        }

        $contact = $this->entityManager->getRepository('Contact')->getById($contactId);
        $opportunity = $this->entityManager->getRepository('Opportunity')->getById($opportunityId);

        if (!$contact || !$opportunity) {
            return;
        }

        $entity->set('accountId', $opportunity->get('accountId'));

        $contactLabel = trim(implode(' ', array_filter([
            $contact->get('firstName'),
            $contact->get('lastName'),
        ])));

        $organisationLabel = $opportunity->get('accountName');

        if (!$organisationLabel && $opportunity->get('accountId')) {
            $account = $this->entityManager
                ->getRepository('Account')
                ->getById($opportunity->get('accountId'));

            $organisationLabel = $account?->get('name');
        }

        $offerLabel = $opportunity->get('name');

        $parts = array_filter([
            $contactLabel,
            $organisationLabel,
            $offerLabel,
        ], fn ($value) => $value !== null && $value !== '');

        if (!$parts) {
            return;
        }

        $entity->set('name', implode(' - ', $parts));
    }

    private function syncWorkflowStatus(Entity $entity): void
    {
        $status = $entity->get('statutCandidature');
        $decision = $entity->get('decisionEntreprise');
        $dateEnvoiCv = $entity->get('dateEnvoiCv');
        $dateEntretien = $entity->get('dateEntretien');

        if ($decision === 'acceptee') {
            $entity->set('statutCandidature', 'acceptee');

            return;
        }

        if ($decision === 'refusee') {
            $entity->set('statutCandidature', 'refuseeEntreprise');

            return;
        }

        if (in_array($status, self::FINAL_STATUSES, true)) {
            return;
        }

        if ($decision === 'enAttente' && in_array($status, ['entretienPlanifie', 'enAttenteRetour'], true)) {
            $entity->set('statutCandidature', 'enAttenteRetour');

            return;
        }

        if ($this->isPastDate($dateEntretien)) {
            $entity->set('decisionEntreprise', 'enAttente');
            $entity->set('statutCandidature', 'enAttenteRetour');

            return;
        }

        if ($dateEntretien) {
            $entity->set('statutCandidature', 'entretienPlanifie');

            return;
        }

        if ($dateEnvoiCv && in_array($status, ['aProposer', 'proposee', 'cvEnvoye'], true)) {
            $entity->set('statutCandidature', 'cvEnvoye');
        }
    }

    private function isPastDate(?string $date): bool
    {
        if (!$date) {
            return false;
        }

        try {
            $dateObject = new DateTimeImmutable($date);
        } catch (\Throwable) {
            return false;
        }

        return $dateObject < new DateTimeImmutable('today');
    }
}
