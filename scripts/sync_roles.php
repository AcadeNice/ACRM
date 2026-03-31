<?php

declare(strict_types=1);

$dsn = 'mysql:unix_socket=/tmp/mysql.sock;dbname=espocrm_acadenice;charset=utf8mb4';
$user = 'espocrm_local';
$pass = 'EspoLocal!2026';

$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$streamScopes = [
    'Account',
    'Contact',
    'Opportunity',
    'Candidature',
    'Contrat',
    'Case',
    'Formation',
    'Promotion',
    'Skill',
    'Task',
    'Meeting',
];

$record = static function (
    string $mode,
    string $scope,
    string $readOnlyEdit = 'no'
) use ($streamScopes): array|false {
    $streamable = in_array($scope, $streamScopes, true);

    if ($mode === 'none') {
        return false;
    }

    $data = [
        'create' => 'no',
        'read' => 'all',
        'edit' => 'no',
        'delete' => 'no',
    ];

    if ($mode === 'full') {
        $data = [
            'create' => 'yes',
            'read' => 'all',
            'edit' => 'all',
            'delete' => 'all',
        ];
    } elseif ($mode === 'lcm') {
        $data = [
            'create' => 'yes',
            'read' => 'all',
            'edit' => 'all',
            'delete' => 'no',
        ];
    } elseif ($mode === 'lm') {
        $data['edit'] = 'all';
    } elseif ($mode === 'l') {
        $data['edit'] = $readOnlyEdit;
    } else {
        throw new RuntimeException("Unknown mode for scope {$scope}: {$mode}");
    }

    if ($streamable) {
        $data['stream'] = $data['read'] === 'all' ? 'all' : 'no';
    }

    return $data;
};

$boolean = static fn (bool $enabled): bool => $enabled;

$ownRecord = static function (bool $canCreate = true, bool $canDelete = true, bool $stream = false): array {
    $data = [
        'create' => $canCreate ? 'yes' : 'no',
        'read' => 'own',
        'edit' => 'own',
        'delete' => $canDelete ? 'own' : 'no',
    ];

    if ($stream) {
        $data['stream'] = 'own';
    }

    return $data;
};

$userScope = static function (string $mode): array|false {
    if ($mode === 'none') {
        return false;
    }

    if ($mode === 'read') {
        return [
            'read' => 'all',
            'edit' => 'no',
        ];
    }

    if ($mode === 'manage') {
        // Espo only exposes read + edit(own/no) for User in roles.
        return [
            'read' => 'all',
            'edit' => 'own',
        ];
    }

    throw new RuntimeException("Unknown user scope mode: {$mode}");
};

$teamScope = static function (bool $enabled): array|false {
    if (!$enabled) {
        return false;
    }

    // Espo only exposes read access for Team in roles.
    return [
        'read' => 'all',
    ];
};

$kbCategoryScope = static fn (string $mode): array|false => $record($mode, 'KnowledgeBaseCategory');
$documentFolderScope = static fn (string $mode): array|false => $record($mode, 'DocumentFolder');
$targetListCategoryScope = static fn (string $mode): array|false => $record($mode, 'TargetListCategory');
$emailTemplateCategoryScope = static fn (string $mode): array|false => $record($mode, 'EmailTemplateCategory');

$roles = [
    [
        'name' => 'Admin CRM',
        'assignment_permission' => 'all',
        'user_permission' => 'all',
        'message_permission' => 'all',
        'portal_permission' => 'no',
        'group_email_account_permission' => 'all',
        'export_permission' => 'yes',
        'mass_update_permission' => 'yes',
        'data_privacy_permission' => 'yes',
        'follower_management_permission' => 'all',
        'audit_permission' => 'yes',
        'mention_permission' => 'all',
        'user_calendar_permission' => 'all',
        'data' => [
            'Account' => $record('full', 'Account'),
            'Contact' => $record('full', 'Contact'),
            'Opportunity' => $record('full', 'Opportunity'),
            'Candidature' => $record('full', 'Candidature'),
            'Contrat' => $record('full', 'Contrat'),
            'Case' => $record('full', 'Case'),
            'Currency' => false,
            'Lead' => false,
            'Formation' => $record('full', 'Formation'),
            'Promotion' => $record('full', 'Promotion'),
            'Skill' => $record('full', 'Skill'),
            'Document' => $record('full', 'Document'),
            'DocumentFolder' => $documentFolderScope('full'),
            'EmailAccount' => $record('full', 'EmailAccount'),
            'EmailAccountScope' => $boolean(true),
            'ExternalAccount' => $record('full', 'ExternalAccount'),
            'OpenApi' => $boolean(true),
            'GlobalStream' => $boolean(true),
            'Stream' => $boolean(false),
            'Webhook' => $boolean(true),
            'KnowledgeBaseArticle' => $record('full', 'KnowledgeBaseArticle'),
            'KnowledgeBaseCategory' => $kbCategoryScope('full'),
            'Campaign' => $record('full', 'Campaign'),
            'TargetList' => $record('full', 'TargetList'),
            'TargetListCategory' => $targetListCategoryScope('full'),
            'Email' => $record('full', 'Email'),
            'Task' => $record('full', 'Task'),
            'Call' => $record('full', 'Call'),
            'Meeting' => $record('full', 'Meeting'),
            'Calendar' => $boolean(true),
            'User' => $userScope('manage'),
            'Team' => $teamScope(true),
            'WorkingTimeCalendar' => $boolean(true),
            'EmailTemplate' => $record('full', 'EmailTemplate'),
            'EmailTemplateCategory' => $emailTemplateCategoryScope('full'),
            'Template' => $record('full', 'Template'),
            'Import' => $boolean(true),
        ],
    ],
    [
        'name' => 'Recrutement',
        'assignment_permission' => 'all',
        'user_permission' => 'no',
        'message_permission' => 'no',
        'portal_permission' => 'no',
        'group_email_account_permission' => 'all',
        'export_permission' => 'no',
        'mass_update_permission' => 'no',
        'data_privacy_permission' => 'no',
        'follower_management_permission' => 'no',
        'audit_permission' => 'no',
        'mention_permission' => 'all',
        'user_calendar_permission' => 'all',
        'data' => [
            'Account' => $record('lcm', 'Account'),
            'Contact' => $record('lcm', 'Contact'),
            'Opportunity' => $record('lcm', 'Opportunity'),
            'Candidature' => $record('lcm', 'Candidature'),
            'Contrat' => $record('lcm', 'Contrat'),
            'Case' => $record('lcm', 'Case'),
            'Currency' => false,
            'Lead' => false,
            'Formation' => $record('l', 'Formation'),
            'Promotion' => $record('l', 'Promotion'),
            'Skill' => $record('lcm', 'Skill'),
            'Document' => $record('lcm', 'Document'),
            'DocumentFolder' => $documentFolderScope('lcm'),
            'EmailAccount' => $ownRecord(true, true),
            'EmailAccountScope' => $boolean(true),
            'ExternalAccount' => $ownRecord(true, true),
            'OpenApi' => $boolean(false),
            'GlobalStream' => $boolean(false),
            'Stream' => $boolean(false),
            'Webhook' => $boolean(false),
            'KnowledgeBaseArticle' => $record('l', 'KnowledgeBaseArticle'),
            'KnowledgeBaseCategory' => $kbCategoryScope('l'),
            'Campaign' => $record('lcm', 'Campaign'),
            'TargetList' => $record('lcm', 'TargetList'),
            'TargetListCategory' => $targetListCategoryScope('lcm'),
            'Email' => $record('lcm', 'Email'),
            'Task' => $record('lcm', 'Task'),
            'Call' => $record('lcm', 'Call'),
            'Meeting' => $record('lcm', 'Meeting'),
            'Calendar' => $boolean(true),
            'User' => $userScope('read'),
            'Team' => $teamScope(false),
            'WorkingTimeCalendar' => $boolean(false),
            'EmailTemplate' => $record('l', 'EmailTemplate'),
            'EmailTemplateCategory' => $emailTemplateCategoryScope('l'),
            'Template' => false,
            'Import' => $boolean(false),
        ],
    ],
    [
        'name' => 'Assistance pédagogique',
        'assignment_permission' => 'all',
        'user_permission' => 'no',
        'message_permission' => 'no',
        'portal_permission' => 'no',
        'group_email_account_permission' => 'all',
        'export_permission' => 'no',
        'mass_update_permission' => 'no',
        'data_privacy_permission' => 'no',
        'follower_management_permission' => 'no',
        'audit_permission' => 'no',
        'mention_permission' => 'all',
        'user_calendar_permission' => 'all',
        'data' => [
            'Account' => $record('lcm', 'Account'),
            'Contact' => $record('lcm', 'Contact'),
            'Opportunity' => $record('lm', 'Opportunity'),
            'Candidature' => $record('lcm', 'Candidature'),
            'Contrat' => $record('lcm', 'Contrat'),
            'Case' => $record('lcm', 'Case'),
            'Currency' => false,
            'Lead' => false,
            'Formation' => $record('lcm', 'Formation'),
            'Promotion' => $record('lcm', 'Promotion'),
            'Skill' => $record('lcm', 'Skill'),
            'Document' => $record('lcm', 'Document'),
            'DocumentFolder' => $documentFolderScope('lcm'),
            'EmailAccount' => false,
            'EmailAccountScope' => $boolean(false),
            'ExternalAccount' => $ownRecord(true, true),
            'OpenApi' => $boolean(false),
            'GlobalStream' => $boolean(false),
            'Stream' => $boolean(false),
            'Webhook' => $boolean(false),
            'KnowledgeBaseArticle' => $record('l', 'KnowledgeBaseArticle'),
            'KnowledgeBaseCategory' => $kbCategoryScope('l'),
            'Campaign' => $record('lcm', 'Campaign'),
            'TargetList' => $record('lcm', 'TargetList'),
            'TargetListCategory' => $targetListCategoryScope('lcm'),
            'Email' => $record('lcm', 'Email'),
            'Task' => $record('lcm', 'Task'),
            'Call' => $record('lcm', 'Call'),
            'Meeting' => $record('lcm', 'Meeting'),
            'Calendar' => $boolean(true),
            'User' => $userScope('read'),
            'Team' => $teamScope(false),
            'WorkingTimeCalendar' => $boolean(false),
            'EmailTemplate' => false,
            'EmailTemplateCategory' => false,
            'Template' => false,
            'Import' => $boolean(false),
        ],
    ],
    [
        'name' => 'Marketing',
        'assignment_permission' => 'all',
        'user_permission' => 'no',
        'message_permission' => 'no',
        'portal_permission' => 'no',
        'group_email_account_permission' => 'all',
        'export_permission' => 'no',
        'mass_update_permission' => 'no',
        'data_privacy_permission' => 'no',
        'follower_management_permission' => 'no',
        'audit_permission' => 'no',
        'mention_permission' => 'all',
        'user_calendar_permission' => 'all',
        'data' => [
            'Account' => $record('l', 'Account'),
            'Contact' => $record('l', 'Contact'),
            'Opportunity' => $record('lcm', 'Opportunity'),
            'Candidature' => false,
            'Contrat' => false,
            'Case' => false,
            'Currency' => false,
            'Lead' => false,
            'Formation' => false,
            'Promotion' => false,
            'Skill' => $record('lcm', 'Skill'),
            'Document' => $record('l', 'Document'),
            'DocumentFolder' => $documentFolderScope('l'),
            'EmailAccount' => false,
            'EmailAccountScope' => $boolean(false),
            'ExternalAccount' => $ownRecord(true, true),
            'OpenApi' => $boolean(false),
            'GlobalStream' => $boolean(false),
            'Stream' => $boolean(false),
            'Webhook' => $boolean(false),
            'KnowledgeBaseArticle' => $record('l', 'KnowledgeBaseArticle'),
            'KnowledgeBaseCategory' => $kbCategoryScope('l'),
            'Campaign' => $record('lcm', 'Campaign'),
            'TargetList' => $record('lcm', 'TargetList'),
            'TargetListCategory' => $targetListCategoryScope('lcm'),
            'Email' => $record('lcm', 'Email'),
            'Task' => $record('l', 'Task'),
            'Call' => false,
            'Meeting' => false,
            'Calendar' => $boolean(true),
            'User' => $userScope('read'),
            'Team' => $teamScope(false),
            'WorkingTimeCalendar' => $boolean(false),
            'EmailTemplate' => $record('lcm', 'EmailTemplate'),
            'EmailTemplateCategory' => $emailTemplateCategoryScope('lcm'),
            'Template' => false,
            'Import' => $boolean(false),
        ],
    ],
    [
        'name' => 'Développeur',
        'assignment_permission' => 'no',
        'user_permission' => 'no',
        'message_permission' => 'no',
        'portal_permission' => 'no',
        'group_email_account_permission' => 'no',
        'export_permission' => 'no',
        'mass_update_permission' => 'no',
        'data_privacy_permission' => 'no',
        'follower_management_permission' => 'no',
        'audit_permission' => 'no',
        'mention_permission' => 'no',
        'user_calendar_permission' => 'no',
        'data' => [
            'Account' => $record('l', 'Account'),
            'Contact' => $record('l', 'Contact'),
            'Opportunity' => $record('l', 'Opportunity'),
            'Candidature' => false,
            'Contrat' => false,
            'Case' => false,
            'Currency' => false,
            'Lead' => false,
            'Formation' => false,
            'Promotion' => false,
            'Skill' => false,
            'Document' => $record('l', 'Document'),
            'DocumentFolder' => $documentFolderScope('l'),
            'EmailAccount' => false,
            'EmailAccountScope' => $boolean(false),
            'ExternalAccount' => $ownRecord(true, true),
            'OpenApi' => $boolean(false),
            'GlobalStream' => $boolean(false),
            'Stream' => $boolean(false),
            'Webhook' => $boolean(false),
            'KnowledgeBaseArticle' => $record('l', 'KnowledgeBaseArticle'),
            'KnowledgeBaseCategory' => $kbCategoryScope('l'),
            'Campaign' => false,
            'TargetList' => false,
            'TargetListCategory' => false,
            'Email' => false,
            'Task' => false,
            'Call' => false,
            'Meeting' => false,
            'Calendar' => $boolean(false),
            'User' => $userScope('none'),
            'Team' => $teamScope(false),
            'WorkingTimeCalendar' => $boolean(false),
            'EmailTemplate' => false,
            'EmailTemplateCategory' => false,
            'Template' => false,
            'Import' => $boolean(false),
        ],
    ],
    [
        'name' => 'Assistance technique',
        'assignment_permission' => 'all',
        'user_permission' => 'all',
        'message_permission' => 'all',
        'portal_permission' => 'no',
        'group_email_account_permission' => 'no',
        'export_permission' => 'no',
        'mass_update_permission' => 'no',
        'data_privacy_permission' => 'no',
        'follower_management_permission' => 'no',
        'audit_permission' => 'yes',
        'mention_permission' => 'all',
        'user_calendar_permission' => 'all',
        'data' => [
            'Account' => false,
            'Contact' => false,
            'Opportunity' => false,
            'Candidature' => false,
            'Contrat' => false,
            'Case' => false,
            'Currency' => false,
            'Lead' => false,
            'Formation' => false,
            'Promotion' => false,
            'Skill' => false,
            'Document' => false,
            'DocumentFolder' => false,
            'EmailAccount' => false,
            'EmailAccountScope' => $boolean(false),
            'ExternalAccount' => $ownRecord(true, true),
            'OpenApi' => $boolean(false),
            'GlobalStream' => $boolean(false),
            'Stream' => $boolean(false),
            'Webhook' => $boolean(false),
            'KnowledgeBaseArticle' => $record('lcm', 'KnowledgeBaseArticle'),
            'KnowledgeBaseCategory' => $kbCategoryScope('lcm'),
            'Campaign' => false,
            'TargetList' => false,
            'TargetListCategory' => false,
            'Email' => false,
            'Task' => false,
            'Call' => false,
            'Meeting' => false,
            'Calendar' => false,
            'User' => $userScope('manage'),
            'Team' => $teamScope(true),
            'WorkingTimeCalendar' => $boolean(true),
            'EmailTemplate' => $record('lcm', 'EmailTemplate'),
            'EmailTemplateCategory' => $emailTemplateCategoryScope('lcm'),
            'Template' => $record('lcm', 'Template'),
            'Import' => $boolean(true),
        ],
    ],
    [
        'name' => 'Automatisation',
        'assignment_permission' => 'no',
        'user_permission' => 'no',
        'message_permission' => 'no',
        'portal_permission' => 'no',
        'group_email_account_permission' => 'no',
        'export_permission' => 'no',
        'mass_update_permission' => 'no',
        'data_privacy_permission' => 'no',
        'follower_management_permission' => 'no',
        'audit_permission' => 'no',
        'mention_permission' => 'no',
        'user_calendar_permission' => 'no',
        'data' => [
            'Account' => false,
            'Contact' => false,
            'Opportunity' => false,
            'Candidature' => false,
            'Contrat' => false,
            'Case' => false,
            'Currency' => false,
            'Lead' => false,
            'Formation' => false,
            'Promotion' => false,
            'Skill' => false,
            'Document' => false,
            'DocumentFolder' => false,
            'EmailAccount' => false,
            'EmailAccountScope' => $boolean(false),
            'ExternalAccount' => false,
            'OpenApi' => $boolean(true),
            'GlobalStream' => $boolean(false),
            'Stream' => $boolean(false),
            'Webhook' => $boolean(true),
            'KnowledgeBaseArticle' => false,
            'KnowledgeBaseCategory' => false,
            'Campaign' => false,
            'TargetList' => false,
            'TargetListCategory' => false,
            'Email' => false,
            'Task' => false,
            'Call' => false,
            'Meeting' => false,
            'Calendar' => false,
            'User' => $userScope('none'),
            'Team' => $teamScope(false),
            'WorkingTimeCalendar' => $boolean(false),
            'EmailTemplate' => false,
            'EmailTemplateCategory' => false,
            'Template' => false,
            'Import' => $boolean(false),
        ],
    ],
];

$select = $pdo->prepare('SELECT id FROM role WHERE deleted = 0 AND name = :name LIMIT 1');
$insert = $pdo->prepare(
    'INSERT INTO role (
        id, name, deleted,
        assignment_permission, user_permission, message_permission, portal_permission,
        group_email_account_permission, export_permission, mass_update_permission,
        data_privacy_permission, follower_management_permission, audit_permission,
        mention_permission, user_calendar_permission, data, field_data,
        created_at, modified_at
    ) VALUES (
        :id, :name, 0,
        :assignment_permission, :user_permission, :message_permission, :portal_permission,
        :group_email_account_permission, :export_permission, :mass_update_permission,
        :data_privacy_permission, :follower_management_permission, :audit_permission,
        :mention_permission, :user_calendar_permission, :data, :field_data,
        :created_at, :modified_at
    )'
);
$update = $pdo->prepare(
    'UPDATE role SET
        assignment_permission = :assignment_permission,
        user_permission = :user_permission,
        message_permission = :message_permission,
        portal_permission = :portal_permission,
        group_email_account_permission = :group_email_account_permission,
        export_permission = :export_permission,
        mass_update_permission = :mass_update_permission,
        data_privacy_permission = :data_privacy_permission,
        follower_management_permission = :follower_management_permission,
        audit_permission = :audit_permission,
        mention_permission = :mention_permission,
        user_calendar_permission = :user_calendar_permission,
        data = :data,
        field_data = :field_data,
        modified_at = :modified_at
    WHERE id = :id'
);

$now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

$pdo->beginTransaction();

try {
    foreach ($roles as $role) {
        $select->execute(['name' => $role['name']]);
        $existing = $select->fetch();

        $payload = [
            'name' => $role['name'],
            'assignment_permission' => $role['assignment_permission'],
            'user_permission' => $role['user_permission'],
            'message_permission' => $role['message_permission'],
            'portal_permission' => $role['portal_permission'],
            'group_email_account_permission' => $role['group_email_account_permission'],
            'export_permission' => $role['export_permission'],
            'mass_update_permission' => $role['mass_update_permission'],
            'data_privacy_permission' => $role['data_privacy_permission'],
            'follower_management_permission' => $role['follower_management_permission'],
            'audit_permission' => $role['audit_permission'],
            'mention_permission' => $role['mention_permission'],
            'user_calendar_permission' => $role['user_calendar_permission'],
            'data' => json_encode($role['data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'field_data' => json_encode((object) [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'modified_at' => $now,
        ];

        if ($existing) {
            $payload['id'] = $existing['id'];
            unset($payload['name']);
            $update->execute($payload);
            echo "Updated role: {$role['name']}\n";
            continue;
        }

        $payload['id'] = substr(bin2hex(random_bytes(9)), 0, 17);
        $payload['created_at'] = $now;
        $insert->execute($payload);
        echo "Created role: {$role['name']}\n";
    }

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}

echo "Done.\n";
