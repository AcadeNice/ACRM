<?php

declare(strict_types=1);

require __DIR__ . '/../EspoCRM-9.3.4/vendor/autoload.php';

use Michelf\MarkdownExtra;

const ADMIN_ID = '69c481717a2fce139';
const CATEGORY_ROOT = 'Utilisation du CRM';
const SOURCE_FILE = __DIR__ . '/../docs/GUIDE_UTILISATION_ESPCRM_ACADENICE.md';

function normalizeMarkdown(string $markdown): string
{
    $markdown = preg_replace('/^\xEF\xBB\xBF/', '', $markdown) ?? $markdown;
    $markdown = str_replace(["\r\n", "\r"], "\n", $markdown);

    return trim($markdown) . "\n";
}

function extractDocumentTitle(string $markdown): string
{
    if (!preg_match('/^#\s+(.+)$/m', $markdown, $match)) {
        throw new RuntimeException('Titre principal introuvable dans le Markdown.');
    }

    return trim($match[1]);
}

function splitTopLevelSections(string $markdown): array
{
    $markdown = preg_replace('/^#\s+.+\n+/', '', $markdown, 1) ?? $markdown;

    preg_match_all('/^#\s+(.+)$/m', $markdown, $matches, PREG_OFFSET_CAPTURE);

    if (empty($matches[0])) {
        return ['__intro__' => trim($markdown)];
    }

    $sections = [];
    $firstOffset = $matches[0][0][1];
    $intro = trim(substr($markdown, 0, $firstOffset));

    if ($intro !== '') {
        $sections['__intro__'] = $intro;
    }

    $count = count($matches[0]);

    for ($i = 0; $i < $count; $i++) {
        $heading = trim($matches[1][$i][0]);
        $fullLine = $matches[0][$i][0];
        $start = $matches[0][$i][1] + strlen($fullLine);
        $end = $i + 1 < $count ? $matches[0][$i + 1][1] : strlen($markdown);
        $body = trim(substr($markdown, $start, $end - $start));

        $sections[$heading] = $body;
    }

    return $sections;
}

function cleanHeading(string $heading): string
{
    return trim((string) preg_replace('/^\d+\.\s*/', '', $heading));
}

function buildCombinedArticle(array $headings, array $sections): string
{
    $parts = [];

    foreach ($headings as $heading) {
        if (!isset($sections[$heading])) {
            continue;
        }

        $parts[] = '## ' . cleanHeading($heading) . "\n\n" . trim($sections[$heading]);
    }

    return implode("\n\n---\n\n", $parts);
}

function toHtml(string $markdown): string
{
    return trim(MarkdownExtra::defaultTransform($markdown));
}

function toPlainText(string $html): string
{
    $plain = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $plain = preg_replace('/\s+/u', ' ', $plain) ?? $plain;

    return trim($plain);
}

function makeDescription(string $plain): string
{
    $description = mb_substr($plain, 0, 500);

    if (mb_strlen($plain) > 500) {
        $description .= '…';
    }

    return $description;
}

function makeId(): string
{
    return substr(bin2hex(random_bytes(9)), 0, 17);
}

function upsertCategory(PDO $pdo, string $name, ?string $parentId, int $order, string $description): string
{
    $select = $pdo->prepare('SELECT id FROM knowledge_base_category WHERE name = ? AND deleted = 0 LIMIT 1');
    $select->execute([$name]);
    $id = $select->fetchColumn();
    $now = date('Y-m-d H:i:s');

    if ($id) {
        $update = $pdo->prepare(
            'UPDATE knowledge_base_category
             SET description = ?, modified_at = ?, modified_by_id = ?, parent_id = ?, `order` = ?
             WHERE id = ?'
        );
        $update->execute([$description, $now, ADMIN_ID, $parentId, $order, $id]);
    } else {
        $id = makeId();
        $insert = $pdo->prepare(
            'INSERT INTO knowledge_base_category
            (id, name, deleted, description, created_at, modified_at, `order`, created_by_id, modified_by_id, parent_id)
            VALUES (?, ?, 0, ?, ?, ?, ?, ?, ?, ?)'
        );
        $insert->execute([$id, $name, $description, $now, $now, $order, ADMIN_ID, ADMIN_ID, $parentId]);
    }

    return $id;
}

function rebuildCategoryPaths(PDO $pdo, array $categories): void
{
    $ids = array_values(array_map(static fn(array $row): string => $row['id'], $categories));

    if (!$ids) {
        return;
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $pdo->prepare("DELETE FROM knowledge_base_category_path WHERE ascendor_id IN ($placeholders) OR descendor_id IN ($placeholders)")
        ->execute([...$ids, ...$ids]);

    $insert = $pdo->prepare(
        'INSERT INTO knowledge_base_category_path (ascendor_id, descendor_id) VALUES (?, ?)'
    );

    foreach ($categories as $category) {
        $insert->execute([$category['id'], $category['id']]);

        $parentId = $category['parentId'];

        while ($parentId) {
            $insert->execute([$parentId, $category['id']]);
            $parentId = $categories[$parentId]['parentId'] ?? null;
        }
    }
}

function upsertArticle(PDO $pdo, array $article, string $categoryId): string
{
    $lookupTitles = array_values(array_unique(array_merge(
        [$article['title']],
        $article['legacyTitles'] ?? []
    )));

    $placeholders = implode(',', array_fill(0, count($lookupTitles), '?'));
    $select = $pdo->prepare(
        "SELECT id FROM knowledge_base_article WHERE deleted = 0 AND name IN ($placeholders) ORDER BY FIELD(name, $placeholders) LIMIT 1"
    );
    $select->execute(array_merge($lookupTitles, $lookupTitles));
    $id = $select->fetchColumn();

    $html = toHtml($article['markdown']);
    $plain = toPlainText($html);
    $description = makeDescription($plain);
    $now = date('Y-m-d H:i:s');
    $publishDate = date('Y-m-d');

    if ($id) {
        $update = $pdo->prepare(
            'UPDATE knowledge_base_article
             SET status = ?, language = ?, type = ?, publish_date = ?, description = ?, modified_at = ?,
                 body = ?, body_plain = ?, modified_by_id = ?, assigned_user_id = ?, `order` = ?
             WHERE id = ?'
        );
        $update->execute([
            'Published',
            'fr_FR',
            'Article',
            $publishDate,
            $description,
            $now,
            $html,
            $plain,
            ADMIN_ID,
            ADMIN_ID,
            $article['order'],
            $id,
        ]);
    } else {
        $id = makeId();
        $insert = $pdo->prepare(
            'INSERT INTO knowledge_base_article
            (id, name, deleted, status, language, type, publish_date, description, created_at, modified_at, body, body_plain, created_by_id, modified_by_id, assigned_user_id, version_number, `order`)
            VALUES (?, ?, 0, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)'
        );
        $insert->execute([
            $id,
            $article['title'],
            'Published',
            'fr_FR',
            'Article',
            $publishDate,
            $description,
            $now,
            $now,
            $html,
            $plain,
            ADMIN_ID,
            ADMIN_ID,
            ADMIN_ID,
            $article['order'],
        ]);
    }

    $pdo->prepare(
        'UPDATE knowledge_base_article_knowledge_base_category
         SET deleted = 1
         WHERE knowledge_base_article_id = ?'
    )->execute([$id]);

    $linkSelect = $pdo->prepare(
        'SELECT id FROM knowledge_base_article_knowledge_base_category
         WHERE knowledge_base_article_id = ? AND knowledge_base_category_id = ? LIMIT 1'
    );
    $linkSelect->execute([$id, $categoryId]);
    $linkId = $linkSelect->fetchColumn();

    if ($linkId) {
        $pdo->prepare(
            'UPDATE knowledge_base_article_knowledge_base_category SET deleted = 0 WHERE id = ?'
        )->execute([$linkId]);
    } else {
        $pdo->prepare(
            'INSERT INTO knowledge_base_article_knowledge_base_category
            (knowledge_base_article_id, knowledge_base_category_id, deleted)
            VALUES (?, ?, 0)'
        )->execute([$id, $categoryId]);
    }

    return $id;
}

function archiveArticlesByTitle(PDO $pdo, array $titles): void
{
    if (!$titles) {
        return;
    }

    $titles = array_values(array_unique($titles));
    $placeholders = implode(',', array_fill(0, count($titles), '?'));
    $sql = "UPDATE knowledge_base_article
        SET status = 'Archived', modified_at = ?, modified_by_id = ?
        WHERE deleted = 0
          AND name IN ($placeholders)
          AND status <> 'Archived'";

    $params = array_merge([date('Y-m-d H:i:s'), ADMIN_ID], $titles);
    $pdo->prepare($sql)->execute($params);
}

function archiveUnusedGuide(PDO $pdo, array $titlesToKeep): void
{
    $placeholders = implode(',', array_fill(0, count($titlesToKeep), '?'));

    $sql = "UPDATE knowledge_base_article
        SET status = 'Archived', modified_at = ?, modified_by_id = ?
        WHERE deleted = 0
          AND name NOT IN ($placeholders)
          AND (name = 'Guide d''utilisation EspoCRM AcadéNice' OR name LIKE 'Guide d''utilisation EspoCRM AcadéNice%')";

    $pdo->prepare($sql)->execute(array_merge([date('Y-m-d H:i:s'), ADMIN_ID], $titlesToKeep));
}

try {
    if (!is_file(SOURCE_FILE)) {
        throw new RuntimeException('Fichier source introuvable: ' . SOURCE_FILE);
    }

    $markdown = normalizeMarkdown((string) file_get_contents(SOURCE_FILE));
    $mainTitle = extractDocumentTitle($markdown);
    $sections = splitTopLevelSections($markdown);

    $pdo = new PDO(
        'mysql:unix_socket=/tmp/mysql.sock;dbname=espocrm_acadenice;charset=utf8mb4',
        'espocrm_local',
        'EspoLocal!2026',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $pdo->beginTransaction();

    $rootId = upsertCategory(
        $pdo,
        CATEGORY_ROOT,
        null,
        10,
        'Documentation interne d’utilisation du CRM AcadéNice.'
    );

    rebuildCategoryPaths($pdo, [
        $rootId => ['id' => $rootId, 'parentId' => null],
    ]);

    $articles = [
        [
            'title' => "0.1 - Guide d'utilisation - EspoCRM AcadéNice",
            'categoryId' => $rootId,
            'order' => 10,
            'markdown' => $sections['__intro__'] ?? '',
            'legacyTitles' => [
                "Guide d'utilisation - EspoCRM AcadéNice",
                "Guide d'utilisation EspoCRM AcadéNice",
            ],
        ],
        [
            'title' => '1.2 - Suivi opérationnel - Organisations',
            'categoryId' => $rootId,
            'order' => 30,
            'markdown' => $sections['1. Organisations'] ?? '',
            'legacyTitles' => ['Suivi opérationnel - Organisations'],
        ],
        [
            'title' => '1.1 - Suivi opérationnel - Contacts',
            'categoryId' => $rootId,
            'order' => 20,
            'markdown' => $sections['2. Contacts'] ?? '',
            'legacyTitles' => ['Suivi opérationnel - Contacts'],
        ],
        [
            'title' => '1.3 - Suivi opérationnel - Offres',
            'categoryId' => $rootId,
            'order' => 40,
            'markdown' => $sections['3. Offres'] ?? '',
            'legacyTitles' => ['Suivi opérationnel - Offres'],
        ],
        [
            'title' => '1.4 - Suivi opérationnel - Candidatures',
            'categoryId' => $rootId,
            'order' => 50,
            'markdown' => $sections['4. Candidatures'] ?? '',
            'legacyTitles' => ['Suivi opérationnel - Candidatures'],
        ],
        [
            'title' => '1.5 - Suivi opérationnel - Contrats',
            'categoryId' => $rootId,
            'order' => 60,
            'markdown' => $sections['5. Contrats'] ?? '',
            'legacyTitles' => ['Suivi opérationnel - Contrats'],
        ],
        [
            'title' => '2.1 - Référentiels - Formations',
            'categoryId' => $rootId,
            'order' => 70,
            'markdown' => $sections['6. Formations'] ?? '',
            'legacyTitles' => ['Référentiels - Formations'],
        ],
        [
            'title' => '2.2 - Référentiels - Promotions',
            'categoryId' => $rootId,
            'order' => 80,
            'markdown' => $sections['7. Promotions'] ?? '',
            'legacyTitles' => ['Référentiels - Promotions'],
        ],
        [
            'title' => '2.3 - Référentiels - Compétences',
            'categoryId' => $rootId,
            'order' => 90,
            'markdown' => $sections['8. Compétences'] ?? '',
            'legacyTitles' => ['Référentiels - Compétences'],
        ],
        [
            'title' => '4.1 - Marketing - Les bases',
            'categoryId' => $rootId,
            'order' => 160,
            'markdown' => $sections['9. Marketing - Les bases'] ?? '',
            'legacyTitles' => ['Marketing - Les bases'],
        ],
        [
            'title' => '4.2 - Marketing - Campagnes',
            'categoryId' => $rootId,
            'order' => 170,
            'markdown' => $sections['10. Marketing - Campagnes'] ?? '',
            'legacyTitles' => ['Marketing - Campagnes'],
        ],
        [
            'title' => '4.3 - Marketing - Listes de diffusion',
            'categoryId' => $rootId,
            'order' => 180,
            'markdown' => $sections['11. Marketing - Listes de diffusion'] ?? '',
            'legacyTitles' => ['Marketing - Listes de diffusion'],
        ],
        [
            'title' => '0.3 - Documents',
            'categoryId' => $rootId,
            'order' => 30,
            'markdown' => $sections['12. Documents'] ?? '',
            'legacyTitles' => ['Documents'],
        ],
        [
            'title' => '3.1 - Activités - Emails',
            'categoryId' => $rootId,
            'order' => 100,
            'markdown' => $sections['13. Activités - Emails'] ?? '',
            'legacyTitles' => ['Activités - Emails', 'Emails'],
        ],
        [
            'title' => '3.4 - Activités - Tâches',
            'categoryId' => $rootId,
            'order' => 130,
            'markdown' => $sections['14. Activités - Tâches'] ?? '',
            'legacyTitles' => ['Activités - Tâches', 'Tâches'],
        ],
        [
            'title' => '3.3 - Activités - Appels',
            'categoryId' => $rootId,
            'order' => 120,
            'markdown' => $sections['15. Activités - Appels'] ?? '',
            'legacyTitles' => ['Activités - Appels', 'Appels'],
        ],
        [
            'title' => '3.2 - Activités - Rendez-vous',
            'categoryId' => $rootId,
            'order' => 110,
            'markdown' => $sections['16. Activités - Rendez-vous'] ?? '',
            'legacyTitles' => ['Activités - Rendez-vous', 'Réunions'],
        ],
        [
            'title' => '3.5 - Activités - Calendrier',
            'categoryId' => $rootId,
            'order' => 140,
            'markdown' => $sections['17. Activités - Calendrier'] ?? '',
            'legacyTitles' => ['Activités - Calendrier', 'Calendrier'],
        ],
        [
            'title' => '5.1 - Administration - Utilisateurs',
            'categoryId' => $rootId,
            'order' => 190,
            'markdown' => $sections['18. Administration - Utilisateurs'] ?? '',
            'legacyTitles' => ['Utilisateurs'],
        ],
        [
            'title' => '5.2 - Administration - Équipes',
            'categoryId' => $rootId,
            'order' => 200,
            'markdown' => $sections['19. Administration - Équipes'] ?? '',
            'legacyTitles' => ['Équipes'],
        ],
        [
            'title' => '5.3 - Administration - Calendriers des jours travaillés',
            'categoryId' => $rootId,
            'order' => 210,
            'markdown' => $sections['20. Administration - Calendriers des jours travaillés'] ?? '',
            'legacyTitles' => ['Calendriers des jours travaillés'],
        ],
        [
            'title' => '5.4 - Administration - Modèles d\'email',
            'categoryId' => $rootId,
            'order' => 220,
            'markdown' => $sections['21. Administration - Modèles d\'email'] ?? '',
            'legacyTitles' => ['Modèles d\'email'],
        ],
        [
            'title' => '5.5 - Administration - PDF Templates',
            'categoryId' => $rootId,
            'order' => 230,
            'markdown' => $sections['22. Administration - PDF Templates'] ?? '',
            'legacyTitles' => ['PDF Templates'],
        ],
        [
            'title' => '5.6 - Administration - Importation',
            'categoryId' => $rootId,
            'order' => 240,
            'markdown' => $sections['23. Administration - Importation'] ?? '',
            'legacyTitles' => ['Importation'],
        ],
        [
            'title' => "0.2 - Guide d'utilisation - Travailler au quotidien",
            'categoryId' => $rootId,
            'order' => 250,
            'markdown' => buildCombinedArticle([
                '24. Comment travailler proprement au quotidien ?',
                '25. Ce qu\'il faut éviter',
                '26. Questions fréquentes',
                '27. Résumé ultra-court',
                '28. Conclusion',
            ], $sections),
            'legacyTitles' => [
                "Guide d'utilisation - Travailler au quotidien",
                'Travailler au quotidien',
            ],
        ],
    ];

    $created = [];

    foreach ($articles as $article) {
        if (trim($article['markdown']) === '') {
            continue;
        }

        $articleId = upsertArticle($pdo, $article, $article['categoryId']);
        $created[] = ['id' => $articleId, 'title' => $article['title']];
    }

    $titlesToKeep = array_map(static fn(array $row): string => $row['title'], $articles);
    archiveUnusedGuide($pdo, $titlesToKeep);
    archiveArticlesByTitle($pdo, [
        "Guide d'utilisation - EspoCRM AcadéNice",
        "Guide d'utilisation EspoCRM AcadéNice",
        "Guide d'utilisation - Travailler au quotidien",
        'Travailler au quotidien',
        'Documents',
        'Suivi opérationnel - Contacts',
        'Suivi opérationnel - Organisations',
        'Suivi opérationnel - Offres',
        'Suivi opérationnel - Candidatures',
        'Suivi opérationnel - Contrats',
        'Référentiels - Formations',
        'Référentiels - Promotions',
        'Référentiels - Compétences',
        'Activités - Emails',
        'Activités - Rendez-vous',
        'Activités - Appels',
        'Activités - Tâches',
        'Activités - Calendrier',
        'Emails',
        'Réunions',
        'Appels',
        'Tâches',
        'Calendrier',
        'Marketing - Les bases',
        'Marketing - Campagnes',
        'Marketing - Listes de diffusion',
        'Utilisateurs',
        'Équipes',
        'Calendriers des jours travaillés',
        'Modèles d\'email',
        'PDF Templates',
        'Importation',
    ]);

    $pdo->commit();

    echo json_encode(
        [
            'categories' => [
                CATEGORY_ROOT,
            ],
            'articles' => $created,
        ],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    ) . PHP_EOL;
} catch (PDOException|RuntimeException $e) {
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
}
