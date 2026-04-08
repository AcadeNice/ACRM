START TRANSACTION;

DELETE FROM note_user
WHERE note_id IN (
    SELECT id FROM note
    WHERE parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
       OR related_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
       OR super_parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
);

DELETE FROM note_team
WHERE note_id IN (
    SELECT id FROM note
    WHERE parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
       OR related_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
       OR super_parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
);

DELETE FROM note_portal
WHERE note_id IN (
    SELECT id FROM note
    WHERE parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
       OR related_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
       OR super_parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
);

DELETE FROM note
WHERE parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
   OR related_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
   OR super_parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat');

DELETE FROM reminder
WHERE entity_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat');

DELETE FROM notification
WHERE related_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
   OR related_parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat');

DELETE FROM stream_subscription
WHERE entity_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat');

DELETE FROM star_subscription
WHERE entity_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat');

DELETE FROM email_user
WHERE email_id IN (
    SELECT id FROM email
    WHERE parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
       OR created_event_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
);

DELETE FROM email_email_address
WHERE email_id IN (
    SELECT id FROM email
    WHERE parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
       OR created_event_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
);

DELETE FROM email
WHERE parent_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat')
   OR created_event_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat');

DELETE FROM entity_email_address
WHERE entity_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat');

DELETE FROM entity_phone_number
WHERE entity_type IN ('Contact', 'Account', 'Opportunity', 'Meeting', 'Call', 'Task', 'Case', 'Candidature', 'Contrat');

DELETE FROM account_contact;
DELETE FROM account_document;
DELETE FROM account_portal_user;
DELETE FROM account_privileged_user;
DELETE FROM account_target_list;

DELETE FROM call_contact;
DELETE FROM call_lead;
DELETE FROM call_user;

DELETE FROM case_contact;
DELETE FROM case_knowledge_base_article;

DELETE FROM contact_document;
DELETE FROM contact_meeting;
DELETE FROM contact_opportunity;
DELETE FROM contact_skill;
DELETE FROM contact_target_list;
DELETE FROM contact_tutor_relation;

DELETE FROM meeting_user;

DELETE FROM contact_opportunity;

DELETE FROM `call`;
DELETE FROM meeting;
DELETE FROM task;
DELETE FROM `case`;
DELETE FROM candidature;
DELETE FROM contrat;
DELETE FROM opportunity;
DELETE FROM contact;
DELETE FROM account;

COMMIT;
