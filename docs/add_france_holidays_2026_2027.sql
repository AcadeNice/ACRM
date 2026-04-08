START TRANSACTION;

DELETE l
FROM working_time_calendar_working_time_range l
JOIN working_time_range r ON r.id = l.working_time_range_id
WHERE r.name IN (
    'Jour de l''An 2026',
    'Lundi de Pâques 2026',
    'Fête du Travail 2026',
    'Victoire 1945 2026',
    'Ascension 2026',
    'Lundi de Pentecôte 2026',
    'Fête nationale 2026',
    'Assomption 2026',
    'Toussaint 2026',
    'Armistice 1918 2026',
    'Noël 2026',
    'Jour de l''An 2027',
    'Lundi de Pâques 2027',
    'Fête du Travail 2027',
    'Victoire 1945 2027',
    'Ascension 2027',
    'Lundi de Pentecôte 2027',
    'Fête nationale 2027',
    'Assomption 2027',
    'Toussaint 2027',
    'Armistice 1918 2027',
    'Noël 2027'
);

DELETE FROM working_time_range
WHERE name IN (
    'Jour de l''An 2026',
    'Lundi de Pâques 2026',
    'Fête du Travail 2026',
    'Victoire 1945 2026',
    'Ascension 2026',
    'Lundi de Pentecôte 2026',
    'Fête nationale 2026',
    'Assomption 2026',
    'Toussaint 2026',
    'Armistice 1918 2026',
    'Noël 2026',
    'Jour de l''An 2027',
    'Lundi de Pâques 2027',
    'Fête du Travail 2027',
    'Victoire 1945 2027',
    'Ascension 2027',
    'Lundi de Pentecôte 2027',
    'Fête nationale 2027',
    'Assomption 2027',
    'Toussaint 2027',
    'Armistice 1918 2027',
    'Noël 2027'
);

INSERT INTO working_time_range (id, name, deleted, time_ranges, date_start, date_end, type, description, created_at, modified_at) VALUES
('Fr26JourAn0000001', 'Jour de l''An 2026', 0, NULL, '2026-01-01', '2026-01-01', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Paques0000002', 'Lundi de Pâques 2026', 0, NULL, '2026-04-06', '2026-04-06', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Travail000003', 'Fête du Travail 2026', 0, NULL, '2026-05-01', '2026-05-01', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Victoire00004', 'Victoire 1945 2026', 0, NULL, '2026-05-08', '2026-05-08', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Ascension0005', 'Ascension 2026', 0, NULL, '2026-05-14', '2026-05-14', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Pentecote0006', 'Lundi de Pentecôte 2026', 0, NULL, '2026-05-25', '2026-05-25', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26National00007', 'Fête nationale 2026', 0, NULL, '2026-07-14', '2026-07-14', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Assompt000008', 'Assomption 2026', 0, NULL, '2026-08-15', '2026-08-15', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Toussaint0009', 'Toussaint 2026', 0, NULL, '2026-11-01', '2026-11-01', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Armistice0010', 'Armistice 1918 2026', 0, NULL, '2026-11-11', '2026-11-11', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr26Noel00000011', 'Noël 2026', 0, NULL, '2026-12-25', '2026-12-25', 'Non-working', 'Jour férié France 2026', NOW(), NOW()),
('Fr27JourAn0000012', 'Jour de l''An 2027', 0, NULL, '2027-01-01', '2027-01-01', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Paques0000013', 'Lundi de Pâques 2027', 0, NULL, '2027-03-29', '2027-03-29', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Travail000014', 'Fête du Travail 2027', 0, NULL, '2027-05-01', '2027-05-01', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Victoire00015', 'Victoire 1945 2027', 0, NULL, '2027-05-08', '2027-05-08', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Ascension0016', 'Ascension 2027', 0, NULL, '2027-05-06', '2027-05-06', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Pentecote0017', 'Lundi de Pentecôte 2027', 0, NULL, '2027-05-17', '2027-05-17', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27National00018', 'Fête nationale 2027', 0, NULL, '2027-07-14', '2027-07-14', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Assompt000019', 'Assomption 2027', 0, NULL, '2027-08-15', '2027-08-15', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Toussaint0020', 'Toussaint 2027', 0, NULL, '2027-11-01', '2027-11-01', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Armistice0021', 'Armistice 1918 2027', 0, NULL, '2027-11-11', '2027-11-11', 'Non-working', 'Jour férié France 2027', NOW(), NOW()),
('Fr27Noel00000022', 'Noël 2027', 0, NULL, '2027-12-25', '2027-12-25', 'Non-working', 'Jour férié France 2027', NOW(), NOW());

INSERT INTO working_time_calendar_working_time_range (working_time_calendar_id, working_time_range_id, deleted)
SELECT c.id, r.id, 0
FROM working_time_calendar c
JOIN working_time_range r
WHERE c.name IN (
    '5 jours',
    '4 jours sans lundi',
    '4 jours sans mardi',
    '4 jours sans mercredi',
    '4 jours sans jeudi',
    '4 jours sans vendredi'
)
AND r.name IN (
    'Jour de l''An 2026',
    'Lundi de Pâques 2026',
    'Fête du Travail 2026',
    'Victoire 1945 2026',
    'Ascension 2026',
    'Lundi de Pentecôte 2026',
    'Fête nationale 2026',
    'Assomption 2026',
    'Toussaint 2026',
    'Armistice 1918 2026',
    'Noël 2026',
    'Jour de l''An 2027',
    'Lundi de Pâques 2027',
    'Fête du Travail 2027',
    'Victoire 1945 2027',
    'Ascension 2027',
    'Lundi de Pentecôte 2027',
    'Fête nationale 2027',
    'Assomption 2027',
    'Toussaint 2027',
    'Armistice 1918 2027',
    'Noël 2027'
);

COMMIT;
