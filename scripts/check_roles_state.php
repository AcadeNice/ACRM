<?php

declare(strict_types=1);

$pdo = new PDO(
    'mysql:unix_socket=/tmp/mysql.sock;dbname=espocrm_acadenice;charset=utf8mb4',
    'espocrm_local',
    'EspoLocal!2026',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

$roles = [
    'Admin CRM',
    'Recrutement',
    'Assistance pédagogique',
    'Marketing',
    'Développeur',
    'Assistance technique',
    'Automatisation',
];

$stmt = $pdo->prepare('SELECT name, data FROM role WHERE deleted = 0 AND name = ? LIMIT 1');

$scopeList = [
    'EmailAccount',
    'ExternalAccount',
    'OpenApi',
    'Webhook',
    'Case',
    'Lead',
];

$result = [];

foreach ($roles as $roleName) {
    $stmt->execute([$roleName]);
    $row = $stmt->fetch();

    if (!$row) {
        $result[$roleName] = null;
        continue;
    }

    $data = json_decode((string) $row['data'], true) ?? [];
    $result[$roleName] = [];

    foreach ($scopeList as $scope) {
        $result[$roleName][$scope] = $data[$scope] ?? '__NOT_SET__';
    }
}

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;
