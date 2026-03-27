# `contexte-projet-espocrm-acadenice`

```text
███████╗███████╗██████╗  ██████╗      ██████╗██████╗ ███╗   ███╗
██╔════╝██╔════╝██╔══██╗██╔═══██╗    ██╔════╝██╔══██╗████╗ ████║
█████╗  ███████╗██████╔╝██║   ██║    ██║     ██████╔╝██╔████╔██║
██╔══╝  ╚════██║██╔═══╝ ██║   ██║    ██║     ██╔══██╗██║╚██╔╝██║
███████╗███████║██║     ╚██████╔╝    ╚██████╗██║  ██║██║ ╚═╝ ██║
╚══════╝╚══════╝╚═╝      ╚═════╝      ╚═════╝╚═╝  ╚═╝╚═╝     ╚═╝
```

Contexte de travail du projet **EspoCRM AcadéNice**, rédigé pour permettre à une autre personne de reprendre le dépôt, comprendre la logique métier, et continuer sans devoir relire toute la conversation d'origine.

Ce document sert de mémoire projet.

---

## 🇫🇷 Français

### Présentation

Ce dépôt contient la base de travail d'un **EspoCRM 9.3.4** configuré pour **AcadéNice**.

Le projet a été construit comme un **CRM principal pour l'école**, avec un usage prioritaire autour de :

- la gestion des contacts ;
- la gestion des organisations ;
- le suivi des offres d'alternance ;
- le suivi des candidatures ;
- le suivi des contrats ;
- la connexion future avec **Filiz** pour les dossiers alternance.

Le projet reste volontairement simple :

- pas de surcouche complexe inutile ;
- pas d'intégration avancée activée trop tôt ;
- un modèle métier lisible pour l'équipe ;
- un stockage des informations techniques uniquement quand cela aide vraiment.

### Logique générale du CRM

La logique retenue pendant le travail est la suivante :

- `Contacts`
  personnes suivies par l'école : candidats, étudiants, alumni, parents / responsables, tuteurs, partenaires humains, contacts d'organisation

- `Organisations`
  entreprises, partenaires, structures diverses, clients éventuels liés à l'école ou à l'agence

- `Offres`
  besoins exprimés par une organisation, surtout pour l'alternance

- `Candidatures`
  lien entre un candidat et une offre

- `Contrats`
  suivi administratif et Filiz d'un dossier contractualisé

- `Formations`
  référentiel interne AcadéNice, simplifié pour rester la source métier principale

- `Promotions`
  sessions d'une formation, avec l'identifiant Filiz de la promotion

- `Skills`
  référentiel disponible mais utilisé de manière légère à ce stade

### Décisions métier importantes

#### Contact

La fiche `Contact` a été pensée pour s'adapter au rôle de la personne.

Principes retenus :

- les panels s'affichent selon les rôles du contact ;
- les informations candidat / étudiant / alumni ne doivent pas encombrer les contacts entreprise ;
- les informations entreprise ne doivent pas encombrer les candidats ;
- les champs ambigus ont été simplifiés autant que possible.

Exemples de logique retenue :

- `Statut candidat` sert au suivi métier principal ;
- les blocs `Parcours`, `Source` et `Profil` sont surtout visibles pour les candidats / étudiants / alumni ;
- les informations tuteur ont un panel dédié ;
- les informations parent / responsable ont un panel dédié ;
- `Nom d'usage` a été ajouté ;
- l'adresse a été détaillée pour permettre un usage administratif réel ;
- `Numéro de Sécurité Sociale` et les conditions particulières ont été ajoutés pour les profils étudiants ;
- les champs trop redondants ont été supprimés ;
- les champs système complexes ont été évités quand ils apportaient plus de confusion que de valeur.

Point de vigilance :

- la logique mineur / émancipé / responsable légal n'est pas finalisée avec un calcul automatique robuste, car les essais de calcul dynamique basés sur la date de naissance ont provoqué des erreurs côté interface. Il faudra revenir dessus plus tard avec une solution Espo compatible.

#### Organisation

La fiche `Organisation` a été construite comme le point d'entrée principal côté entreprise / structure.

Principes retenus :

- `Organisation` remplace le vocabulaire CRM générique `Compte` ;
- une organisation peut avoir une relation avec le CFA, avec l'agence, ou les deux ;
- les champs visibles varient selon le type de compte ;
- l'adresse a été alignée sur la structure détaillée des contacts ;
- les informations Filiz d'entreprise ont été séparées des informations métier d'organisation.

Décisions importantes :

- `Type de compte` a une valeur par défaut `Entreprise` ;
- `Téléphone` est obligatoire ;
- `Relation avec le CFA` et `Relation avec l'agence` sont distinctes ;
- le panel `Agence` est conditionnel ;
- le panel `Filiz` est réservé aux données techniques ou de synchronisation ;
- les statistiques de contrats alternance signés sont calculées automatiquement.

Point de vigilance :

- la logique conditionnelle du `Statut relation` selon le `Type de compte` a été testée mais les handlers frontend provoquaient des pages blanches. La logique a donc été simplifiée pour rester stable.

#### Offres

L'entité `Opportunity` a été renommée visuellement en `Offres`.

La logique retenue :

- une offre représente un besoin concret d'une organisation ;
- elle sert surtout à l'alternance ou au recrutement lié à une organisation ;
- elle ne sert pas aux formations initiales ou courtes sans besoin entreprise.

Décisions importantes :

- le champ de titre principal a été simplifié ;
- le lien avec l'organisation reste central ;
- un panel `Job Affinity` a été ajouté pour la référence externe ;
- les informations affichées visent le suivi réel du besoin, pas une logique de pipeline commercial générique.

#### Candidatures

La fiche `Candidature` a été pensée comme le lien métier propre entre :

- un candidat ;
- une offre.

Décisions importantes :

- `Organisation` et `Formation` ont été retirées de la fiche car déjà déductibles via l'offre ;
- le nom de la fiche est calculé automatiquement ;
- la structure retenue pour le nom est :
  `Prénom Nom - Organisation - Intitulé de l'offre`
- les champs système ont été rationalisés.

Cette entité est centrale pour :

- positionner un candidat sur une offre ;
- suivre l'avancement ;
- préparer ensuite un contrat.

#### Contrats

La fiche `Contrat` a été simplifiée pour éviter les doublons.

Décisions importantes :

- `Contact` et `Organisation` ont été retirés car déjà portés par la candidature ;
- `Formation` a été retirée car la `Promotion` suffit ;
- le nom du contrat est calculé automatiquement ;
- la structure retenue pour le nom est :
  `Prénom Nom - Organisation - Catégorie`
- le bloc Filiz garde un rôle de suivi, pas de formulaire API complet.

Cette fiche sert donc surtout à :

- suivre le contrat ;
- suivre le dossier Filiz ;
- suivre les dates et le statut administratif.

#### Formations

La fiche `Formation` a été volontairement simplifiée.

Décisions importantes :

- le CRM reste la source métier principale ;
- Filiz reste un système connecté, pas la source unique de vérité ;
- comme les formations existaient déjà dans Filiz, la stratégie retenue a été de garder dans Espo seulement les informations vraiment utiles.

Champs conservés dans l'esprit :

- nom ;
- code formation ;
- type de formation ;
- niveau ;
- durée ;
- rythme ;
- informations RNCP / NSF utiles ;
- ID formation Filiz.

Ce qui a été retiré :

- les blocs Filiz trop techniques ;
- les duplications inutiles ;
- les champs avancés non utiles en V1.

#### Promotions

La fiche `Promotion` a été maintenue simple.

Rôle retenu :

- représenter une session de formation ;
- relier une formation à son identifiant de promotion côté Filiz ;
- porter les dates de début et de fin.

Le choix de garder une entité `Promotion` séparée a été fait parce que le `classId` Filiz correspond à une session et non à la formation générale.

### Intégration Filiz

Le projet a été pensé pour préparer une intégration Filiz sans surcharger le CRM trop tôt.

Logique retenue :

- on garde dans Espo les informations utiles à l'exploitation métier ;
- on stocke les identifiants Filiz nécessaires ;
- les champs techniques sensibles sont souvent en lecture seule par défaut ;
- une case `Modifier` permet de déverrouiller les champs techniques si besoin réel.

Exemples :

- `ID utilisateur Filiz`
- `ID entreprise Filiz`
- `ID formation Filiz`
- `ID promotion Filiz`

Décision structurante :

- pour les formations déjà créées dans Filiz, la reprise manuelle est acceptable car le volume est faible ;
- l'automatisation complète n'a pas été mise en place à ce stade.

### Choix techniques importants

Pendant le projet, plusieurs choix ont été faits pour garder la stabilité :

- éviter les handlers frontend fragiles quand ils cassent l'interface ;
- préférer une logique simple et robuste plutôt qu'une automatisation trop précoce ;
- masquer ou retirer les champs redondants ;
- garder les panels conditionnels seulement quand ils restent fiables ;
- utiliser des champs calculés ou des hooks uniquement quand le bénéfice est clair.

Points connus :

- certaines logiques dynamiques très fines ont été abandonnées car elles provoquaient des pages blanches ;
- les entités custom ont demandé des contrôleurs dédiés pour éviter les erreurs `404` ;
- les blocs système natifs d'Espo ne se comportent pas exactement comme sur les entités CRM standard.

### Sauvegarde et reprise

Le dépôt contient un backup de référence ici :

- [backups/20260327-170757](/Users/ludovicrubio/Documents/New%20project/espocrm-test/backups/20260327-170757)

Ce backup a été créé pour :

- pouvoir tester sans crainte ;
- repartir d'un état propre si besoin ;
- préparer un futur déploiement serveur.

Le README du backup explique comment restaurer l'ensemble sur un autre serveur, en partant d'une instance propre de **EspoCRM 9.3.4**.

### État actuel du projet

À ce stade, le projet est dans un état de **base de test avancée**.

Cela veut dire :

- la structure métier principale est en place ;
- les entités essentielles sont créées ;
- les labels et layouts ont été beaucoup nettoyés ;
- le modèle est utilisable pour commencer de la saisie test ;
- il reste possible d'ajuster encore certains détails de layout ou de logique métier.

### Ce qu'il reste à faire plus tard

Les points à reprendre plus tard, si besoin :

- finaliser certaines logiques automatiques liées à l'âge, la minorité et l'émancipation ;
- décider si les `Skills` doivent jouer un vrai rôle métier ou rester secondaires ;
- préparer les dashboards et rapports ;
- décider jusqu'où aller dans la synchronisation Filiz ;
- stabiliser les droits non-admin avec des tests réels d'équipe ;
- tester la reprise complète sur un vrai serveur distant.

### Résumé rapide

Si quelqu'un reprend ce projet, la logique à retenir est :

- `Contact` = personne
- `Organisation` = structure
- `Offre` = besoin entreprise
- `Candidature` = lien candidat / offre
- `Contrat` = suivi administratif et Filiz
- `Formation` = référentiel école
- `Promotion` = session de formation
- `Filiz` = outil connecté, pas référentiel principal du CRM

Le projet a été construit avec une priorité constante :

- rester simple ;
- garder un CRM lisible pour l'équipe ;
- ne pas créer de complexité technique inutile trop tôt.
