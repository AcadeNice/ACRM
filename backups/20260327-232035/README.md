# `backup-espocrm-acadenice-20260327-232035`

```text
███████╗███████╗██████╗  ██████╗      ██████╗██████╗ ███╗   ███╗
██╔════╝██╔════╝██╔══██╗██╔═══██╗    ██╔════╝██╔══██╗████╗ ████║
█████╗  ███████╗██████╔╝██║   ██║    ██║     ██████╔╝██╔████╔██║
██╔══╝  ╚════██║██╔═══╝ ██║   ██║    ██║     ██╔══██╗██║╚██╔╝██║
███████╗███████║██║     ╚██████╔╝    ╚██████╗██║  ██║██║ ╚═╝ ██║
╚══════╝╚══════╝╚═╝      ╚═════╝      ╚═════╝╚═╝  ╚═╝╚═╝     ╚═╝
```

Sauvegarde de l’instance de test **EspoCRM AcadéNice**, préparée pour pouvoir :

- restaurer l’environnement de test ;
- réinstaller la configuration sur un autre serveur ;
- éviter de recréer manuellement les entités, champs, layouts et relations.

Cette sauvegarde a été réalisée pour **EspoCRM 9.3.4**.

Ce snapshot inclut notamment :

- les entités et layouts custom déjà configurés ;
- les `118` skills présentes dans la base ;
- les 6 formations AcadéNice renseignées ;
- les promotions `2025` et `2026` déjà créées.

Le dossier a été pensé pour qu’une personne qui ne connaît pas EspoCRM puisse comprendre **quoi restaurer**, **dans quel ordre**, et **ce qu’il faut adapter** avant une mise en ligne.

---

## 🇫🇷 Français

### Présentation

`backup-espocrm-acadenice-20260327-232035` est un backup fonctionnel d’une instance de test `EspoCRM 9.3.4` configurée pour le besoin AcadéNice.

Il contient :

- une sauvegarde SQL de la base ;
- une archive du dossier `custom` ;
- un `config.php` local servant de référence ;
- ce guide de restauration.

### Direction du backup

L’objectif n’est pas de livrer un package automatisé complexe, mais une base simple et claire pour :

- remettre un environnement de test en place rapidement ;
- transférer la configuration sur un serveur ;
- préparer une future mise en préproduction ou en production.

Le dossier évite volontairement :

- les scripts de déploiement compliqués ;
- les dépendances inutiles ;
- les étapes opaques ;
- les manipulations réservées à quelqu’un qui connaît déjà EspoCRM.

### Contenu du dossier

Le backup contient :

- `espocrm_acadenice.sql`
- `custom.tar.gz`
- `config.php`
- `README.md`

### Rôle de chaque fichier

- `espocrm_acadenice.sql`
  Sauvegarde de la base de données de test.

- `custom.tar.gz`
  Sauvegarde de toute la configuration métier créée dans EspoCRM.
  C’est le fichier le plus important côté structure fonctionnelle.

- `config.php`
  Fichier de configuration de l’instance locale de test.
  Il sert de base de lecture, mais **ne doit pas être repris tel quel** sur un serveur en ligne.

- `README.md`
  Guide de restauration simple.

### Ce qui est vraiment important

Si tu veux reconstruire l’instance sur un autre serveur, les deux éléments essentiels sont :

- `espocrm_acadenice.sql`
- `custom.tar.gz`

Le `config.php` sert surtout à :

- retrouver certains réglages ;
- comparer la configuration ;
- adapter la future instance en ligne.

### Pré-requis

Le serveur cible doit disposer de :

- `EspoCRM 9.3.4`
- `MariaDB` ou `MySQL`
- un accès `SSH` ou terminal
- `PHP` en ligne de commande
- les accès à la base de données

### Logique de restauration

L’ordre recommandé est le suivant :

1. installer une instance propre d’EspoCRM `9.3.4`
2. sauvegarder l’instance du serveur avant toute modification
3. restaurer la base SQL
4. restaurer le dossier `custom`
5. adapter le `config.php`
6. lancer un `rebuild`
7. tester l’interface

### Restaurer la base

Importer le fichier SQL dans la base cible.

Exemple :

```bash
mariadb -u UTILISATEUR -p NOM_DE_LA_BASE < espocrm_acadenice.sql
```

### Restaurer le dossier `custom`

Décompresser `custom.tar.gz` à la racine de l’instance EspoCRM.

Exemple :

```bash
tar -xzf custom.tar.gz -C /chemin/vers/EspoCRM
```

### Adapter `config.php`

Sur un serveur en ligne, il faut vérifier au minimum :

- les identifiants de base de données
- le nom de la base
- l’URL du site
- les chemins locaux devenus invalides
- les réglages propres au serveur

Si le serveur possède déjà un `config.php` valide, il vaut mieux :

- conserver le fichier du serveur
- reprendre seulement les paramètres utiles depuis ce backup

### Rebuild EspoCRM

Depuis le dossier EspoCRM :

```bash
php command.php rebuild -y
```

Cette étape est indispensable pour :

- recharger les métadonnées
- reconstruire les layouts
- prendre en compte les entités et champs custom
- remettre l’interface dans un état cohérent

### Vérifications après restauration

Une fois la restauration terminée, vérifier dans l’interface :

- que les entités custom sont visibles
- que les menus sont présents
- que les layouts s’affichent correctement
- que les champs conditionnels fonctionnent
- que les sous-panels et relations remontent bien
- que les droits d’accès sont corrects

### Mise en ligne conseillée

La bonne pratique est :

1. restaurer d’abord sur une préproduction
2. tester l’instance
3. corriger si nécessaire
4. seulement ensuite répliquer sur la production

### Notes importantes

- ce backup vient d’une **instance locale de test**
- il est adapté à une restauration technique, pas à une mise en production brute
- le `custom.tar.gz` porte la logique métier
- le SQL porte les données et la structure sauvegardées au moment du backup

### Résumé court

Pour réinstaller cette configuration sur un autre serveur :

- installer `EspoCRM 9.3.4`
- importer `espocrm_acadenice.sql`
- restaurer `custom.tar.gz`
- adapter `config.php`
- lancer `php command.php rebuild -y`
- tester
