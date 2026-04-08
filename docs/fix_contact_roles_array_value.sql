DELETE FROM array_value
WHERE entity_type = 'Contact' AND attribute = 'contactRoles';

INSERT INTO array_value (id, deleted, value, attribute, entity_id, entity_type)
SELECT CONCAT('AR', SUBSTRING(MD5(CONCAT(id, '-contactRoles-0')), 1, 15)),
       0,
       JSON_UNQUOTE(JSON_EXTRACT(contact_roles, '$[0]')),
       'contactRoles',
       id,
       'Contact'
FROM contact
WHERE deleted = 0
  AND contact_roles IS NOT NULL
  AND JSON_UNQUOTE(JSON_EXTRACT(contact_roles, '$[0]')) IS NOT NULL
UNION ALL
SELECT CONCAT('AR', SUBSTRING(MD5(CONCAT(id, '-contactRoles-1')), 1, 15)),
       0,
       JSON_UNQUOTE(JSON_EXTRACT(contact_roles, '$[1]')),
       'contactRoles',
       id,
       'Contact'
FROM contact
WHERE deleted = 0
  AND contact_roles IS NOT NULL
  AND JSON_UNQUOTE(JSON_EXTRACT(contact_roles, '$[1]')) IS NOT NULL;

SELECT value, COUNT(*) AS total
FROM array_value
WHERE entity_type = 'Contact' AND attribute = 'contactRoles'
GROUP BY value
ORDER BY value;
