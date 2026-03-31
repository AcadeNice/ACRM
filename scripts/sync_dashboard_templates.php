<?php

$dsn = 'mysql:unix_socket=/tmp/mysql.sock;dbname=espocrm_acadenice;charset=utf8mb4';
$username = 'espocrm_local';
$password = 'EspoLocal!2026';

$dashletTitles = [
    'NewCandidates' => 'Nouveaux candidats',
    'TestsInProgress' => 'Tests en cours',
    'CandidaturesToPropose' => 'Candidatures à proposer',
    'CvsToSend' => 'CV à envoyer',
    'UpcomingInterviews' => 'Entretiens à venir',
    'ContractsToFinalize' => 'Contrats à finaliser',
    'IncomingTickets' => 'Tickets entrants',
    'OpenOpportunities' => 'Offres ouvertes',
    'ActiveCampaigns' => 'Campagnes actives',
    'UsefulTargetLists' => 'Listes de diffusion',
];

$templates = [
    'Tableau de bord - Admin CRM' => [
        'tabName' => 'Admin CRM',
        'dashlets' => [
            'NewCandidates',
            'TestsInProgress',
            'CandidaturesToPropose',
            'ContractsToFinalize',
            'CvsToSend',
            'IncomingTickets',
            'UpcomingInterviews',
            'OpenOpportunities',
            'ActiveCampaigns',
            'UsefulTargetLists',
        ],
    ],
    'Tableau de bord - Recrutement' => [
        'tabName' => 'Recrutement',
        'dashlets' => [
            'NewCandidates',
            'TestsInProgress',
            'CandidaturesToPropose',
            'ContractsToFinalize',
            'CvsToSend',
            'IncomingTickets',
            'UpcomingInterviews',
            'OpenOpportunities',
            'ActiveCampaigns',
            'UsefulTargetLists',
        ],
    ],
    'Tableau de bord - Assistance pédagogique' => [
        'tabName' => 'Assistance pédagogique',
        'dashlets' => [
            'NewCandidates',
            'TestsInProgress',
            'CandidaturesToPropose',
            'ContractsToFinalize',
            'UpcomingInterviews',
            'IncomingTickets',
            'ActiveCampaigns',
            'UsefulTargetLists',
        ],
    ],
    'Tableau de bord - Marketing' => [
        'tabName' => 'Marketing',
        'dashlets' => [
            'OpenOpportunities',
            'IncomingTickets',
            'ActiveCampaigns',
            'UsefulTargetLists',
        ],
    ],
    'Tableau de bord - Développeur' => [
        'tabName' => 'Développeur',
        'dashlets' => [
            'NewCandidates',
            'TestsInProgress',
            'CandidaturesToPropose',
            'ContractsToFinalize',
            'CvsToSend',
            'IncomingTickets',
            'UpcomingInterviews',
            'OpenOpportunities',
            'ActiveCampaigns',
            'UsefulTargetLists',
        ],
    ],
    'Tableau de bord - Assistance technique' => [
        'tabName' => 'Assistance technique',
        'dashlets' => [
            'IncomingTickets',
            'ActiveCampaigns',
            'UsefulTargetLists',
        ],
    ],
];

$roleTemplateNameMap = [
    'Admin CRM' => 'Tableau de bord - Admin CRM',
    'Recrutement' => 'Tableau de bord - Recrutement',
    'Assistance pédagogique' => 'Tableau de bord - Assistance pédagogique',
    'Marketing' => 'Tableau de bord - Marketing',
    'Développeur' => 'Tableau de bord - Développeur',
    'Assistance technique' => 'Tableau de bord - Assistance technique',
];

$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$adminIdStmt = $pdo->query("SELECT id FROM user WHERE user_name = 'admin' AND deleted = 0 LIMIT 1");
$adminId = $adminIdStmt->fetchColumn() ?: null;

$templateIdMap = [];

foreach ($templates as $templateName => $definition) {
    $slug = slugify($templateName);
    $layout = buildDashboardLayout($slug, $definition['tabName'], $definition['dashlets']);
    $dashletsOptions = buildDashletsOptions($slug, $definition['dashlets'], $dashletTitles);
    $now = gmdate('Y-m-d H:i:s');

    $selectStmt = $pdo->prepare(
        'SELECT id FROM dashboard_template WHERE name = :name AND deleted = 0 LIMIT 1'
    );
    $selectStmt->execute(['name' => $templateName]);
    $templateId = $selectStmt->fetchColumn();

    if ($templateId) {
        $updateStmt = $pdo->prepare(
            'UPDATE dashboard_template
             SET layout = :layout,
                 dashlets_options = :dashletsOptions,
                 modified_at = :modifiedAt,
                 modified_by_id = :modifiedById
             WHERE id = :id'
        );
        $updateStmt->execute([
            'id' => $templateId,
            'layout' => encodeJson($layout),
            'dashletsOptions' => encodeJson((object) $dashletsOptions),
            'modifiedAt' => $now,
            'modifiedById' => $adminId,
        ]);
    } else {
        $templateId = generateId();

        $insertStmt = $pdo->prepare(
            'INSERT INTO dashboard_template
             (id, name, deleted, layout, dashlets_options, created_at, modified_at, created_by_id, modified_by_id)
             VALUES
             (:id, :name, 0, :layout, :dashletsOptions, :createdAt, :modifiedAt, :createdById, :modifiedById)'
        );
        $insertStmt->execute([
            'id' => $templateId,
            'name' => $templateName,
            'layout' => encodeJson($layout),
            'dashletsOptions' => encodeJson((object) $dashletsOptions),
            'createdAt' => $now,
            'modifiedAt' => $now,
            'createdById' => $adminId,
            'modifiedById' => $adminId,
        ]);
    }

    $templateIdMap[$templateName] = $templateId;
}

$usersStmt = $pdo->query(
    "SELECT id, user_name, type FROM user WHERE deleted = 0 ORDER BY user_name"
);

$roleStmt = $pdo->prepare(
    'SELECT r.name
     FROM role_user ru
     JOIN role r ON r.id = ru.role_id AND r.deleted = 0
     WHERE ru.user_id = :userId'
);

$updateUserStmt = $pdo->prepare(
    'UPDATE user
     SET dashboard_template_id = :dashboardTemplateId
     WHERE id = :id'
);

while ($user = $usersStmt->fetch(PDO::FETCH_ASSOC)) {
    $templateName = resolveTemplateNameForUser($user['type'] ?? null, (string) $user['id'], $roleStmt, $roleTemplateNameMap);
    $templateId = $templateName ? ($templateIdMap[$templateName] ?? null) : null;

    $updateUserStmt->execute([
        'id' => $user['id'],
        'dashboardTemplateId' => $templateId,
    ]);
}

echo "Dashboard templates synced.\n";

function buildDashboardLayout(string $slug, string $tabName, array $dashlets): array
{
    $layout = [];

    foreach (array_values($dashlets) as $index => $dashletName) {
        $column = $index % 2;
        $row = intdiv($index, 2);

        $layout[] = [
            'id' => sprintf('%s-%s', $slug, slugify($dashletName)),
            'name' => $dashletName,
            'x' => $column * 2,
            'y' => $row * 2,
            'width' => 2,
            'height' => 2,
        ];
    }

    return [[
        'name' => $tabName,
        'layout' => $layout,
    ]];
}

function buildDashletsOptions(string $slug, array $dashlets, array $dashletTitles): array
{
    $options = [];

    foreach ($dashlets as $dashletName) {
        $id = sprintf('%s-%s', $slug, slugify($dashletName));

        $options[$id] = [
            'title' => $dashletTitles[$dashletName] ?? $dashletName,
            'displayRecords' => 6,
            'autorefreshInterval' => 0.5,
        ];
    }

    return $options;
}

function resolveTemplateNameForUser(?string $type, string $userId, PDOStatement $roleStmt, array $roleTemplateNameMap): ?string
{
    if (in_array($type, ['admin', 'super-admin'], true)) {
        return $roleTemplateNameMap['Admin CRM'];
    }

    $roleStmt->execute(['userId' => $userId]);
    $roleNames = $roleStmt->fetchAll(PDO::FETCH_COLUMN) ?: [];

    foreach ($roleTemplateNameMap as $roleName => $templateName) {
        if (in_array($roleName, $roleNames, true)) {
            return $templateName;
        }
    }

    return null;
}

function slugify(string $value): string
{
    $value = strtr($value, [
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a',
        'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'î' => 'i', 'ï' => 'i',
        'ô' => 'o', 'ö' => 'o',
        'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
        'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a',
        'Ç' => 'c',
        'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e',
        'Î' => 'i', 'Ï' => 'i',
        'Ô' => 'o', 'Ö' => 'o',
        'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u',
    ]);
    $value = strtolower($value);
    $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';

    return trim($value, '-');
}

function generateId(): string
{
    return substr(str_replace('.', '', uniqid('', true)), 0, 17);
}

function encodeJson(mixed $value): string
{
    return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
}
