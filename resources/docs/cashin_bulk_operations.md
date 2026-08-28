# CashIn Bulk Operations Documentation

## Overview
These endpoints allow bulk operations on CashIn records for managing multiple encaissements simultaneously.

## Endpoints

### 1. Bulk Trash (Soft Delete)
**POST** `/api/cashins/trash`

Met plusieurs encaissements à la corbeille (soft delete).

#### Request Body
```json
{
  "ids": [1, 2, 3]
}
```

#### Validation Rules
- `ids`: Required, array
- `ids.*`: Integer, must exist in `cash_ins` table

#### Response
- **Success**: 204 No Content
  ```json
  {
    "success": true,
    "data": [],
    "message": "Encaissements mis à la corbeille avec succès"
  }
  ```

- **Error**: 500 Internal Server Error
  ```json
  {
    "success": false,
    "message": "Une erreur est survenue",
    "data": null,
    "error": "Detailed error message"
  }
  ```

---

### 2. Bulk Restore
**POST** `/api/cashins/restore`

Restaure des encaissements précédemment mis à la corbeille.

#### Request Body
```json
{
  "ids": [1, 2, 3]
}
```

#### Validation Rules
- `ids`: Required, array
- `ids.*`: Integer, must exist in `cash_ins` table (including trashed records)

#### Response
- **Success**: 200 OK
  ```json
  {
    "success": true,
    "data": [],
    "message": "Encaissements restaurés avec succès"
  }
  ```

- **Error**: 500 Internal Server Error
  ```json
  {
    "success": false,
    "message": "Une erreur est survenue",
    "data": null,
    "error": "Detailed error message"
  }
  ```

---

### 3. Bulk Delete (Hard Delete)
**POST** `/api/cashins/delete`

Supprime définitivement des encaissements (hard delete). Cette action est irréversible.

#### Request Body
```json
{
  "ids": [1, 2, 3]
}
```

#### Validation Rules
- `ids`: Required, array
- `ids.*`: Integer, must exist in `cash_ins` table (including trashed records)

#### Response
- **Success**: 204 No Content
  ```json
  {
    "success": true,
    "data": [],
    "message": "Encaissements supprimés définitivement avec succès"
  }
  ```

- **Error**: 500 Internal Server Error
  ```json
  {
    "success": false,
    "message": "Une erreur est survenue",
    "data": null,
    "error": "Detailed error message"
  }
  ```

## Security & Logging
- All operations require authentication through the API middleware
- All operations are logged with:
  - Operation type (trash, restore, delete)
  - List of affected IDs
  - Success/failure status
  - Error details if applicable

## Usage Flow
1. **Trash**: Use `/cashins/trash` to move items to trash
2. **Restore**: Use `/cashins/restore` to recover trashed items
3. **Delete**: Use `/cashins/delete` for permanent removal

## Notes
- Bulk operations improve performance compared to individual API calls
- All operations use database transactions for data consistency
- The `CashInArchiveRequest` validates that all IDs exist before processing
- Hard delete (`/cashins/delete`) cannot be undone - use with caution
