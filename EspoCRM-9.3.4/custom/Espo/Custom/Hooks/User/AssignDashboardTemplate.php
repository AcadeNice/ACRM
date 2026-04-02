<?php

namespace Espo\Custom\Hooks\User;

use Espo\Core\ORM\Repository\Option\SaveOption;
use Espo\Entities\DashboardTemplate;
use Espo\Entities\User;
use Espo\ORM\Entity;
use Espo\ORM\EntityManager;

class AssignDashboardTemplate
{
    /**
     * Ordered by priority for users with multiple roles.
     *
     * @var array<string, string>
     */
    private const TEMPLATE_NAME_BY_ROLE = [
        'Admin CRM' => 'Tableau de bord - Admin CRM',
        'Recrutement' => 'Tableau de bord - Recrutement',
        'Assistance pédagogique' => 'Tableau de bord - Assistance pédagogique',
        'Marketing' => 'Tableau de bord - Marketing',
        'Développeur' => 'Tableau de bord - Développeur',
        'Assistance technique' => 'Tableau de bord - Assistance technique',
    ];

    public function __construct(private EntityManager $entityManager)
    {
    }

    /**
     * @param array<string, mixed> $options
     */
    public function afterSave(Entity $entity, array $options = []): void
    {
        if (!$entity instanceof User) {
            return;
        }

        $this->syncDashboardTemplate($entity);
    }

    /**
     * @param array<string, mixed> $options
     * @param array<string, mixed> $data
     */
    public function afterRelate(Entity $entity, array $options = [], array $data = []): void
    {
        if (
            !$entity instanceof User ||
            ($data['relationName'] ?? null) !== User::LINK_ROLES
        ) {
            return;
        }

        $this->syncDashboardTemplate($entity);
    }

    /**
     * @param array<string, mixed> $options
     * @param array<string, mixed> $data
     */
    public function afterUnrelate(Entity $entity, array $options = [], array $data = []): void
    {
        if (
            !$entity instanceof User ||
            ($data['relationName'] ?? null) !== User::LINK_ROLES
        ) {
            return;
        }

        $this->syncDashboardTemplate($entity);
    }

    private function syncDashboardTemplate(User $user): void
    {
        if ($user->isPortal() || $user->isApi() || $user->isSystem()) {
            return;
        }

        $user = $this->entityManager->getEntityById(User::ENTITY_TYPE, $user->getId());

        if (!$user instanceof User) {
            return;
        }

        $templateId = $this->resolveTemplateId($user);

        if ($user->get('dashboardTemplateId') === $templateId) {
            return;
        }

        $user->set('dashboardTemplateId', $templateId);

        $this->entityManager->saveEntity($user, [
            SaveOption::SKIP_HOOKS => true,
        ]);
    }

    private function resolveTemplateId(User $user): ?string
    {
        $templateName = $this->resolveTemplateName($user);

        if (!$templateName) {
            return null;
        }

        $template = $this->entityManager
            ->getRDBRepository(DashboardTemplate::ENTITY_TYPE)
            ->where([
                'name' => $templateName,
            ])
            ->findOne();

        return $template?->getId();
    }

    private function resolveTemplateName(User $user): ?string
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return self::TEMPLATE_NAME_BY_ROLE['Admin CRM'];
        }

        $roleNames = [];

        foreach ($this->entityManager->getRelation($user, User::LINK_ROLES)->find() as $role) {
            $name = $role->get('name');

            if (is_string($name) && $name !== '') {
                $roleNames[] = $name;
            }
        }

        foreach (self::TEMPLATE_NAME_BY_ROLE as $roleName => $templateName) {
            if (in_array($roleName, $roleNames, true)) {
                return $templateName;
            }
        }

        return null;
    }
}
