<?php

namespace Espo\Custom\Classes\RecordHooks\Contact;

use DateTimeImmutable;
use Espo\Core\Exceptions\BadRequest;
use Espo\Core\Record\Hook\SaveHook;
use Espo\ORM\Entity;

class BeforeSave implements SaveHook
{
    public function process(Entity $entity): void
    {
        $this->validateExclusiveParcoursRoles($entity);
        $this->syncCandidateStatusFromRoles($entity);
        $this->syncFormerCandidateRole($entity);
        $this->syncStudentRole($entity);
        $this->syncTestStatus($entity);
        $this->syncCandidateStatusFromTest($entity);

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

    private function validateExclusiveParcoursRoles(Entity $entity): void
    {
        if (!$entity->isAttributeChanged('contactRoles')) {
            return;
        }

        $roles = $entity->get('contactRoles');

        if (!is_array($roles)) {
            $roles = $roles ? [$roles] : [];
        }

        $parcoursRoles = array_values(array_intersect(
            $roles,
            ['candidat', 'ancienCandidat', 'etudiant', 'alumni']
        ));

        if (count(array_unique($parcoursRoles)) <= 1) {
            return;
        }

        throw new BadRequest(
            "Un contact ne peut avoir qu'un seul role de parcours parmi Candidat, Ancien candidat, Etudiant et Alumni."
        );
    }

    private function syncStudentRole(Entity $entity): void
    {
        $status = $entity->get('statutCandidat');

        if (!in_array($status, ['place', 'alumni'], true)) {
            return;
        }

        $roles = $entity->get('contactRoles');

        if (!is_array($roles)) {
            $roles = $roles ? [$roles] : [];
        }

        $roles = array_values(array_unique(array_filter(
            $roles,
            fn ($role) => is_string($role) && $role !== '' && !in_array($role, ['candidat', 'ancienCandidat', 'etudiant', 'alumni'], true)
        )));

        $roles[] = $status === 'alumni' ? 'alumni' : 'etudiant';

        $entity->set('contactRoles', $roles);
    }

    private function syncCandidateStatusFromRoles(Entity $entity): void
    {
        if (!$entity->isAttributeChanged('contactRoles')) {
            return;
        }

        $roles = $entity->get('contactRoles');

        if (!is_array($roles)) {
            $roles = $roles ? [$roles] : [];
        }

        if (in_array('alumni', $roles, true)) {
            $entity->set('statutCandidat', 'alumni');

            return;
        }

        if (in_array('etudiant', $roles, true)) {
            $entity->set('statutCandidat', 'place');

            return;
        }

        if (in_array('ancienCandidat', $roles, true)) {
            $entity->set('statutCandidat', 'abandon');

            return;
        }

        if (in_array('candidat', $roles, true)) {
            $entity->set('statutCandidat', 'nouveau');
        }
    }

    private function syncFormerCandidateRole(Entity $entity): void
    {
        $status = $entity->get('statutCandidat');

        if (!in_array($status, ['abandon', 'nonRetenu', 'injoignable', 'reporte', 'refuse', 'refusee'], true)) {
            return;
        }

        $roles = $entity->get('contactRoles');

        if (!is_array($roles)) {
            $roles = $roles ? [$roles] : [];
        }

        $roles = array_values(array_unique(array_filter(
            $roles,
            fn ($role) => is_string($role) && $role !== '' && !in_array($role, ['candidat', 'ancienCandidat', 'etudiant', 'alumni'], true)
        )));

        $roles[] = 'ancienCandidat';

        $entity->set('contactRoles', $roles);
    }

    private function syncTestStatus(Entity $entity): void
    {
        if ($entity->get('statutCandidat') !== 'testEnCours') {
            return;
        }

        $entity->set('testResultat', 'enCours');
    }

    private function syncCandidateStatusFromTest(Entity $entity): void
    {
        if ($entity->get('testResultat') !== 'reussi') {
            return;
        }

        $entity->set('statutCandidat', 'admis');
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
