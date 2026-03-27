# `espo-crm-acadenice`

```text
███████╗███████╗██████╗  ██████╗      ██████╗██████╗ ███╗   ███╗
██╔════╝██╔════╝██╔══██╗██╔═══██╗    ██╔════╝██╔══██╗████╗ ████║
█████╗  ███████╗██████╔╝██║   ██║    ██║     ██████╔╝██╔████╔██║
██╔══╝  ╚════██║██╔═══╝ ██║   ██║    ██║     ██╔══██╗██║╚██╔╝██║
███████╗███████║██║     ╚██████╔╝    ╚██████╗██║  ██║██║ ╚═╝ ██║
╚══════╝╚══════╝╚═╝      ╚═════╝      ╚═════╝╚═╝  ╚═╝╚═╝     ╚═╝
```

Référentiel Git de travail pour la configuration **EspoCRM AcadéNice**.

Le dépôt contient uniquement les éléments utiles à versionner :

- les sauvegardes exportables ;
- la documentation de restauration ;
- la configuration métier réutilisable.

Version cible actuelle :

- `EspoCRM 9.3.4`

---

## 🇫🇷 Français

### Présentation

Ce dépôt ne contient **pas** toute l’instance locale EspoCRM.

Il a été structuré pour versionner seulement ce qui est utile à partager et restaurer :

- les backups
- les fichiers de configuration exportables
- la documentation

### Structure du dépôt

```text
.
├── backups/
│   └── 20260327-170757/
│       ├── README.md
│       ├── config.php
│       ├── custom.tar.gz
│       └── espocrm_acadenice.sql
└── README.md
```

### Logique du dépôt

Le but est de :

- garder un historique propre
- éviter de pousser l’instance locale complète
- pouvoir restaurer rapidement un serveur
- préparer une future préproduction ou production

### Élément principal à utiliser

Le backup actuellement prêt se trouve dans :

- [backups/20260327-170757](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups/20260327-170757)

### Note importante

L’instance locale complète et l’archive d’installation EspoCRM restent volontairement hors Git.
