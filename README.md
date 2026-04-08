# ACRM

> **ACRM** est une instance métier personnalisée, basée sur **EspoCRM 9.3.4**.

Ce dépôt sert de base de travail, de sauvegarde versionnée et de point de réinstallation pour reconstruire une instance ACRM vierge avec :

- le thème ;
- les personnalisations métier ;
- les entités et champs custom ;
- les hooks et automatisations ;
- les traductions ;
- les layouts ;
- les dashboards et templates ;
- les scripts de synchronisation et de nettoyage.

Le nom du produit dans toute la documentation du dépôt est **ACRM**.

---

## Vue d’ensemble

Le dépôt contient :

- une copie locale de travail d’EspoCRM ;
- les customisations versionnées utiles à ACRM ;
- des scripts SQL et PHP pour rejouer la configuration ;
- des sauvegardes historiques ;
- la documentation projet.

Le dépôt ne sert **pas** à versionner les données métier réelles de production.

---

## Version cible

- `EspoCRM 9.3.4`

---

## Structure utile

```text
.
├── EspoCRM-9.3.4/
│   ├── client/custom/
│   ├── custom/
│   ├── html/
│   └── data/
├── docs/
├── scripts/
├── backups/
├── RESINSTALL.md
└── README.md
```

## Ce qui est versionné

Les éléments utiles à reconfigurer une instance ACRM sont versionnés, notamment :

- [custom](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/custom)
- [client/custom](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/client/custom)
- [html/main.html](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/html/main.html)
- [scripts](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts)
- les scripts SQL de configuration utiles dans [docs](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs)

Cela couvre notamment :

- le thème `AcadeNicePro` ;
- les hooks `beforeSave` / `afterSave` ;
- les champs et valeurs prédéfinies ;
- les traductions FR ;
- les templates système ;
- les dashboards et templates de dashboard ;
- les scripts de rôles et d’utilisateurs ;
- les calendriers de jours travaillés et jours fériés ;
- les scripts de nettoyage d’instance.

## Ce qui n’est pas versionné comme source métier

On évite de versionner dans Git :

- les données utilisateurs réelles ;
- les contacts, organisations, tickets, candidatures de travail ;
- les jeux de test temporaires ;
- les seeds de démonstration à usage ponctuel ;
- le contenu vivant de la base hors scripts de reconstruction.

---

## Réinstallation d’une instance vierge

Objectif : repartir d’une instance EspoCRM neuve et reconstituer ACRM avec sa configuration.

### 1. Préparer une instance EspoCRM 9.3.4

Installer une instance EspoCRM propre en version `9.3.4`.

### 2. Recopier les fichiers versionnés

Reporter au minimum :

- [custom](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/custom)
- [client/custom](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/client/custom)
- [html/main.html](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4/html/main.html)

### 3. Rejouer le rebuild

Depuis le dossier Espo :

```bash
php command.php rebuild
```

### 4. Rejouer les scripts de synchronisation

Scripts principaux :

- [sync_roles.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/sync_roles.php)
- [sync_dashboard.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/sync_dashboard.php)
- [sync_dashboard_templates.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/sync_dashboard_templates.php)
- [sync_test_users.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/sync_test_users.php)
- [import_knowledge_base_articles.php](/Users/ludovicrubio/Documents/New%20project/espocrm-test/scripts/import_knowledge_base_articles.php)

### 5. Rejouer les scripts SQL utiles selon le besoin

Scripts déjà préparés :

- [create_working_time_calendars.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/create_working_time_calendars.sql)
- [add_france_holidays_2026_2027.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/add_france_holidays_2026_2027.sql)
- [translate_email_templates_fr.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/translate_email_templates_fr.sql)
- [fix_contact_roles_array_value.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/fix_contact_roles_array_value.sql)

### 6. Si on veut repartir propre

Scripts de nettoyage disponibles :

- [clear_business_data.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/clear_business_data.sql)
- [clear_users_except_admin.sql](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/clear_users_except_admin.sql)

---

## Développement local

Depuis :

- [EspoCRM-9.3.4](/Users/ludovicrubio/Documents/New%20project/espocrm-test/EspoCRM-9.3.4)

l’instance locale peut être lancée avec :

```bash
php -S 127.0.0.1:8080 router-public.php
```

Puis ouvrir :

- [http://127.0.0.1:8080](http://127.0.0.1:8080)

---

## Backups intégrés

Le dépôt contient aussi des backups historiques exportables dans :

- [backups/20260327-170757](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups/20260327-170757)
- [backups/20260327-232035](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups/20260327-232035)

Chaque backup contient :

- un `README.md` propre au backup ;
- un `config.php` ;
- un `custom.tar.gz` ;
- un `espocrm_acadenice.sql`.

Ces backups servent de filet de sécurité et de point de restauration ponctuel, en complément du code versionné.

La logique recommandée reste :

- Git pour reconstruire et maintenir ACRM ;
- backups pour restaurer un état historique exporté quand c’est nécessaire.

---

## Documentation projet

Documents utiles :

- [CONTEXTE_PROJET.md](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/CONTEXTE_PROJET.md)
- [GUIDE_UTILISATION_ESPCRM_ACADENICE.md](/Users/ludovicrubio/Documents/New%20project/espocrm-test/docs/GUIDE_UTILISATION_ESPCRM_ACADENICE.md)
- [RESINSTALL.md](/Users/ludovicrubio/Documents/New%20project/espocrm-test/RESINSTALL.md)

---

## Note importante

Ce dépôt permet de retrouver **ACRM**, c’est-à-dire :

- une base EspoCRM ;
- enrichie par les personnalisations ACRM ;
- sans embarquer les vraies données métier.

Pour une restauration totalement fidèle d’un environnement donné, il faut combiner :

- le code versionné ;
- les scripts SQL/PHP ;
- et, si nécessaire, un dump SQL propre de référence.
