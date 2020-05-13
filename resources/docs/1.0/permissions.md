# Permissions Api

---

-   [Routes](#permissions-routes)
-   [Table](#permissions-table)
-   [Store Batches](#permissions-batches)
-   [Delete All Permissions](#permissions-destroy)

<a name="permissions-routes"></a>

## Permissions Routes

Base Address: http://localhost/api/v1/permissions

| Method | URL                         | Action       | Description                  |
| ------ | --------------------------- | ------------ | ---------------------------- |
| GET    | /api/v1/permissions         | index        | Company List                 |
| POST   | /api/v1/permissions/batches | storeBatches | Store Batches of Permissions |
| DELETE | /api/v1/permissions/destroy | destroyAll   | Destroy All Permissions      |

<a name="permissions-table"></a>

### Permissions Table

| Field       | Type         | Description |
| ----------- | ------------ | ----------- |
| id          | bigIncrement |             |
| code        | integer      | nullable    |
| name        | string(30)   |             |
| description | string(100)  |             |
| created_at  | timestamp    | auto        |
| updated_at  | timestamp    | auto        |

<a name="permissions-batches"></a>

### Store Batches of Permissions ( /api/v1/permissions/batches )

```javascript
{
  "permissions": [
    {
        "name": "PLANODIRETOR",
        "code": 223,
        "description": "Acesso ao Plano Diretor",
    },
    { ... }
  ]
}

```

#### Return of Store Batches

```javascript
{
  "result": "ok"
}
```

<a name="permissions-destroy"></a>

### Delete All Permissions ( /api/v1/permissions/destroy )

```javascript
{
}
```

#### Return of Delete All

```javascript
{
  "result": "ok"
}
```

---
