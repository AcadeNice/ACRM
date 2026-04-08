# RESINSTALL

## Objectif

Ce document explique comment utiliser ce dépôt GitHub pour :

- reconstruire une instance **ACRM** sur un nouveau serveur ;
- rejouer les personnalisations métier ;
- réappliquer les rôles, dashboards, traductions, templates et scripts utiles ;
- s’appuyer si besoin sur les backups intégrés.

`ACRM` est basé sur **EspoCRM 9.3.4**.

---

## Ce que contient ce dépôt

Le dépôt contient les briques nécessaires pour reconstituer l’application :

- les personnalisations Espo dans [EspoCRM-9.3.4/custom](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/custom) ;
- les surcharges front et thème dans [EspoCRM-9.3.4/client/custom](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/client/custom) ;
- la surcharge de vue principale dans [EspoCRM-9.3.4/html/main.html](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/html/main.html) ;
- les scripts PHP de synchronisation dans [scripts](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts) ;
- les scripts SQL de configuration et de nettoyage dans [docs](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs) ;
- les backups historiques dans [backups](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups).

Ce dépôt ne versionne pas les vraies données métier d’exploitation.

---

## Deux façons de repartir

### 1. Réinstallation recommandée

À utiliser si tu veux une instance propre, maintenable, et reconstruite à partir du code versionné.

Cette méthode repose sur :

- EspoCRM 9.3.4 vierge ;
- les fichiers du dépôt ;
- les scripts PHP et SQL ;
- un `rebuild`.

### 2. Restauration depuis un backup

À utiliser si tu veux retrouver rapidement un état historique exporté.

Les backups disponibles sont :

- [backups/20260327-170757](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups/20260327-170757)
- [backups/20260327-232035](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups/20260327-232035)

Chaque dossier contient :

- `README.md`
- `config.php`
- `custom.tar.gz`
- `espocrm_acadenice.sql`

---

## Réinstallation recommandée depuis GitHub

### 1. Installer EspoCRM 9.3.4

Préparer une instance vierge de **EspoCRM 9.3.4** sur le nouveau serveur.

### 2. Récupérer le dépôt

Cloner le dépôt GitHub :

```bash
git clone <URL_DU_REPO>
```

Puis se placer dans le projet :

```bash
cd espocrm-test
```

### 3. Reporter les fichiers ACRM dans l’instance Espo

Recopier au minimum dans l’instance cible :

- [EspoCRM-9.3.4/custom](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/custom)
- [EspoCRM-9.3.4/client/custom](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/client/custom)
- [EspoCRM-9.3.4/html/main.html](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/html/main.html)

### 4. Rebuild Espo

Depuis le dossier Espo :

```bash
php command.php rebuild
```

### 5. Rejouer les scripts PHP de configuration

Scripts principaux :

- [sync_roles.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/sync_roles.php)
- [sync_dashboard.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/sync_dashboard.php)
- [sync_dashboard_templates.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/sync_dashboard_templates.php)
- [sync_test_users.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/sync_test_users.php)
- [import_knowledge_base_articles.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/import_knowledge_base_articles.php)

À exécuter selon le besoin de l’instance cible.

### 6. Rejouer les scripts SQL utiles

Scripts déjà préparés :

- [create_working_time_calendars.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/create_working_time_calendars.sql)
- [add_france_holidays_2026_2027.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/add_france_holidays_2026_2027.sql)
- [translate_email_templates_fr.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/translate_email_templates_fr.sql)
- [fix_contact_roles_array_value.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/fix_contact_roles_array_value.sql)

Scripts de nettoyage disponibles si on veut une base vide :

- [clear_business_data.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/clear_business_data.sql)
- [clear_users_except_admin.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/clear_users_except_admin.sql)

---

## Restauration depuis un backup

Si tu préfères restaurer un état sauvegardé :

### 1. Choisir un backup

Exemples :

- [backups/20260327-170757](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups/20260327-170757)
- [backups/20260327-232035](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups/20260327-232035)

### 2. Restaurer la base SQL

Importer le fichier :

- `espocrm_acadenice.sql`

### 3. Restaurer les fichiers custom

Décompresser :

- `custom.tar.gz`

et replacer son contenu dans l’instance Espo cible.

### 4. Réappliquer le `config.php` si nécessaire

Le backup contient aussi un :

- `config.php`

à comparer ou réinjecter selon l’environnement.

### 5. Rebuild

Après restauration :

```bash
php command.php rebuild
```

---

## Ce qu’il faut retenir

Pour reconstruire **ACRM**, il faut penser en trois couches :

- le code versionné ;
- les scripts de synchronisation et de configuration ;
- les backups exportés si on veut restaurer un état donné.

La méthode recommandée pour un nouveau serveur est :

1. installer EspoCRM 9.3.4 ;
2. recopier les fichiers custom du dépôt ;
3. lancer le rebuild ;
4. rejouer les scripts PHP/SQL utiles ;
5. n’utiliser les backups que comme complément ou restauration ciblée.
