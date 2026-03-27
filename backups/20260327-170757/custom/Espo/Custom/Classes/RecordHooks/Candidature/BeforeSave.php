<?php

namespace Espo\Custom\Classes\RecordHooks\Candidature;

use Espo\Core\Record\Hook\SaveHook;
use Espo\ORM\Entity;
use Espo\ORM\EntityManager;

class BeforeSave implements SaveHook
{
    public function __construct(
        private EntityManager $entityManager,
    ) {}

    public function process(Entity $entity): void
    {
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
}
