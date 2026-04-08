START TRANSACTION;

UPDATE email_template
SET
    name = 'Réponse automatique ticket',
    subject = 'Votre ticket a été créé',
    body = '<p>{Person.name},</p><p>Le ticket « {Case.name} » a été créé avec le numéro {Case.number} et assigné à {User.name}.</p>',
    modified_at = NOW()
WHERE id = '69c4818b4bc74b3c3'
  AND deleted = 0;

COMMIT;
