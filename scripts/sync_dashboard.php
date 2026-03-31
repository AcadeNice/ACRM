<?php

$dsn = 'mysql:unix_socket=/tmp/mysql.sock;dbname=espocrm_acadenice;charset=utf8mb4';
$username = 'espocrm_local';
$password = 'EspoLocal!2026';

$dashboardLayout = [
    [
        'name' => 'Pilotage',
        'layout' => [
            [
                'id' => 'pilotage-tests-in-progress',
                'name' => 'TestsInProgress',
                'x' => 0,
                'y' => 0,
                'width' => 2,
                'height' => 2,
            ],
            [
                'id' => 'pilotage-contracts-to-finalize',
                'name' => 'ContractsToFinalize',
                'x' => 2,
                'y' => 0,
                'width' => 2,
                'height' => 2,
            ],
            [
                'id' => 'pilotage-candidatures-to-propose',
                'name' => 'CandidaturesToPropose',
                'x' => 0,
                'y' => 2,
                'width' => 2,
                'height' => 2,
            ],
            [
                'id' => 'pilotage-incoming-tickets',
                'name' => 'IncomingTickets',
                'x' => 2,
                'y' => 2,
                'width' => 2,
                'height' => 2,
            ],
            [
                'id' => 'pilotage-cvs-to-send',
                'name' => 'CvsToSend',
                'x' => 0,
                'y' => 4,
                'width' => 2,
                'height' => 2,
            ],
            [
                'id' => 'pilotage-open-opportunities',
                'name' => 'OpenOpportunities',
                'x' => 2,
                'y' => 4,
                'width' => 2,
                'height' => 2,
            ],
            [
                'id' => 'pilotage-upcoming-interviews',
                'name' => 'UpcomingInterviews',
                'x' => 0,
                'y' => 6,
                'width' => 2,
                'height' => 2,
            ],
            [
                'id' => 'pilotage-active-campaigns',
                'name' => 'ActiveCampaigns',
                'x' => 2,
                'y' => 6,
                'width' => 2,
                'height' => 2,
            ],
            [
                'id' => 'pilotage-useful-target-lists',
                'name' => 'UsefulTargetLists',
                'x' => 0,
                'y' => 8,
                'width' => 2,
                'height' => 2,
            ],
        ],
    ],
];

$dashletsOptions = [
    'pilotage-tests-in-progress' => [
        'title' => 'Tests en cours',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
    'pilotage-contracts-to-finalize' => [
        'title' => 'Contrats à finaliser',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
    'pilotage-candidatures-to-propose' => [
        'title' => 'Candidatures à proposer',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
    'pilotage-incoming-tickets' => [
        'title' => 'Tickets entrants',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
    'pilotage-cvs-to-send' => [
        'title' => 'CV à envoyer',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
    'pilotage-open-opportunities' => [
        'title' => 'Offres ouvertes',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
    'pilotage-upcoming-interviews' => [
        'title' => 'Entretiens à venir',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
    'pilotage-active-campaigns' => [
        'title' => 'Campagnes actives',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
    'pilotage-useful-target-lists' => [
        'title' => 'Listes de diffusion',
        'displayRecords' => 6,
        'autorefreshInterval' => 0.5,
    ],
];

$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$userStmt = $pdo->prepare("SELECT id FROM user WHERE user_name = 'admin' AND deleted = 0 LIMIT 1");
$userStmt->execute();
$userId = $userStmt->fetchColumn();

if (!$userId) {
    throw new RuntimeException('Admin user not found.');
}

$preferencesStmt = $pdo->prepare('SELECT data FROM preferences WHERE id = :id LIMIT 1');
$preferencesStmt->execute(['id' => $userId]);
$preferencesJson = $preferencesStmt->fetchColumn();

if (!$preferencesJson) {
    throw new RuntimeException('Admin preferences not found.');
}

$preferences = json_decode($preferencesJson, true, 512, JSON_THROW_ON_ERROR);
$preferences['dashboardLayout'] = $dashboardLayout;
$preferences['dashletsOptions'] = $dashletsOptions;

$updateStmt = $pdo->prepare('UPDATE preferences SET data = :data WHERE id = :id');
$updateStmt->execute([
    'id' => $userId,
    'data' => json_encode($preferences, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
]);

echo "Dashboard synced.\n";
