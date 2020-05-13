# Api for Users

---

-   [Routes](#users-routes)
-   [Table](#users-table)
-   [Store Batches](#users-batches)
-   [Delete All Users](#users-destroy)

<a name="users-routes"></a>

## Users Routes

Base Address: http://localhost/api/v1/users

| Method | URL                   | Action       | Description            |
| ------ | --------------------- | ------------ | ---------------------- |
| GET    | /api/v1/users         | index        | User List              |
| POST   | /api/v1/users/batches | storeBatches | Store Batches of Users |
| DELETE | /api/v1/users/destroy | destroyAll   | Destroy All Users      |

<a name="users-table"></a>

### Users Table

| Field      | Type         | Description           |
| ---------- | ------------ | --------------------- |
| id         | bigIncrement |                       |
| group_id   | bigInteger   |                       |
| code       | integer      | nullable              |
| name       | string(100)  |                       |
| cpf_cnpj   | string(14)   | Unique in Users Table |
| username   | string(100)  | nullable              |
| email      | string(10)   | Unique in Users Table |
| password   | string(255)  |                       |
| hash       | string(255)  | nullable              |
| admin      | boolean      | 0 or 1                |
| active     | boolean      | 0 or 1                |
| created_at | timestamp    | auto                  |
| updated_at | timestamp    | auto                  |

<a name="users-batches"></a>

### Store Batches of Users ( /api/v1/users/batches )

```javascript
{
  "users": [
    {
        "group": "38161274000135",
        "name": "José da Silva",
        "code": 223,
        "cpf_cnpj": "80066527000158",
        "username": "jose.silva",
        "email": "jose.silva@domain.com",
        "password": "123456",
        "active": 1,
        "admin": 1
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

<a name="users-destroy"></a>

### Delete All Users ( /api/v1/users/destroy )

```javascript
{
	"groups": ["13171390000104"]
}
```

#### Return of Delete All

```javascript
{
  "result": "ok"
}
```

---
