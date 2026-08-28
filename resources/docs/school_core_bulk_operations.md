# School Core Tables Bulk Operations Documentation

## Overview
These endpoints allow bulk operations (trash/restore/delete) on school core tables using Laravel SoftDeletes.

## Common Request Body
```json
{
  "ids": [1, 2, 3]
}
```

## Common Validation Rules
- `ids`: Required, array
- `ids.*`: Integer, must exist in the target table

## Endpoints

### Establishments

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/establishments/trash`

Met plusieurs établissements à la corbeille (soft delete).

#### Validation Rules
- `ids`: Required, array
- `ids.*`: Integer, must exist in `establishments` table

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/establishments/restore`

Restaure des établissements précédemment mis à la corbeille.

#### Validation Rules
- `ids`: Required, array
- `ids.*`: Integer, must exist in `establishments` table (including trashed records)

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/establishments/delete`

Supprime définitivement des établissements (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids`: Required, array
- `ids.*`: Integer, must exist in `establishments` table (including trashed records)

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Schools

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/schools/trash`

Met plusieurs écoles à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `schools`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/schools/restore`

Restaure des écoles précédemment mises à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `schools`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/schools/delete`

Supprime définitivement des écoles (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `schools`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Campus

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/campus/trash`

Met plusieurs campus à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `campus`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/campus/restore`

Restaure des campus précédemment mis à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `campus`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/campus/delete`

Supprime définitivement des campus (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `campus`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Sections

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/sections/trash`

Met plusieurs sections à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `section`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/sections/restore`

Restaure des sections précédemment mises à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `section`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/sections/delete`

Supprime définitivement des sections (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `section`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Cycles

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/cycles/trash`

Met plusieurs cycles à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `cycles`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/cycles/restore`

Restaure des cycles précédemment mis à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `cycles`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/cycles/delete`

Supprime définitivement des cycles (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `cycles`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Levels

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/levels/trash`

Met plusieurs niveaux à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `levels`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/levels/restore`

Restaure des niveaux précédemment mis à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `levels`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/levels/delete`

Supprime définitivement des niveaux (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `levels`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Option Levels

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/optionlevels/trash`

Met plusieurs options de niveau à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `option_level`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/optionlevels/restore`

Restaure des options de niveau précédemment mises à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `option_level`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/optionlevels/delete`

Supprime définitivement des options de niveau (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `option_level`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Classes

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/classes/trash`

Met plusieurs classes à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `classes`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/classes/restore`

Restaure des classes précédemment mises à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `classes`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/classes/delete`

Supprime définitivement des classes (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `classes`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Matters

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/matters/trash`

Met plusieurs matières à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `matter`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/matters/restore`

Restaure des matières précédemment mises à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `matter`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/matters/delete`

Supprime définitivement des matières (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `matter`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Matter Groups

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/mattergroups/trash`

Met plusieurs groupes de matières à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `matter_group`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/mattergroups/restore`

Restaure des groupes de matières précédemment mis à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `matter_group`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/mattergroups/delete`

Supprime définitivement des groupes de matières (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `matter_group`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Assessment Types

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/assessmenttypes/trash`

Met plusieurs types d'évaluation à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `assessment_type`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/assessmenttypes/restore`

Restaure des types d'évaluation précédemment mis à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `assessment_type`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/assessmenttypes/delete`

Supprime définitivement des types d'évaluation (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `assessment_type`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Trimestres

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/trimestres/trash`

Met plusieurs trimestres à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `trimestre`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/trimestres/restore`

Restaure des trimestres précédemment mis à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `trimestre`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/trimestres/delete`

Supprime définitivement des trimestres (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `trimestre`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Type Requêtes

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/typerequetes/trash`

Met plusieurs types de requêtes à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `type_requetes`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/typerequetes/restore`

Restaure des types de requêtes précédemment mis à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `type_requetes`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/typerequetes/delete`

Supprime définitivement des types de requêtes (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `type_requetes`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Books

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/books/trash`

Met plusieurs livres à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `books`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/books/restore`

Restaure des livres précédemment mis à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `books`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/books/delete`

Supprime définitivement des livres (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `books`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

### Locations

#### 1. Bulk Trash (Soft Delete)
**POST** `/api/locations/trash`

Met plusieurs locations à la corbeille (soft delete).

#### Validation Rules
- `ids.*`: must exist in `locations`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

---

#### 2. Bulk Restore
**POST** `/api/locations/restore`

Restaure des locations précédemment mises à la corbeille.

#### Validation Rules
- `ids.*`: must exist in `locations`

#### Response
- **Success**: 200 OK
- **Error**: 500 Internal Server Error

---

#### 3. Bulk Delete (Hard Delete)
**POST** `/api/locations/delete`

Supprime définitivement des locations (hard delete). Cette action est irréversible.

#### Validation Rules
- `ids.*`: must exist in `locations`

#### Response
- **Success**: 204 No Content
- **Error**: 500 Internal Server Error

## Security & Logging
- All operations require authentication through the API middleware
- All operations are logged with:
  - Operation type (trash, restore, delete)
  - List of affected IDs
  - Success/failure status
  - Error details if applicable

## Notes
- Hard delete (`/delete`) cannot be undone - use with caution
- Some resources may also keep legacy flags (e.g. `deleted`, `deleted_by`) in sync, depending on existing code conventions
