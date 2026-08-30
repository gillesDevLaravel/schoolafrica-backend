# Audit du projet SchoolAfrica Backend

Date de l'audit: 2026-08-29  
Projet audite: backend Laravel situe dans `/home/foyem/Documents/PROJETS/schoolafrica-backend`

## Resume executif

Le projet est un backend Laravel 7 avec une base de code large:

- 301 migrations
- 124 modeles Eloquent
- 131 controleurs
- 103 fichiers de tests
- API principale concentree dans `routes/api.php`

Le probleme principal n'est pas la syntaxe PHP: toutes les migrations passent `php -l`. Le probleme vient surtout de la logique des migrations:

1. Plusieurs migrations creent des contraintes de cle etrangere vers des tables qui ne sont pas encore creees.
2. Beaucoup de colonnes de cle etrangere sont declarees en `integer()->unsigned()` alors que les tables referencees utilisent souvent `$table->id()` ou `bigIncrements()`, donc `unsignedBigInteger`.
3. Certaines migrations modifient des colonnes avec `change()` ou `renameColumn()`, ce qui depend fortement de l'etat exact de la base.
4. Certaines migrations sont liees a une deuxieme connexion `mysql2`.
5. Il existe des incoherences de noms de table et des rollbacks incomplets.

Conclusion: tu es oblige de lancer certaines migrations une par une parce que le schema n'est pas migrable proprement depuis zero en une seule passe. Laravel execute les migrations par ordre chronologique du nom de fichier. Si une migration cree une contrainte vers une table qui n'existe pas encore, ou si le type de colonne ne correspond pas au type de la colonne referencee, MySQL bloque l'execution.

## Stack observee

- Framework: Laravel `^7.29`
- PHP supporte par `composer.json`: `^7.2.5|^8.0`
- Auth API: Laravel Sanctum
- Permissions: Spatie Laravel Permission
- PDF: DomPDF, FPDF, FPDI
- Paiement: Orange Money / MTN via controleurs applicatifs
- Base par defaut: MySQL
- Deuxieme connexion: `mysql2`

## Pourquoi les migrations bloquent en execution globale

### 1. Ordre chronologique incompatible avec les cles etrangeres

Laravel lance les migrations dans l'ordre alphabetique des timestamps. Or certaines migrations anciennes creent deja des cles etrangeres vers des tables creees plus tard.

Exemples critiques:

- `database/migrations/2014_10_12_000000_create_users_table.php`
  - Reference `matter`, creee seulement par `2023_05_10_125827_create_matter_table.php`
  - Reference `levels`, creee seulement par `2023_04_24_161533_create_levels_table.php`
  - Reference `option_level`, creee seulement par `2023_04_24_161716_create_option_level_table.php`
  - Reference `schools`, creee seulement par `2023_04_24_160305_create_schools_table.php`
  - Reference `section`, creee seulement par `2023_05_10_105241_create_section_table.php`
  - Reference `cycles`, creee seulement par `2023_04_24_161145_create_cycles_table.php`
  - Reference `classes`, creee seulement par `2023_04_24_161843_create_classes_table.php`

Impact: sur une base vide, la migration `users` essaie de creer des contraintes vers des tables inexistantes. MySQL refuse la creation.

Autres exemples:

- `2023_04_22_225552_create_establishments_table.php` reference `packages`, creee plus tard par `2023_04_24_160447_create_packages_table.php`
- `2023_04_24_161533_create_levels_table.php` reference `section`, creee plus tard par `2023_05_10_105241_create_section_table.php`
- `2023_04_24_161716_create_option_level_table.php` reference `section`, creee plus tard
- `2023_04_24_161843_create_classes_table.php` reference `section`, creee plus tard
- `2023_04_24_161929_create_transactions_table.php` reference `invoices`, `section`, `pensions`, `tranches`, creees plus tard
- `2023_05_10_140154_create_assessments_table.php` reference `type_evaluation` et `assessment_type`, creees plus tard
- `2023_05_10_142142_create_ratings_table.php` reference `assessment_type` et `type_evaluation`, creees plus tard
- `2023_05_28_221824_create_absences_table.php` reference `assessment_type`, creee plus tard
- `2023_06_19_165154_create_assessment_type_table.php` reference `trimestre`, creee plus tard

### 2. Types incompatibles entre cles etrangeres et colonnes referencees

Dans Laravel 7, `$table->id()` cree un `BIGINT UNSIGNED`. Beaucoup de migrations declarent les colonnes FK en `integer()->unsigned()`, donc `INT UNSIGNED`.

Exemple dans `2014_10_12_000000_create_users_table.php`:

- `$table->id()` cree `users.id` en `BIGINT UNSIGNED`
- `$table->integer('idParent')->unsigned()` cree `idParent` en `INT UNSIGNED`
- La contrainte `$table->foreign('idParent')->references('id')->on('users')` peut echouer car les types ne correspondent pas strictement

Ce pattern se repete dans beaucoup de tables: `idSchool`, `idSection`, `idClasse`, `idLevel`, `idStudent`, `idTeacher`, etc.

Impact: meme si tu corriges l'ordre des migrations, MySQL peut encore refuser les contraintes avec une erreur de type `errno 150`, `Foreign key constraint is incorrectly formed`, ou equivalent.

### 3. Tables pivots creees trop tot

La migration `2014_10_12_000000_create_users_table.php` cree aussi:

- `matter_has_user`
- `classe_has_user`

Ces tables pivot referencent `matter` et `classes`, qui sont creees plusieurs annees plus tard dans l'ordre des migrations.

Impact: meme si la table `users` etait creee sans ses FKs, la meme migration peut echouer sur les pivots.

### 4. Une migration cible une mauvaise table au rollback

Dans `2024_07_31_110924_add_id_tranche_to_module_table.php`:

- `up()` modifie `modules`
- `down()` modifie `module`

Or la table creee dans le projet est `modules`, pas `module`.

Impact: les rollbacks ou refresh peuvent echouer, et la base peut rester dans un etat partiellement migre.

### 5. Timestamp duplique

Deux migrations ont le meme timestamp:

- `2026_03_11_000001_create_meeting_reports_table.php`
- `2026_03_11_000001_modify_explanation_requests_table.php`

Laravel trie ensuite par nom de fichier complet, donc ce n'est pas toujours fatal. Mais c'est un signal de mauvaise hygiene de migrations: l'ordre exact devient moins lisible et plus fragile.

### 6. Migrations dependantes de l'etat de la base

Plusieurs migrations utilisent:

- `->change()`
- `renameColumn()`
- `dropUnique()`
- `dropColumn()`

Exemples:

- `2025_03_06_103839_change_id_section_nullable_on_many_tables.php`
- `2025_03_07_091447_update_id_section_fields_nullable_in_many_tables.php`
- `2025_07_08_090444_rename_and_change_id_scan_receipt_in_pension_users_and_fee_user_table.php`
- `2025_09_18_102046_remove_unique_constraint_from_idtransaction_on_fee_user_and_pension_users.php`
- `2025_12_30_083600_update_litiges_table_structure.php`
- `2026_04_15_142400_increase_reasons_length_on_invoices_table.php`

Impact: ces migrations marchent seulement si la colonne/index existe exactement sous le nom attendu, avec le type attendu. Sur une base restauree partiellement, elles cassent facilement.

### 7. Deux connexions de base dans les migrations

Des migrations utilisent explicitement `Schema::connection('mysql2')`:

- `2023_07_13_181435_create_key_table.php`
- `2024_08_05_120436_create_mobile_build_versions_table.php`
- `2024_08_20_115323_add_verified_to_mobile_build_versions_table.php`

Impact: un `php artisan migrate` global ne touche pas seulement la base principale. Il exige aussi que `mysql2` soit correctement configuree et accessible. Si `DB_CONNECTION_HOME`, `DB_HOST_HOME`, `DB_DATABASE_HOME`, etc. ne sont pas bons, la migration globale peut echouer alors que la base principale est correcte.

## Causes directes du besoin de lancer les migrations une par une

Tu lances probablement les migrations une par une pour contourner ces blocages:

1. Tu executes d'abord les tables parents (`schools`, `section`, `levels`, `classes`, etc.).
2. Ensuite seulement tu relances les migrations qui ajoutent ou creent des contraintes vers elles.
3. Quand une migration `change()` ou `renameColumn()` casse, tu l'isoles, tu ajustes l'etat de la base, puis tu continues.
4. Les migrations `mysql2` peuvent forcer un traitement separe si la deuxieme base n'est pas prete.

Ce n'est pas un comportement normal attendu de Laravel. Une base saine doit pouvoir faire:

```bash
php artisan migrate:fresh
php artisan migrate
```

sans intervention manuelle, au moins dans un environnement local ou CI.

## Correction recommandee pour les migrations

### Priorite 1: rendre le schema migrable depuis zero

Approche conseillee:

1. Creer les tables sans contraintes circulaires ou tardives.
2. Creer toutes les tables parents avant les tables enfants.
3. Ajouter les contraintes de cles etrangeres dans des migrations separees placees apres toutes les creations de tables.
4. Remplacer les FK `integer()->unsigned()` par `foreignId()` ou `unsignedBigInteger()` quand la colonne referencee est `$table->id()` ou `bigIncrements()`.
5. Corriger les rollbacks incomplets et les mauvais noms de table.

Pour une base deja en production, il ne faut pas renommer massivement les anciennes migrations sans strategie. Il vaut mieux:

- creer une nouvelle migration de consolidation/correction;
- ajouter des guards `Schema::hasTable()` / `Schema::hasColumn()` seulement pour les migrations de correction;
- documenter un chemin de migration propre pour staging et production;
- tester sur une copie de la base.

### Priorite 2: corriger les timestamps et rollbacks

- Donner un timestamp unique a `2026_03_11_000001_modify_explanation_requests_table.php`
- Corriger `Schema::table('module')` en `Schema::table('modules')` dans le rollback de `2024_07_31_110924_add_id_tranche_to_module_table.php`
- Dans `2023_04_22_225552_create_establishments_table.php`, le `down()` devrait supprimer `establishments_has_users` avant `establishments`

### Priorite 3: extraire les contraintes problematiques

Les FKs de `users` vers `schools`, `section`, `levels`, `classes`, `cycles`, `matter`, `option_level` doivent etre ajoutees apres creation de ces tables. Sinon `users` ne peut pas etre la premiere table metier tout en dependant de presque tout le schema scolaire.

## Audit securite

### Secrets dans le code

Constats:

- `config/database.php` contient des valeurs par defaut sensibles pour MySQL.
- `.env` existe dans le dossier local du projet.
- Des secrets de paiement sont codes en dur dans `app/Http/Controllers/MtnPaymentController.php`.
- `app/Http/Controllers/OrangeApiController.php` contient aussi des credentials et cles de paiement en dur.
- `app/Http/Controllers/MobileBuildVersionController.php` contient une cle d'acces en dur.

Risques:

- fuite d'identifiants;
- reutilisation de secrets en production;
- compromission des paiements;
- impossibilite de rotation propre des cles.

Corrections:

- deplacer tous les secrets dans `.env`;
- ne jamais mettre de vraie valeur sensible en valeur par defaut dans `config/*.php`;
- regenerer/rotater les cles deja exposees;
- verifier que `.env` n'est pas suivi par Git;
- mettre uniquement des placeholders dans `.env.example`.

### Donnees sensibles exposees dans les selections

Des controleurs selectionnent parfois `users.password` dans des requetes de listing ou de documents.

Risque: meme hashe, le password ne doit pas sortir dans les couches de presentation/API/document.

Correction: supprimer `users.password` des `select()` applicatifs, sauf besoin interne tres controle.

## Audit API

`routes/api.php` contient plus de 900 lignes de routes, avec la majorite des endpoints dans un seul groupe `auth:sanctum`.

Constats:

- beaucoup d'endpoints utilisent `POST` pour lister (`users`, `rolesall`, `classesall`, etc.);
- conventions REST inconsistantes (`trash`, `delete`, `destroy`, `restore`, suffixes `all`);
- routage centralise dans un fichier devenu difficile a maintenir;
- peu de separation visible par domaine fonctionnel.

Risques:

- surface API difficile a securiser finement;
- duplication de patterns;
- documentation et tests plus fragiles;
- regressions lors des ajouts.

Corrections:

- separer les routes par domaine (`routes/api/school.php`, `finance.php`, `hr.php`, etc.) ou par fichiers inclus;
- standardiser les noms d'endpoints;
- appliquer des policies/middlewares par domaine et action;
- conserver les routes historiques si l'application mobile/front en depend, mais introduire progressivement des alias propres.

## Audit architecture et qualite code

Constats:

- Beaucoup de logique metier semble etre dans les controleurs.
- Certains services existent (`app/Services`), mais l'usage n'est pas encore systematique.
- Les noms de tables et colonnes melangent francais, anglais, singulier, pluriel, camelCase et snake_case.
- Certaines tables utilisent des noms singuliers (`matter`, `section`, `trimestre`, `fee_user`) alors que d'autres sont plurielles.
- Plusieurs soft deletes sont implementes manuellement avec `deleted`, `deleted_by`, puis parfois avec `deleted_at`.

Risques:

- maintenance lente;
- bugs de relation Eloquent;
- migrations difficiles a raisonner;
- code plus fragile quand on ajoute une fonctionnalite.

Corrections:

- definir une convention schema cible;
- documenter les exceptions historiques;
- pousser les regles metier hors des controleurs vers services/actions;
- uniformiser les soft deletes avec `deleted_at` quand possible;
- ajouter des casts et relations explicites dans les modeles critiques.

## Audit tests

Le projet contient 103 tests, ce qui est positif. Mais `phpunit.xml` force `DB_CONNECTION=mysql`, donc les tests dependent d'une base MySQL disponible.

Constats:

- pas de base SQLite memoire activee;
- `DB_CONNECTION_HOME` / `mysql2` commente dans `phpunit.xml`;
- les migrations touchant `mysql2` peuvent casser un run de tests ou de migrations si la deuxieme connexion n'existe pas.

Risques:

- tests non reproductibles sur une machine neuve;
- CI plus fragile;
- impossible de valider rapidement une migration propre.

Corrections:

- creer une configuration de test isolee;
- ajouter un test minimal `migrate:fresh` sur une base temporaire;
- decider si `mysql2` doit etre mockee, separee, ou exclue en test;
- rendre les migrations compatibles avec un environnement CI.

## Plan de correction propose

### Phase 1: diagnostic reproductible

1. Creer une base locale vide.
2. Lancer `php artisan migrate:fresh --pretend` puis `php artisan migrate:fresh`.
3. Noter la premiere erreur exacte MySQL.
4. Corriger dans l'ordre les migrations bloquantes.
5. Repeter jusqu'a migration complete.

### Phase 2: stabilisation des migrations

1. Corriger les FKs de `users` en les sortant dans une migration plus tardive.
2. Corriger les types FK `INT` vs `BIGINT`.
3. Corriger les migrations avec table inexistante ou mauvais rollback.
4. Ajouter des guards seulement pour les migrations de correction.
5. Tester rollback/refresh sur base de test.

### Phase 3: securite

1. Retirer tous les secrets du code.
2. Rotater les cles deja exposees.
3. Nettoyer `.env.example`.
4. Verifier l'historique Git si les secrets ont deja ete commits.

### Phase 4: dette API et metier

1. Decouper `routes/api.php`.
2. Extraire la logique metier des gros controleurs.
3. Standardiser les endpoints futurs.
4. Ajouter des tests autour des modules critiques: paiement, inscription, pension, frais, bulletins.

## Verification effectuee

Commandes executees pendant l'audit:

```bash
find database/migrations -maxdepth 1 -type f -name '*.php' | sort | wc -l
find database/migrations -maxdepth 1 -type f -name '*.php' -print0 | xargs -0 -n1 php -l
rg "Schema::connection" database/migrations -n
rg "Schema::table\\('module'|Schema::table\\('modules'|Schema::create\\('modules'" database/migrations -n
```

Resultats:

- 301 migrations detectees.
- Aucune erreur de syntaxe PHP detectee dans les migrations.
- Plusieurs problemes d'ordre de creation/references detectes.
- Plusieurs migrations multi-connexion detectees.
- Une incoherence `modules` / `module` detectee.

## Decision technique recommandee

Le bon objectif n'est pas de continuer a lancer les migrations une par une. C'est de rendre le projet capable de reconstruire son schema automatiquement depuis zero.

La premiere correction a traiter est `2014_10_12_000000_create_users_table.php`, car elle depend de nombreuses tables creees apres elle. Tant que cette migration contient directement toutes ces contraintes, le projet restera fragile sur une base vide.
