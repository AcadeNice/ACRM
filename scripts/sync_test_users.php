<?php

declare(strict_types=1);

$dsn = 'mysql:unix_socket=/tmp/mysql.sock;dbname=espocrm_acadenice;charset=utf8mb4';
$user = 'espocrm_local';
$pass = 'EspoLocal!2026';

$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$users = [
    [
        'user_name' => 'admin_crm',
        'password' => 'admin_crm',
        'type' => 'admin',
        'last_name' => 'Admin CRM',
        'role' => 'Admin CRM',
    ],
    [
        'user_name' => 'recrutement',
        'password' => 'recrutement',
        'type' => 'regular',
        'last_name' => 'Recrutement',
        'role' => 'Recrutement',
    ],
    [
        'user_name' => 'assistance_pedagogique',
        'password' => 'assistance_pedagogique',
        'type' => 'regular',
        'last_name' => 'Assistance pédagogique',
        'role' => 'Assistance pédagogique',
    ],
    [
        'user_name' => 'marketing',
        'password' => 'marketing',
        'type' => 'regular',
        'last_name' => 'Marketing',
        'role' => 'Marketing',
    ],
    [
        'user_name' => 'developpeur',
        'password' => 'developpeur',
        'type' => 'regular',
        'last_name' => 'Développeur',
        'role' => 'Développeur',
    ],
    [
        'user_name' => 'assistance_technique',
        'password' => 'assistance_technique',
        'type' => 'regular',
        'last_name' => 'Assistance technique',
        'role' => 'Assistance technique',
    ],
];

$now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

$selectUser = $pdo->prepare('SELECT id FROM user WHERE deleted = 0 AND user_name = :user_name LIMIT 1');
$insertUser = $pdo->prepare(
    'INSERT INTO user (
        id, deleted, user_name, type, password, auth_method,
        first_name, last_name, is_active, created_at, modified_at
    ) VALUES (
        :id, 0, :user_name, :type, :password, NULL,
        NULL, :last_name, 1, :created_at, :modified_at
    )'
);
$updateUser = $pdo->prepare(
    'UPDATE user SET
        type = :type,
        password = :password,
        last_name = :last_name,
        is_active = 1,
        modified_at = :modified_at
    WHERE id = :id'
);

$insertPreferences = $pdo->prepare(
    'INSERT IGNORE INTO preferences (id, data) VALUES (:id, :data)'
);

$selectRole = $pdo->prepare('SELECT id FROM role WHERE deleted = 0 AND name = :name LIMIT 1');
$insertRoleUser = $pdo->prepare(
    'INSERT IGNORE INTO role_user (role_id, user_id, deleted) VALUES (:role_id, :user_id, 0)'
);
$clearOtherRoles = $pdo->prepare(
    'UPDATE role_user SET deleted = 1 WHERE user_id = :user_id AND role_id <> :role_id'
);
$restoreRoleLink = $pdo->prepare(
    'UPDATE role_user SET deleted = 0 WHERE user_id = :user_id AND role_id = :role_id'
);

$pdo->beginTransaction();

try {
    foreach ($users as $userItem) {
        $selectRole->execute(['name' => $userItem['role']]);
        $role = $selectRole->fetch();

        if (!$role) {
            throw new RuntimeException("Role not found: {$userItem['role']}");
        }

        $passwordHash = password_hash($userItem['password'], PASSWORD_BCRYPT);

        $selectUser->execute(['user_name' => $userItem['user_name']]);
        $existingUser = $selectUser->fetch();

        if ($existingUser) {
            $userId = $existingUser['id'];

            $updateUser->execute([
                'id' => $userId,
                'type' => $userItem['type'],
                'password' => $passwordHash,
                'last_name' => $userItem['last_name'],
                'modified_at' => $now,
            ]);

            echo "Updated user: {$userItem['user_name']}\n";
        } else {
            $userId = substr(bin2hex(random_bytes(9)), 0, 17);

            $insertUser->execute([
                'id' => $userId,
                'user_name' => $userItem['user_name'],
                'type' => $userItem['type'],
                'password' => $passwordHash,
                'last_name' => $userItem['last_name'],
                'created_at' => $now,
                'modified_at' => $now,
            ]);

            echo "Created user: {$userItem['user_name']}\n";
        }

        $insertPreferences->execute([
            'id' => $userId,
            'data' => json_encode((object) [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        $insertRoleUser->execute([
            'role_id' => $role['id'],
            'user_id' => $userId,
        ]);

        $restoreRoleLink->execute([
            'role_id' => $role['id'],
            'user_id' => $userId,
        ]);

        $clearOtherRoles->execute([
            'role_id' => $role['id'],
            'user_id' => $userId,
        ]);
    }

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}

echo "Done.\n";
