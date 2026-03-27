<?php

namespace Espo\Custom\Classes\RecordHooks\ContratName;

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
        $candidatureId = $entity->get('candidatureId');
        $promotionId = $entity->get('promotionId');
        $category = $entity->get('contractCategory');

        if (!$candidatureId || !$category) {
            return;
        }

        $candidature = $this->entityManager->getRepository('Candidature')->getById($candidatureId);

        if (!$candidature) {
            return;
        }

        $contact = null;
        $account = null;
        $opportunity = null;
        $formation = null;

        if ($candidature->get('contactId')) {
            $contact = $this->entityManager->getRepository('Contact')->getById($candidature->get('contactId'));
            $entity->set('contactId', $candidature->get('contactId'));
        }

        if ($candidature->get('opportunityId')) {
            $entity->set('opportunityId', $candidature->get('opportunityId'));
            $opportunity = $this->entityManager->getRepository('Opportunity')->getById($candidature->get('opportunityId'));

            if ($opportunity && $opportunity->get('accountId')) {
                $entity->set('accountId', $opportunity->get('accountId'));
                $account = $this->entityManager->getRepository('Account')->getById($opportunity->get('accountId'));
            }
        }

        if ($promotionId) {
            $promotion = $this->entityManager->getRepository('Promotion')->getById($promotionId);

            if ($promotion && $promotion->get('formationId')) {
                $entity->set('formationId', $promotion->get('formationId'));
                $formation = $this->entityManager->getRepository('Formation')->getById($promotion->get('formationId'));
            }
        }

        if (!$formation && $opportunity && $opportunity->get('formationId')) {
            $entity->set('formationId', $opportunity->get('formationId'));
        }

        if (!$contact || !$account) {
            return;
        }

        $contactLabel = trim(implode(' ', array_filter([
            $contact->get('firstName'),
            $contact->get('lastName'),
        ])));

        $categoryLabel = match ($category) {
            'alternance' => 'Alternance',
            'initiale' => 'Initiale',
            'courte' => 'Courte',
            default => $category,
        };

        $parts = array_filter([
            $contactLabel,
            $account->get('name'),
            $categoryLabel,
        ], fn ($value) => $value !== null && $value !== '');

        if (!$parts) {
            return;
        }

        $entity->set('name', implode(' - ', $parts));
    }
}
