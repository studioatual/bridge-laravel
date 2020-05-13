# Companies Users Permissions Api

---

-   [Routes](#companies_users_permissions-routes)
-   [Table](#companies_users_permissions-table)
-   [Store Batches](#companies_users_permissions-batches)
-   [Delete All Permissions](#companies_users_permissions-destroy)

<a name="companies_users_permissions-routes"></a>

## Companies Users Permissions Routes

Base Address: http://localhost/api/v1/companies_users_permissions

| Method | URL                                         | Action       | Description                        |
| ------ | ------------------------------------------- | ------------ | ---------------------------------- |
| GET    | /api/v1/companies_users_permissions         | index        | Company List                       |
| POST   | /api/v1/companies_users_permissions/batches | storeBatches | Store Batches of Users Permissions |
| DELETE | /api/v1/companies_users_permissions/destroy | destroyAll   | Destroy All Users Permissions      |

<a name="companies_users_permissions-table"></a>

### Companies Users Permissions Table

| Field         | Type         | Description |
| ------------- | ------------ | ----------- |
| company_id    | bigIncrement |             |
| user_id       | bigIncrement |             |
| permission_id | bigIncrement |             |

<a name="companies_users_permissions-batches"></a>

### Store Batches of Users Permissions ( /api/v1/companies_users_permissions/batches )

```javascript
{
  "companies": [
    {
        "company": "36.052.584/0001-96",
        "user": "935.027.490-60",
        "permission": "PLANODIRETOR",
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

<a name="companies_users_permissions-destroy"></a>

### Delete All Users Permissions ( /api/v1/companies_users_permissions/destroy )

```javascript
{
    "companies": ["36.052.584/0001-96"]
}
```

#### Return of Delete All

```javascript
{
  "result": "ok"
}
```

---
