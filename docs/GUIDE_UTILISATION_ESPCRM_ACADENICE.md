# Guide d'utilisation EspoCRM AcadéNice

## Objectif de ce document

Ce guide a été rédigé pour les salariés d'AcadéNice qui vont utiliser le CRM au quotidien.

Il ne s'agit **pas** d'un guide de configuration technique.
Même si votre compte dispose d'un accès administrateur, ce document vous explique **comment utiliser le CRM pour travailler**, pas comment modifier sa structure.

Ce guide est pensé pour des personnes qui :

- n'ont jamais utilisé EspoCRM ;
- n'ont jamais utilisé de CRM ;
- ont besoin d'un repère simple, concret et opérationnel.

---

## À quoi sert le CRM chez AcadéNice ?

Le CRM sert à centraliser, organiser et suivre toutes les informations utiles pour l'activité d'AcadéNice.

En pratique, il permet de :

- suivre les **organisations** avec lesquelles AcadéNice travaille ;
- suivre les **contacts** : candidats, étudiants, alumni, tuteurs, partenaires, parents, etc. ;
- gérer les **offres** d'alternance, de stage ou d'emploi ;
- suivre les **candidatures** envoyées sur ces offres ;
- suivre les **contrats** signés ou en cours ;
- garder un référentiel clair des **formations**, **promotions** et **compétences**.

Le CRM évite :

- les fichiers Excel dispersés ;
- les informations perdues dans les emails ;
- les doubles saisies ;
- les oublis de suivi ;
- les incohérences entre membres de l'équipe.

---

## La logique générale du CRM

Voici la logique métier la plus importante à retenir :

1. Une **organisation** représente une entreprise, un partenaire ou une autre structure.
2. Un **contact** représente une personne.
3. Une **offre** représente un besoin de recrutement d'une organisation.
4. Une **candidature** relie un candidat à une offre.
5. Un **contrat** représente le résultat administratif d'une candidature transformée.
6. Une **formation** représente le catalogue AcadéNice.
7. Une **promotion** représente une session précise d'une formation.
8. Une **compétence** sert de référentiel commun pour qualifier les profils, les formations et les offres.

En version très simple :

`Organisation` → `Offre` → `Candidature` → `Contrat`

et en parallèle :

`Contact` ↔ `Candidature`

`Formation` ↔ `Promotion`

`Formation` / `Contact` / `Offre` ↔ `Compétences`

---

## Avant de commencer : les 7 règles d'usage

### 1. Le CRM doit refléter la réalité

On ne saisit que des informations utiles et vérifiées.

### 2. On évite les doublons

Avant de créer une fiche :

- cherchez si elle existe déjà ;
- vérifiez l'orthographe ;
- vérifiez les fiches proches.

### 3. On remplit d'abord les champs importants

Il vaut mieux une fiche simple mais juste qu'une fiche très remplie mais incohérente.

### 4. On utilise les statuts de façon rigoureuse

Les statuts servent au pilotage de l'équipe.
Un mauvais statut fausse le suivi.

### 5. On ne modifie pas la structure du CRM

Même si vous avez un accès admin, **n'allez pas dans Administration / Entity Manager / Metadata / Layouts** sauf consigne explicite.

### 6. On garde les commentaires utiles

Un commentaire doit aider un collègue à comprendre la situation rapidement.

### 7. On pense collectif

Le CRM n'est pas votre pense-bête personnel.
Il doit permettre à toute l'équipe de reprendre un dossier sans dépendre d'une seule personne.

---

## Comprendre l'interface EspoCRM

## Les principales zones de l'écran

### La barre latérale

Elle permet d'accéder aux entités :

- Organisations
- Contacts
- Offres
- Candidatures
- Contrats
- Formations
- Promotions
- Skills / Compétences

### La liste

La liste affiche plusieurs fiches d'une même entité.
On peut :

- rechercher ;
- filtrer ;
- trier ;
- ouvrir une fiche ;
- créer une nouvelle fiche.

### La fiche détail

La fiche détail permet de consulter une fiche existante, de voir son flux, ses informations et ses relations.

### Le bouton `Créer`

Il permet de créer une nouvelle fiche.

### Le flux

Le flux montre les changements récents sur une fiche :

- création ;
- mise à jour de champs ;
- commentaires éventuels.

Le flux sert au suivi, pas à la saisie.

---

## Ordre de travail recommandé

Dans la plupart des cas, on travaille dans cet ordre :

1. vérifier si l'**organisation** existe ;
2. vérifier si le **contact** existe ;
3. créer ou compléter l'**offre** ;
4. créer la **candidature** ;
5. créer le **contrat** si la candidature avance jusqu'à la signature.

Les **formations**, **promotions** et **compétences** sont plutôt des référentiels.
On ne les recrée pas à chaque fois.

---

# 1. Organisations

## À quoi sert une organisation ?

Une organisation représente une structure avec laquelle AcadéNice est en relation :

- une entreprise ;
- un partenaire ;
- une autre structure.

On y stocke :

- les informations d'identification ;
- le type de relation ;
- l'adresse ;
- les informations CFA ;
- les informations agence ;
- les informations de suivi administratif.

## Quand créer une organisation ?

Créer une organisation quand :

- une nouvelle entreprise entre dans le pipeline ;
- un partenaire est identifié ;
- une structure doit être suivie dans la durée.

Ne pas créer une organisation :

- si la structure existe déjà ;
- si l'information est trop floue ;
- si ce n'est qu'un nom évoqué sans utilité de suivi.

## Les champs de la fiche Organisation

### Panel `🏢 Organisation`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Nom` | Nom officiel ou usuel de la structure | Renseigner le nom le plus clair pour l'équipe |
| `Type de compte` | Nature de la structure | Choisir `Entreprise`, `Partenaire` ou `Autre` |
| `Statut relation` | Niveau de relation avec AcadéNice | Utiliser le bon statut métier : prospect, client, partenaire |
| `Type de partenaire` | Précise la nature du partenaire | À remplir seulement si le type de compte est `Partenaire` |
| `Relation avec le CFA` | Indique si la structure est liée à l'activité CFA | Cocher si l'organisation travaille ou peut travailler avec le CFA |
| `Relation avec l'agence` | Indique si la structure est aussi liée à l'agence | Cocher si l'agence a une relation commerciale ou de prestation |
| `Email` | Email principal de la structure | Utiliser l'email générique ou principal si pertinent |
| `Téléphone` | Numéro principal | Numéro standard de contact |
| `Site internet` | Site web officiel | Ajouter le site si utile au suivi |
| `Industrie` | Secteur d'activité | Choisir le secteur qui correspond le mieux à l'activité |
| `SIRET` | Identifiant légal de l'entreprise | À renseigner si connu |
| `Code APE` | Code APE de l'organisation | Utile pour la partie employeur / alternance |
| `Code IDCC` | Convention collective | À renseigner si connue |
| `Nombre total de salariés` | Taille de l'organisation | Renseigner si l'information est disponible |
| `N°`, `Complément`, `Type de voie`, `Nom de la voie`, `Code postal`, `Ville`, `Pays`, `Complément libre` | Adresse de l'organisation | Renseigner l'adresse de façon structurée |

### Panel `🧭 Origine`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Origine` | Comment l'organisation est arrivée dans le CRM | Choisir la source principale |
| `Canal d'origine` | Canal concret d'entrée | Exemple : LinkedIn, téléphone, site, réseau |
| `Cooptation (personne)` | Personne ayant recommandé la structure | À remplir uniquement si pertinent |
| `Cooptation (organisation)` | Organisation ayant recommandé la structure | À remplir uniquement si pertinent |
| `Détail d'origine` | Précision libre sur l'origine | Utiliser pour expliquer le contexte si nécessaire |

### Panel `🎓 Relation avec le CFA`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Contrats d'alternance signés` | Nombre total de contrats signés | Champ de suivi, souvent calculé ou vérifié |
| `Contrats d'alternance sur 12 mois` | Activité récente de la structure | Sert au pilotage commercial et pédagogique |
| `Date du dernier contrat d'alternance signé` | Dernière date connue de contrat | Permet de savoir si la relation est active |
| `Commentaires CFA` | Notes utiles sur la relation CFA | Noter uniquement ce qui aide l'équipe |

### Panel `🔗 Filiz`

Ce panel est technique.
Il sert uniquement dans les cas liés à Filiz.

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Modifier les informations Filiz` | Déverrouille les champs techniques | Cocher seulement si une correction manuelle est nécessaire |
| `ID entreprise Filiz` | Identifiant de la structure dans Filiz | Ne pas inventer |
| `Secteur employeur` | Public ou privé | À renseigner seulement si utile pour Filiz |
| `Type d'employeur` | Typologie employeur attendue par Filiz | Utiliser uniquement si nécessaire |
| `Employeur spécifique` | Cas particuliers employeur | À réserver aux cas concernés |

### Panel `🛠️ Relation avec l'Agence`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Statut relation agence` | Niveau de relation côté agence | Prospect, client, ancien client |
| `Type de client agence` | Type de besoin ou de prestation | Peut contenir plusieurs valeurs |
| `Contrat de maintenance en cours` | Indique un contrat actif | Cocher si applicable |
| `Commentaires agence` | Notes liées à l'agence | Notes opérationnelles uniquement |

### Panel `🗂️ Système`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Date de création` | Date de création de la fiche | Lecture seule |
| `Date de modification` | Dernière modification | Lecture seule |

---

# 2. Contacts

## À quoi sert un contact ?

Un contact représente une personne :

- candidat ;
- étudiant ;
- alumni ;
- tuteur entreprise ;
- partenaire ;
- dirigeant ;
- parent / responsable légal ;
- autre profil utile.

## Quand créer un contact ?

Créer un contact quand une personne doit être suivie individuellement.

Exemples :

- un candidat qui postule ;
- un étudiant déjà admis ;
- un tuteur entreprise ;
- un partenaire prescripteur.

## Principe important

Le champ `Rôles du contact` est central.
Il détermine la nature du contact et conditionne certains champs affichés.

## Les champs de la fiche Contact

### Panel `👤 Identité`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Nom` | Identité principale du contact | Nom complet de la personne |
| `Photo` | Photo d'identité | Optionnel |
| `Nom d'usage` | Nom utilisé au quotidien | Renseigner si différent du nom principal |
| `Rôles du contact` | Type(s) de profil de la personne | Peut contenir plusieurs rôles |
| `Fonction` | Fonction du contact | Utile surtout pour tuteurs, dirigeants, partenaires, collaborateurs |
| `Organisation` | Structure principale liée | Rattacher la personne à son organisation si nécessaire |
| `Email` | Email principal | Toujours utile si connu |
| `Téléphone` | Téléphone principal | À renseigner si disponible |
| `Extension BOE` | Information de suivi spécifique | À utiliser si le cas existe réellement |
| `RQTH` | Situation RQTH | Cocher si concerné |
| `Sportif de haut niveau` | Statut particulier | Cocher si concerné |
| `Équivalence jeune` | Information spécifique | À renseigner si utile |
| `Date de naissance` | Permet aussi certaines logiques de majorité | Toujours utile pour les candidats / étudiants |
| `Numéro de Sécurité Sociale` | Information administrative | À remplir uniquement si nécessaire et fiable |
| `N°`, `Complément`, `Type de voie`, `Nom de la voie`, `Code postal`, `Ville`, `Pays`, `Complément libre` | Adresse du contact | Saisie structurée de l'adresse |
| `Commentaires` | Commentaire libre sur l'identité | Éviter les notes inutiles |

### Panel `🎓 Parcours`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Statut candidat` | Statut global du parcours du candidat | Très important pour le pilotage |
| `Formation visée` | Formation principalement recherchée | Choisir la bonne formation |
| `Résultat des tests` | Résultat du process de test | À utiliser si les tests existent |
| `Date d'admission` | Date d'admission du contact | Pour les admis |
| `Date de placement` | Date de placement en entreprise | Pour les profils placés |

### Les statuts candidat

Voici le sens recommandé :

- `Nouveau` : fiche créée, non traitée ;
- `À qualifier` : à contacter ou à analyser ;
- `Admissible` : profil jugé pertinent ;
- `Test en cours` : étape d'évaluation en cours ;
- `Admis` : validé pour la formation ;
- `En recherche entreprise` : admis, mais pas encore placé ;
- `Positionné` : présenté sur une ou plusieurs offres ;
- `Placé` : entreprise trouvée ;
- `Non retenu` : candidature ou profil non retenu ;
- `Abandon` : le contact sort volontairement du process ;
- `Injoignable` : impossible à recontacter ;
- `Reporté` : à reprendre plus tard.

### Panel `🧭 Source`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Source` | Origine principale du contact | Très utile pour savoir d'où viennent les candidats |
| `Jobboard diffusé` | Jobboard d'origine | À remplir si la source est un jobboard |
| `CVthèque d'origine` | CVthèque utilisée | À remplir si la source est une CVthèque |
| `Cooptation (personne)` | Personne prescriptrice | À utiliser si le contact a été recommandé |
| `Cooptation (organisation)` | Organisation prescriptrice | À utiliser si le contact vient d'un partenaire |
| `Détail de la source` | Précision libre | Ajouter le contexte si utile |

### Panel `📍 Profil`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Zone de mobilité` | Zones acceptées par le contact | Très utile pour le matching |
| `Permis` | Situation permis | Choisir le statut réel |
| `Compétences` | Compétences du contact | Sélectionner les compétences utiles et vérifiées |
| `Possède un véhicule` | Mobilité autonome | À remplir si pertinent |
| `LinkedIn` | Profil LinkedIn | Mettre l'URL complète |
| `GitHub` | Profil GitHub | Utile surtout pour les profils tech |
| `Lien portfolio` | Portfolio en ligne | Utile pour design / communication |
| `Fichier portfolio` | Fichier portfolio | Joindre si besoin |
| `Lien CV` | Lien vers un CV en ligne | Utiliser si disponible |
| `Fichier CV` | CV joint | Joindre le CV actualisé |
| `Commentaires` | Commentaire libre sur le profil | Résumer l'essentiel, pas le superflu |

### Panel `🔗 Filiz`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Né(e) en France` | Information administrative | À renseigner selon la réalité |
| `Nationalité` | Nationalité au sens Filiz | Utiliser la valeur la plus juste |
| `Ville de naissance` | Donnée administrative | À remplir si connue |
| `Département de naissance` | Donnée administrative | À renseigner si nécessaire |
| `Sexe` | Information administrative | À remplir si utile au dossier |
| `Émancipé` | Cas spécifique mineur | À utiliser seulement si applicable |
| `Responsable légal` | Parent ou tuteur légal | Important pour les mineurs non émancipés |
| `Titre de séjour autorisant le travail` | Cas des personnes concernées | À renseigner si nécessaire |
| `ID utilisateur Filiz` | Identifiant Filiz | Ne pas inventer |
| `Modifier l'ID` | Déverrouille l'ID Filiz | Cocher uniquement si correction manuelle |

### Panel `🎯 Tuteur`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Candidats / Étudiants suivis` | Liste des personnes suivies par ce tuteur | À utiliser seulement pour les tuteurs |
| `Commentaires` | Notes liées au rôle de tuteur | Notes utiles uniquement |

### Panel `👨‍👩‍👧 Parent / Responsable`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Lien parental` | Qualité du responsable | Père, mère, tuteur légal, autre |
| `Commentaires` | Notes sur le rôle parental | À remplir si utile |

### Panel `🗂️ Système`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Date de création` | Date de création de la fiche | Lecture seule |
| `Date de modification` | Dernière modification | Lecture seule |

---

# 3. Offres

## À quoi sert une offre ?

Une offre représente un besoin réel d'une organisation :

- alternance ;
- stage ;
- emploi ;
- autre besoin.

C'est une fiche centrale pour le lien entre :

- l'organisation ;
- la formation concernée ;
- les compétences attendues ;
- les candidatures envoyées.

## Les champs de la fiche Offre

### Panel `💼 Besoin`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Intitulé du poste` | Nom de l'offre | Être clair et lisible |
| `Formation liée` | Formation AcadéNice concernée | Très important pour le bon ciblage |
| `Organisation` | Entreprise ou structure qui recrute | Obligatoire en pratique |
| `Contact au sein de l'organisation` | Interlocuteur principal côté organisation | Choisir la bonne personne |
| `Type d'offre / besoin` | Nature du besoin | Alternance, stage, emploi, autre |
| `Statut du besoin` | Statut global de l'offre | Ouverte, en cours, pourvue, fermée, suspendue |
| `Date de début souhaitée` | Date idéale de démarrage | À saisir si connue |
| `Rythme souhaité` | Rythme attendu | Champ texte métier |
| `Localisation` | Zone géographique du poste | Renseigner clairement |
| `Télétravail` | Niveau de télétravail autorisé | Non, partiel, oui |
| `Nombre de postes` | Nombre de postes ouverts | Toujours utile |
| `Nombre de candidats à proposer` | Objectif de profils à transmettre | Sert au pilotage commercial |
| `Urgence` | Priorité du besoin | Basse, normale, haute, urgente |
| `Niveau requis` | Niveau de diplôme attendu | Choisir le niveau le plus pertinent |

### Panel `📣 Annonce`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Titre d'annonce` | Titre diffusé publiquement | Penser diffusion externe |
| `Statut de l'annonce` | Statut de publication | Brouillon, à diffuser, diffusée, pause, fermée |
| `Canaux de diffusion` | Canaux utilisés pour la diffusion | Peut contenir plusieurs valeurs |
| `Date de publication` | Date de diffusion | À remplir si l'annonce est publiée |
| `Fin de diffusion` | Date de fin ou de retrait | À remplir si utile |
| `Accroche d'annonce` | Résumé court | Utile pour jobboard ou communication |
| `Texte d'annonce` | Texte complet diffusé | Doit être exploitable sans retraitement |

### Panel `🧠 Pré requis`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Pré requis / Compétences` | Compétences attendues | Sélectionner les compétences réellement demandées |
| `Permis requis` | Permis obligatoire ou non | Cocher seulement si indispensable |
| `Langue requise` | Langue(s) attendue(s) | Peut contenir plusieurs langues |
| `Âge minimum` | Borne basse si besoin spécifique | À utiliser avec prudence |
| `Âge maximum` | Borne haute si besoin spécifique | À utiliser avec prudence |
| `Salaire min.` | Fourchette basse | Si l'information est connue |
| `Salaire max.` | Fourchette haute | Si l'information est connue |
| `Commentaires internes` | Notes internes d'équipe | Ce champ n'est pas destiné à la diffusion |

### Panel `🔗 Job Affinity`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Référence interne JobAffinity` | Référence technique | Ne pas modifier sans raison |
| `Modifier la référence` | Déverrouillage manuel | À utiliser seulement en cas de besoin technique |

### Panel `🗂️ Système`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Date de création` | Date de création | Lecture seule |
| `Date de modification` | Dernière modification | Lecture seule |

---

# 4. Candidatures

## À quoi sert une candidature ?

Une candidature relie :

- un candidat ;
- une offre.

C'est la fiche de suivi la plus importante pour l'avancement opérationnel.

## Les champs de la fiche Candidature

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Candidat` | Personne concernée | Choisir le bon contact |
| `Offre` | Offre concernée | Choisir la bonne offre |
| `Statut de la candidature` | Avancement précis de cette candidature | C'est le champ principal de pilotage |
| `Priorité` | Niveau d'attention | Basse, normale ou haute |
| `Date de positionnement` | Date à laquelle le candidat est positionné | Très utile pour le suivi |
| `Date d'envoi du CV` | Date de transmission à l'entreprise | À remplir dès que le CV part |
| `Date d'entretien` | Date de rendez-vous | À renseigner si entretien prévu ou passé |
| `Décision de l'organisation` | Retour de l'entreprise | En attente, acceptée, refusée |
| `Motif de refus` | Raison du refus | À renseigner uniquement si refus |
| `Commentaires` | Notes utiles sur la candidature | Notes courtes et actionnables |
| `Date de création` | Date de création | Lecture seule |
| `Date de modification` | Dernière modification | Lecture seule |

## Les statuts de candidature

Sens recommandé :

- `À proposer` : candidature encore à préparer ;
- `Proposée` : profil retenu pour présentation ;
- `CV envoyé` : dossier transmis à l'organisation ;
- `Entretien planifié` : entretien fixé ;
- `Entretien passé` : entretien réalisé ;
- `En attente de retour` : attente de décision ;
- `Acceptée` : candidature retenue ;
- `Refusée par l'entreprise` : refus côté organisation ;
- `Refusée par le candidat` : refus côté candidat ;
- `Abandonnée` : arrêt du process ;
- `Transformée en contrat` : suite administrative engagée.

---

# 5. Contrats

## À quoi sert un contrat ?

Le contrat sert à suivre la phase administrative après une candidature réussie.

Il est centré sur :

- la candidature ;
- la promotion ;
- le statut administratif ;
- le suivi Filiz si nécessaire.

## Les champs de la fiche Contrat

### Panel `📄 Contrat`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Statut contrat` | Avancement administratif du contrat | Très important pour le suivi |
| `Catégorie` | Type général de contrat | Alternance, initiale, courte |
| `Gestion` | Mode de gestion | `Filiz` ou `Manuel` |
| `Candidature` | Candidature d'origine | Permet de rattacher le bon dossier |
| `Promotion` | Promotion concernée | Indispensable pour le bon rattachement pédagogique |

### Panel `📆 Période`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Date de début` | Début du contrat ou de la période | À saisir si connue |
| `Date de fin` | Fin prévue | À saisir si connue |
| `Montant` | Montant associé si suivi nécessaire | À renseigner si utile |

### Panel `🔗 Filiz`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Envoyé dans Filiz` | Indique si le dossier est parti dans Filiz | Cocher selon l'état réel |
| `Statut Filiz` | Statut technique ou fonctionnel du dossier | Plutôt de lecture/suivi |
| `ID dossier Filiz` | Identifiant du dossier Filiz | Ne pas inventer |
| `ID devis Filiz` | Identifiant du devis Filiz | Si fourni par Filiz |
| `Étape Filiz` | Étape courante du process Filiz | Lecture utile pour le suivi |
| `Dernière synchro Filiz` | Dernière mise à jour | Lecture seule en pratique |
| `Date d'envoi Filiz` | Date du dernier envoi | Renseigne la traçabilité |
| `Erreur Filiz` | Dernier message d'erreur | Très utile en cas de problème |
| `Commentaires administratifs` | Notes internes d'administration | Mettre les informations de suivi utiles |

### Panel `🗂️ Système`

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Date de création` | Date de création | Lecture seule |
| `Date de modification` | Dernière modification | Lecture seule |

---

# 6. Formations

## À quoi sert une formation ?

La formation représente le catalogue AcadéNice.

Elle sert à centraliser :

- le nom de la formation ;
- son niveau ;
- sa durée ;
- ses références RNCP ;
- ses compétences liées ;
- sa référence Filiz si besoin.

## Les champs de la fiche Formation

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Nom` | Nom de la formation | Utiliser le nom métier le plus clair |
| `Code formation` | Code interne de la formation | Très utile pour les promotions |
| `Active` | Formation active ou non | Décochez si la formation n'est plus utilisée |
| `Type de formation` | Nature de la formation | Alternance, initiale, courte |
| `Niveau` | Niveau de certification | Utiliser le niveau le plus juste |
| `Durée (heures)` | Durée totale de formation | Saisir uniquement le nombre d'heures |
| `Rythme` | Rythme pédagogique | Choisir le rythme défini |
| `Modalité` | Modalité pédagogique | Peut contenir plusieurs modalités |
| `Titre RNCP` | Intitulé officiel RNCP | À renseigner pour les formations certifiantes |
| `Code RNCP` | Référence RNCP | À renseigner si applicable |
| `Code NSF` | Référence NSF | À renseigner si applicable |
| `ID formation Filiz` | Identifiant de la formation dans Filiz | À renseigner uniquement si connu |
| `Modifier les informations Filiz` | Déverrouille l'ID technique | Réservé aux corrections ciblées |
| `Compétences` | Référentiel de compétences lié à la formation | À sélectionner si utile |
| `Pré requis` | Pré requis libres | Texte descriptif |
| `Compétences d'entrée` | Niveau attendu en entrée | Texte métier |
| `Compétences de sortie` | Compétences visées en sortie | Texte métier |
| `Public cible` | Public visé | Décrire le profil type |
| `Date de création` | Date de création | Lecture seule |
| `Date de modification` | Dernière modification | Lecture seule |

---

# 7. Promotions

## À quoi sert une promotion ?

Une promotion représente une session précise d'une formation.

Exemple :

- `DEV-2026`
- `ETDT-2025`

Elle sert à distinguer les cohortes par année et par période.

## Les champs de la fiche Promotion

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Nom` | Nom de la promotion | Suivre le format interne défini |
| `Formation` | Formation associée | Champ essentiel |
| `Date de début` | Début de la promotion | À renseigner précisément |
| `Date de fin` | Fin de la promotion | À renseigner précisément |
| `ID promotion Filiz` | Identifiant Filiz | Seulement si connu |
| `Modifier les informations Filiz` | Déverrouille l'ID Filiz | À utiliser seulement si nécessaire |
| `Date de création` | Date de création | Lecture seule |
| `Date de modification` | Dernière modification | Lecture seule |

---

# 8. Compétences

## À quoi sert une compétence ?

La compétence sert de référentiel commun.

Elle peut être liée à :

- un contact ;
- une formation ;
- une offre.

Cela permet :

- de décrire les profils ;
- d'identifier les compétences recherchées ;
- de structurer le matching.

## Les champs de la fiche Compétence

| Champ | Utilité | Comment l'utiliser |
|---|---|---|
| `Compétence` | Nom de la compétence | Utiliser un intitulé simple et clair |
| `Type` | Nature générale de la compétence | Technique, logiciel, soft skill, métier, langue, autre |
| `Catégorie` | Grande famille | Développement, graphisme, commerce, etc. |
| `Active` | Compétence active ou non | Décochez si elle ne doit plus être utilisée |
| `Description` | Définition libre | Optionnel, utile si le nom prête à confusion |
| `Date de création` | Date de création | Lecture seule |
| `Date de modification` | Dernière modification | Lecture seule |

---

# 9. Marketing - Les bases

## À quoi sert l'onglet Marketing ?

L'onglet `Marketing` sert à organiser des actions de communication.

On l'utilise quand on veut :

- regrouper des contacts ;
- préparer un envoi ;
- suivre une campagne ;
- garder une logique claire entre une audience et une action.

En version très simple :

- `Liste de diffusion` = le groupe de personnes ciblées ;
- `Campagne` = l'action menée vers ce groupe.

## Que trouve-t-on dans cet onglet ?

En général, vous y trouverez surtout :

- les `Campagnes` ;
- les `Listes de diffusion`.

Ces deux éléments fonctionnent ensemble.

## À quoi cela peut servir chez AcadéNice ?

Exemples simples :

- inviter des candidats à une réunion d'information ;
- relancer des entreprises ;
- envoyer une information à des alumni ;
- préparer une communication à un groupe précis de contacts.

## Ce qu'il faut retenir

- `Marketing` = communication organisée ;
- `Liste de diffusion` = les personnes ciblées ;
- `Campagne` = l'action de communication.

---

# 10. Marketing - Campagnes

## Qu'est-ce qu'une campagne ?

Une `campagne` représente une action de communication.

Exemples :

- `Invitation JPO Avril 2026`
- `Relance entreprises alternance`
- `Information rentrée candidats admis`

## À quoi sert la fiche Campagne ?

La fiche campagne sert à donner un cadre clair à une action.

Elle permet de savoir :

- quel est le sujet de l'action ;
- à qui elle s'adresse ;
- quand elle est menée ;
- si elle est encore en cours ou terminée.

## Comment la comprendre simplement ?

Une campagne ne contient pas forcément les personnes directement.

Son rôle est surtout de représenter :

- une intention ;
- une période ;
- un objectif de communication.

Les personnes visées sont souvent regroupées dans une ou plusieurs listes de diffusion.

## Exemple concret

Si AcadéNice organise une communication pour la rentrée :

- la `campagne` peut s'appeler `Information rentrée candidats admis` ;
- les `listes de diffusion` peuvent contenir les bons contacts selon le besoin.

## Bonne pratique

Quand vous créez une campagne :

- donnez-lui un nom clair ;
- utilisez une logique simple ;
- évitez les doublons ;
- créez une campagne seulement si une vraie action de communication existe.

---

# 11. Marketing - Listes de diffusion

## Qu'est-ce qu'une liste de diffusion ?

Une `liste de diffusion` est une liste de contacts regroupés pour une même communication.

Exemples :

- candidats à relancer ;
- alumni à contacter ;
- entreprises partenaires à informer ;
- candidats à inviter à un événement.

## À quoi sert la fiche Liste de diffusion ?

Elle sert à définir **qui fait partie du groupe**.

Elle ne décrit pas l'action.
Elle décrit les personnes ciblées.

## Comment la comprendre simplement ?

Si vous devez envoyer la même information à plusieurs personnes, la liste de diffusion sert à les rassembler au même endroit.

En version très simple :

- `Liste de diffusion` = qui reçoit ;
- `Campagne` = pourquoi on envoie.

## Exemple concret

Si vous voulez inviter plusieurs candidats à une réunion :

- vous créez une liste de diffusion `Candidats à inviter - Réunion info` ;
- vous y regroupez les bons contacts ;
- ensuite cette liste peut être utilisée dans une campagne.

## Bonne pratique

Quand vous créez une liste de diffusion :

- utilisez un nom clair ;
- ne mélangez pas plusieurs logiques dans une seule liste ;
- vérifiez les doublons ;
- gardez une liste facile à comprendre pour un collègue.

---

# 12. Documents

## À quoi sert l'onglet Documents ?

L'onglet `Documents` sert à stocker et retrouver des fichiers dans le CRM.

Exemples :

- un document administratif ;
- un modèle ;
- un contrat ;
- une pièce utile à partager ;
- un fichier de référence pour l'équipe.

## À quoi sert une fiche Document ?

Une fiche `Document` sert à donner un cadre clair à un fichier.

Elle permet de savoir :

- quel est le nom du document ;
- quel fichier est associé ;
- quel est son statut ;
- à quelle date il a été publié ;
- si le document est encore actif ou non.

## Les champs principaux

| Champ | À quoi il sert | Comment l'utiliser |
|---|---|---|
| `Nom` | Nom du document | Mettre un nom clair et compréhensible |
| `Fichier` | Fichier réellement stocké | Ajouter le bon fichier |
| `Statut` | État du document | Brouillon, actif, annulé, expiré |
| `Date de publication` | Date de mise à disposition | Vérifier qu'elle est correcte |
| `Date d'expiration` | Date de fin de validité si nécessaire | À renseigner seulement si utile |
| `Dossier` | Classement du document | Utiliser si un rangement existe |
| `Description` | Explication courte | Ajouter une précision si besoin |

## Comment comprendre cette page simplement ?

Le document est la **fiche de rangement du fichier**.

Le fichier seul ne suffit pas toujours.
La fiche permet de :

- le retrouver ;
- le classer ;
- comprendre à quoi il sert ;
- savoir s'il est encore valable.

## Exemple concret

Si vous devez ajouter un document utile à l'équipe :

1. créez une fiche `Document` ;
2. donnez-lui un nom clair ;
3. ajoutez le fichier ;
4. choisissez le bon statut ;
5. ajoutez une description si cela aide à comprendre son usage.

## Bonne pratique

Quand vous créez un document :

- utilisez un nom simple ;
- évitez les doublons ;
- vérifiez que vous ajoutez la bonne version ;
- gardez une logique de classement facile à reprendre par un collègue.

---

# 13. Activités - Emails

## À quoi sert l'onglet Emails ?

L'onglet `Emails` sert à suivre les emails envoyés ou reçus dans le CRM.

Il permet de :

- retrouver un échange ;
- voir qui a envoyé quoi ;
- garder une trace des communications importantes ;
- rattacher un email à une fiche si nécessaire.

## Comment comprendre cette page simplement ?

Un email dans Espo est une **trace d'échange**.

Cela permet à l'équipe de voir qu'un message existe, même si ce n'est pas elle qui l'a envoyé.

## À quoi faut-il faire attention ?

Quand vous regardez un email, vérifiez surtout :

- l'objet ;
- l'expéditeur ;
- le destinataire ;
- la date ;
- le contenu utile.

## Bonne pratique

- utilisez l'onglet `Emails` pour retrouver un échange ;
- ne créez pas d'email juste pour du rangement ;
- rattachez un email à une fiche seulement si cela aide vraiment au suivi.

---

# 14. Activités - Tâches

## À quoi sert l'onglet Tâches ?

L'onglet `Tâches` sert à suivre ce qu'il reste à faire.

Exemples :

- rappeler un candidat ;
- relancer une entreprise ;
- vérifier un dossier ;
- envoyer un document ;
- préparer un entretien.

## Comment comprendre cette page simplement ?

Une tâche est une **action à réaliser**.

Elle sert à ne pas oublier une action importante.

## Les informations utiles

Quand vous ouvrez une tâche, regardez surtout :

- le nom de la tâche ;
- la personne responsable ;
- la date d'échéance ;
- le statut ;
- le lien éventuel avec une fiche.

## Bonne pratique

- créez une tâche quand une action précise doit être faite ;
- utilisez un nom clair ;
- mettez à jour le statut quand l'action est terminée ;
- évitez de laisser des tâches anciennes sans suivi.

---

# 15. Activités - Appels

## À quoi sert l'onglet Appels ?

L'onglet `Appels` sert à garder une trace des appels téléphoniques.

Exemples :

- appel à un candidat ;
- appel à une entreprise ;
- appel de relance ;
- échange téléphonique important.

## Comment comprendre cette page simplement ?

Une fiche appel sert à savoir :

- qu'un appel a eu lieu ou est prévu ;
- avec qui ;
- quand ;
- et pourquoi.

## Quand l'utiliser ?

Utilisez cette page quand l'appel mérite d'être gardé dans le suivi.

Par exemple :

- un appel de qualification ;
- un échange important avec une entreprise ;
- un point de suivi sur une candidature.

## Bonne pratique

- donnez un titre simple à l'appel ;
- rattachez-le à la bonne fiche si nécessaire ;
- ajoutez un résumé utile si cela aide le collègue qui reprendra le dossier.

---

# 16. Activités - Rendez-vous

## À quoi sert l'onglet Réunions ?

L'onglet `Réunions` sert à suivre les rendez-vous et réunions planifiés.

Exemples :

- entretien candidat ;
- rendez-vous entreprise ;
- réunion interne ;
- point de suivi.

## Comment comprendre cette page simplement ?

Une réunion est un **événement prévu dans le temps**.

Elle sert à savoir :

- qui participe ;
- quand a lieu le rendez-vous ;
- et quel sujet est traité.

## Quand l'utiliser ?

Utilisez une réunion quand un rendez-vous doit être planifié et suivi.

Cela évite de garder l'information seulement dans un agenda personnel.

## Bonne pratique

- donnez un titre clair ;
- renseignez la bonne date ;
- rattachez la réunion à la bonne fiche si besoin ;
- mettez à jour les informations si le rendez-vous change.

---

# 17. Activités - Calendrier

## À quoi sert l'onglet Calendrier ?

L'onglet `Calendrier` sert à voir dans le temps :

- les réunions ;
- les appels ;
- certaines tâches selon le paramétrage.

## Comment comprendre cette page simplement ?

Le calendrier ne remplace pas les fiches.

Il sert surtout à avoir une **vue dans le temps** des actions prévues.

## À quoi cela sert au quotidien ?

Le calendrier permet de :

- voir ce qui est prévu aujourd'hui ;
- repérer les rendez-vous à venir ;
- vérifier qu'il n'y a pas de conflit ;
- mieux organiser sa journée ou sa semaine.

## Bonne pratique

- utilisez le calendrier pour piloter votre temps ;
- utilisez les fiches `Réunion`, `Appel` et `Tâche` pour stocker l'information détaillée ;
- ne considérez pas le calendrier comme un simple affichage : il dépend de la qualité des fiches créées.

---

# 18. Administration - Utilisateurs

## À quoi sert l'onglet Utilisateurs ?

L'onglet `Utilisateurs` sert à voir les personnes qui ont un accès au CRM.

Chaque utilisateur représente un compte de connexion.

Cela permet de savoir :

- qui peut se connecter ;
- qui travaille dans le CRM ;
- à qui une fiche ou une tâche peut être assignée.

## Comment comprendre cette page simplement ?

Un `Utilisateur` n'est pas un contact candidat ou entreprise.

C'est un **compte interne** utilisé pour travailler dans l'outil.

Exemples :

- un salarié AcadéNice ;
- un alternant interne ;
- un responsable ;
- un administrateur.

## À quoi faut-il faire attention ?

Quand vous consultez cette page, regardez surtout :

- le nom de l'utilisateur ;
- son statut actif ou non ;
- son équipe ;
- ses droits selon son rôle.

## Bonne pratique

- ne créez pas un utilisateur si la personne n'a pas besoin d'accéder au CRM ;
- ne confondez pas `Utilisateur` et `Contact` ;
- gardez des comptes propres et clairement nommés.

---

# 19. Administration - Équipes

## À quoi sert l'onglet Équipes ?

L'onglet `Équipes` sert à regrouper des utilisateurs.

Une équipe permet d'organiser le travail et la visibilité.

## Comment comprendre cette page simplement ?

Une équipe représente un **groupe interne de travail**.

Elle peut servir à :

- partager certaines fiches ;
- mieux répartir le suivi ;
- structurer l'organisation interne dans le CRM.

## Exemple simple

Une équipe peut représenter :

- l'équipe commerciale ;
- l'équipe pédagogique ;
- l'équipe administrative ;
- une équipe projet.

## Bonne pratique

- utilisez les équipes pour organiser le travail collectif ;
- ne créez pas trop d'équipes inutiles ;
- gardez des noms clairs et faciles à comprendre.

---

# 20. Administration - Calendriers des jours travaillés

## À quoi sert cet onglet ?

L'onglet `Calendriers des jours travaillés` sert à définir les jours ouvrés et non ouvrés.

Il permet au CRM de mieux comprendre :

- les jours de travail ;
- les jours fériés ;
- les périodes non travaillées.

## Comment comprendre cette page simplement ?

Ce n'est pas un agenda personnel.

C'est un **cadre de calendrier** utilisé par le système pour mieux gérer certaines logiques de temps.

## À quoi cela peut servir ?

Cela peut être utile pour :

- les calculs de délai ;
- certains rappels ;
- une meilleure lecture de l'activité dans le temps.

## Bonne pratique

- utilisez cet onglet seulement si vous savez pourquoi vous le consultez ;
- gardez une logique simple ;
- ne modifiez pas ces calendriers sans consigne claire.

---

# 21. Administration - Modèles d'email

## À quoi sert l'onglet Modèles d'email ?

L'onglet `Modèles d'email` sert à enregistrer des emails types.

Cela permet de réutiliser facilement un message déjà préparé.

## Comment comprendre cette page simplement ?

Un modèle d'email est un **texte prêt à l'emploi**.

Exemples :

- réponse à un candidat ;
- relance entreprise ;
- envoi d'information ;
- accusé de réception.

## À quoi cela sert au quotidien ?

Cela permet :

- de gagner du temps ;
- de garder une qualité d'écriture homogène ;
- d'éviter de réécrire les mêmes messages.

## Bonne pratique

- utilisez un objet clair ;
- gardez un ton professionnel ;
- mettez à jour les modèles si les pratiques changent ;
- évitez de multiplier les modèles très proches.

---

# 22. Administration - PDF Templates

## À quoi sert l'onglet PDF Templates ?

L'onglet `PDF Templates` sert à gérer des modèles de documents PDF.

Ces modèles permettent de produire des documents dans une forme standardisée.

## Comment comprendre cette page simplement ?

Un PDF Template est un **gabarit de document**.

Il sert à préparer un rendu identique pour plusieurs documents du même type.

## Exemples possibles

- document type ;
- export formalisé ;
- document administratif ;
- mise en page répétée.

## Bonne pratique

- considérez ces modèles comme des outils système ;
- ne les modifiez pas sans besoin clair ;
- utilisez-les surtout si vous savez qu'un document PDF standard doit être généré.

---

# 23. Administration - Importation

## À quoi sert l'onglet Importation ?

L'onglet `Importation` sert à faire entrer des données dans le CRM en lot.

Exemples :

- importer plusieurs contacts ;
- importer plusieurs organisations ;
- ajouter un jeu de données préparé dans un fichier.

## Comment comprendre cette page simplement ?

L'importation sert quand on veut créer ou mettre à jour **beaucoup de fiches à la fois**.

Ce n'est pas utile pour une saisie au cas par cas.

## À quoi faut-il faire attention ?

Un import mal préparé peut créer :

- des doublons ;
- des erreurs de données ;
- des fiches incomplètes ;
- des incohérences.

## Bonne pratique

- importer seulement si le fichier est propre ;
- vérifier les colonnes avant l'import ;
- éviter d'importer sans contrôle ;
- demander validation si le fichier a un doute ou un impact important.

---

# 24. Administration - Rôles et droits

## À quoi sert cette logique ?

Dans EspoCRM, tous les utilisateurs n'ont pas besoin d'avoir les mêmes droits.

La logique des rôles sert à :

- donner à chacun l'accès utile pour travailler ;
- éviter les erreurs ;
- protéger les données sensibles ;
- garder un CRM simple à utiliser.

## Principe simple

Un `rôle` définit ce qu'une personne peut faire dans le CRM.

Exemples :

- voir une fiche ;
- créer une fiche ;
- modifier une fiche ;
- supprimer une fiche.

Dans AcadéNice, les rôles sont définis par type d'usage, pas par nom de personne.

## Les rôles retenus

### `Admin CRM`

Ce rôle a tous les droits.

Il peut :

- voir ;
- créer ;
- modifier ;
- supprimer ;
- configurer le CRM ;
- gérer les imports et exports ;
- intervenir partout ;
- accéder aux comptes email, comptes externes, tickets, OpenAPI et webhooks.

### `Recrutement`

Ce rôle gère surtout :

- les contacts ;
- les organisations ;
- les offres ;
- les candidatures ;
- les contrats ;
- les compétences si une nouvelle compétence doit être ajoutée au référentiel ;
- les tickets entrants ;
- les comptes email.

### `Assistance pédagogique`

Ce rôle aide au suivi opérationnel.

Il peut intervenir sur :

- les contacts ;
- les organisations ;
- les candidatures ;
- les contrats ;
- une partie des offres ;
- les formations et promotions en création quand il faut compléter les référentiels ;
- les compétences en création quand une compétence manque ;
- les tickets entrants ;
- les comptes externes.

### `Marketing`

Ce rôle travaille surtout sur :

- les contacts en lecture ;
- les organisations en lecture ;
- les offres ;
- les campagnes ;
- les listes de diffusion ;
- les emails ;
- le calendrier ;
- les compétences en création si besoin pour le marketing ou une offre ;
- les comptes externes.

### `Développeur`

Ce rôle a surtout une visibilité de consultation.

Il peut lire :

- les contacts ;
- les organisations ;
- les offres ;
- les documents ;
- la base de connaissances ;
- les comptes externes.

### `Assistance technique`

Ce rôle intervient sur les outils techniques de fonctionnement du CRM.

Il peut agir sur :

- les utilisateurs ;
- les équipes ;
- les calendriers des jours travaillés ;
- les modèles d'email ;
- les PDF Templates ;
- l'importation ;
- la base de connaissances ;
- les comptes externes.

### `Automatisation`

Ce rôle est réservé aux robots et intégrations techniques.

Il sert à :

- accéder à OpenAPI ;
- utiliser les webhooks ;
- séparer clairement les accès techniques des accès humains.

## Matrice des droits

Légende :

- `L` = lecture
- `C` = création
- `M` = modification
- `S` = suppression
- `-` = pas d'accès

| Entité | Admin CRM | Recrutement | Assistance pédagogique | Marketing | Développeur | Assistance technique | Automatisation |
|---|---|---|---|---|---|---|---|
| Organisations | L/C/M/S | L/C/M | L/C/M | L | L | - | - |
| Contacts | L/C/M/S | L/C/M | L/C/M | L | L | - | - |
| Offres | L/C/M/S | L/C/M | L/M | L/C/M | L | - | - |
| Candidatures | L/C/M/S | L/C/M | L/C/M | - | - | - | - |
| Contrats | L/C/M/S | L/C/M | L/C/M | - | - | - | - |
| Tickets | L/C/M/S | L/C/M | L/C/M | - | - | - | - |
| Prospects | - | - | - | - | - | - | - |
| Formations | L/C/M/S | L | L/C/M | - | - | - | - |
| Promotions | L/C/M/S | L | L/C/M | - | - | - | - |
| Compétences | L/C/M/S | L/C | L/C | L/C | - | - | - |
| Documents | L/C/M/S | L/C/M | L/C/M | L | L | - | - |
| Base de connaissances | L/C/M/S | L | L | L | L | L/C/M | - |
| Campagnes | L/C/M/S | L/C/M | L/C/M | L/C/M | - | - | - |
| Listes de diffusion | L/C/M/S | L/C/M | L/C/M | L/C/M | - | - | - |
| Emails | L/C/M/S | L/C/M | L/C/M | L/C/M | - | - | - |
| Comptes Email | L/C/M | L/C/M | - | - | - | - | - |
| Comptes externes | L/C/M | L/C/M | L/C/M | L/C/M | L/C/M | L/C/M | - |
| OpenAPI | L/C/M | - | - | - | - | - | L/C/M |
| Webhooks | L/C/M | - | - | - | - | - | L/C/M |
| Flux globaux | L | - | - | - | - | - | - |
| Tâches | L/C/M/S | L/C/M | L/C/M | L | - | - | - |
| Appels | L/C/M/S | L/C/M | L/C/M | - | - | - | - |
| Rendez-vous | L/C/M/S | L/C/M | L/C/M | - | - | - | - |
| Calendrier | L/C/M/S | L/C/M | L/C/M | L/C/M | - | - | - |
| Devise | - | - | - | - | - | - | - |
| Utilisateurs | L/C/M/S | - | - | - | - | L/C/M | - |
| Équipes | L/C/M/S | - | - | - | - | L/C/M | - |
| Calendriers des jours travaillés | L/C/M/S | - | - | - | - | L/C/M | - |
| Modèles d’email | L/C/M/S | L | - | L/C/M | - | L/C/M | - |
| PDF Templates | L/C/M/S | - | - | - | - | L/C/M | - |
| Importation | L/C/M/S | - | - | - | - | L/C/M | - |

Notes importantes :

- `Comptes Email` et `Comptes externes` sont des accès personnels : un utilisateur agit sur ses propres comptes, pas sur ceux des autres.
- `OpenAPI` et `Webhooks` sont des accès techniques : la ligne indique un accès activé pour la configuration technique, pas un usage métier quotidien.
- `Flux globaux` est réservé à `Admin CRM` : il peut être utile pour le pilotage global, mais il apporte trop de bruit pour les autres rôles.
- `Devise` est désactivé pour tous les rôles : la gestion multi-devise n'est pas utilisée dans notre fonctionnement.
- `Activités` peut rester `non-défini` dans Espo : c'est un conteneur générique. Ce sont les modules concrets (`Emails`, `Tâches`, `Appels`, `Rendez-vous`, `Calendrier`) qui portent les vrais droits métier.

## Règles communes

Les règles suivantes s'appliquent à toute l'organisation :

- l'export est réservé à l'admin ;
- la suppression est réservée à l'admin ;
- la configuration du CRM est réservée à l'admin ;
- les rôles doivent rester simples et lisibles ;
- `Prospects` n'est pas utilisé dans l'organisation ;
- le rôle `Automatisation` est réservé aux robots et intégrations.

## Ce qu'il faut retenir

- un rôle ne dépend pas du nom d'une personne ;
- un rôle dépend de ce qu'une personne doit faire dans le CRM ;
- mieux vaut quelques rôles clairs que beaucoup de rôles compliqués ;
- l'objectif est de donner le bon niveau d'accès sans alourdir le travail.

---

# 25. Comment travailler proprement au quotidien ?

## Quand vous recevez une nouvelle entreprise

1. Chercher si l'organisation existe.
2. Si elle n'existe pas, créer l'organisation.
3. Ajouter ensuite le ou les contacts liés.
4. Créer l'offre si un besoin existe.

## Quand vous recevez un nouveau candidat

1. Chercher si le contact existe déjà.
2. Si non, créer le contact.
3. Remplir au minimum :
   - identité ;
   - statut ;
   - formation visée ;
   - source ;
   - compétences utiles ;
   - coordonnées.
4. Mettre le bon statut candidat.

## Quand vous proposez un candidat sur une offre

1. Ouvrir l'offre.
2. Créer une candidature.
3. Renseigner le candidat, l'offre, le statut et la priorité.
4. Mettre à jour `Date d'envoi du CV` dès l'envoi.
5. Faire évoluer le statut à chaque étape.

## Quand une candidature avance vers la signature

1. Vérifier que la candidature est bonne.
2. Créer le contrat.
3. Renseigner la promotion.
4. Mettre le bon statut contrat.
5. Utiliser Filiz seulement si le dossier passe réellement par Filiz.

---

# 26. Ce qu'il faut éviter

## Les erreurs les plus fréquentes

- créer une nouvelle fiche alors que l'existante est déjà là ;
- utiliser un mauvais statut ;
- mettre des commentaires trop longs ou inutiles ;
- remplir des champs techniques sans raison ;
- laisser une fiche sans organisation ou sans formation alors que l'information est connue ;
- modifier la configuration du CRM alors qu'on est censé l'utiliser.

## Ce qu'il vaut mieux faire

- vérifier avant de créer ;
- être rigoureux sur les statuts ;
- être sobre dans les commentaires ;
- privilégier les champs structurés ;
- mettre à jour les fiches au fil de l'eau ;
- garder une logique commune entre collègues.

---

# 27. Questions fréquentes

## Je vois des champs techniques ou des informations Filiz, dois-je les remplir ?

Non, sauf si vous savez exactement pourquoi vous le faites.
Dans la majorité des cas, les champs Filiz servent au suivi technique, pas à la saisie courante.

## J'ai un accès administrateur, puis-je modifier la structure du CRM ?

Non, pas dans le cadre d'un usage normal.
Un accès admin ne veut pas dire qu'il faut changer les champs, les vues ou les paramètres.

## Que faire si je ne sais pas quel statut choisir ?

Choisir le statut qui décrit le mieux la situation réelle au moment où vous enregistrez la fiche.
Si vous hésitez souvent, il faut en parler pour harmoniser les pratiques d'équipe.

## Le flux sert à quoi ?

Le flux permet de voir l'historique récent d'une fiche :

- qui a créé la fiche ;
- quels champs ont été modifiés ;
- à quel moment.

Il ne remplace pas les champs de suivi.

---

# 28. Résumé ultra-court

## Si vous retenez seulement l'essentiel

- `Organisation` = structure
- `Contact` = personne
- `Offre` = besoin de recrutement
- `Candidature` = candidat positionné sur une offre
- `Contrat` = suite administrative
- `Formation` = catalogue
- `Promotion` = session
- `Compétence` = référentiel commun

Et surtout :

- on cherche avant de créer ;
- on met le bon statut ;
- on remplit les champs utiles ;
- on évite les doublons ;
- on n'utilise pas l'accès admin pour reconfigurer le CRM.

---

# 29. Conclusion

Le CRM doit devenir un outil simple de travail collectif.

S'il est bien utilisé, il permet à AcadéNice de :

- mieux suivre les candidats ;
- mieux suivre les entreprises ;
- mieux piloter les offres et les candidatures ;
- mieux sécuriser les contrats ;
- mieux partager l'information dans l'équipe.

L'objectif n'est pas de tout remplir.
L'objectif est de **mieux travailler ensemble avec une information propre, cohérente et facile à retrouver**.
