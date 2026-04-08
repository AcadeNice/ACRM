START TRANSACTION;

DELETE FROM auth_log_record
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM auth_token
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM notification
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
)
   OR created_by_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM preferences
WHERE id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM user_data
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM user_reaction
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM entity_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM role_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM team_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM portal_role_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM target_list_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM stream_subscription
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM star_subscription
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM email_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM note_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM meeting_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM call_user
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM reminder
WHERE user_id IN (
    SELECT id FROM user WHERE user_name NOT IN ('admin', 'system')
);

DELETE FROM user
WHERE user_name NOT IN ('admin', 'system');

COMMIT;
