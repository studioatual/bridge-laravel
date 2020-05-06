# Api Routes Map

---

-   [Authentication](#auth)
-   [Groups](#groups)
-   [Users](#users)

<a name="auth"></a>

## Authentication

Base Address: http://localhost/api/v1/auth

| Method | URL          | Action | Description                                 |
| ------ | ------------ | ------ | ------------------------------------------- |
| POST   | /api/v1/auth | login  | Authenticate User                           |
| GET    | /api/v1/auth | user   | Check User Token ( Get User and Companies ) |

### Send Data to receive Token ( /api/v1/auth )

```javascript
{
  "email": "name@domain.com",
  "password": "123",
}
```

---

<a name="groups"></a>

## Groups

Base Address: http://localhost/api/v1/groups

| Method | URL                    | Action         | Description               |
| ------ | ---------------------- | -------------- | ------------------------- |
| GET    | /api/v1/groups         | index          | Group List                |
| POST   | /api/v1/groups         | store          | Store One Group           |
| GET    | /api/v1/groups/{id}    | show           | Show One Group            |
| PUT    | /api/v1/groups/{id}    | update         | Update One Group          |
| DELETE | /api/v1/groups/{id}    | destroy        | Destroy One Group         |
| POST   | /api/v1/groups/batches | storeBatches   | Store Batches of Groups   |
| PUT    | /api/v1/groups/batches | updateBatches  | Update Batches of Groups  |
| DELETE | /api/v1/groups/batches | destroyBatches | Destroy Batches of Groups |

### Groups Table

| Field      | Type         | Description            |
| ---------- | ------------ | ---------------------- |
| id         | bigIncrement |                        |
| name       | string(100)  |                        |
| cnpj       | string(14)   | Unique in Groups Table |
| code       | integer      | nullable               |
| type       | boolean      | 0 or 1                 |
| active     | boolean      | 0 or 1                 |
| created_at | timestamp    | auto                   |
| updated_at | timestamp    | auto                   |

### Store One Group

```javascript
{
  "name": "FBS Sistemas",
  "cnpj": "80.066.527/0001-58",
  "code": 137,
  "type": 1,
  "active": 1
}
```

#### Return of Store

```javascript
{
  "id": 1,
  "name": "FBS Sistemas",
  "cnpj": "80.066.527/0001-58",
  "code": 137,
  "type": 1,
  "active": 1,
  "created_at": "2020-05-04T20:36:48.000000Z",
  "updated_at": "2020-05-04T20:36:48.000000Z",
}
```

### Store and Update Batches of Groups ( /api/v1/groups/batches )

```javascript
{
  "groups": [
    {
      "name": "FBS Sistemas",
      "cnpj": "80.066.527/0001-58",
      "code": 137,
      "type": 1,
      "active": 1
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

### Delete Batches of Groups ( /api/v1/groups/batches )

```javascript
{
  "groups": [
    {
      "cnpj": "80.066.527/0001-58",
    },
    { ... }
  ]
}

```

#### Return of Delete Batches

```javascript
{
  "result": "ok"
}
```

---

<a name="users"></a>

## Users

Base Address: http://localhost/api/v1/users

| Method | URL                | Action  | Description      |
| ------ | ------------------ | ------- | ---------------- |
| GET    | /api/v1/users      | index   | User List        |
| POST   | /api/v1/users      | store   | Store One User   |
| GET    | /api/v1/users/{id} | show    | Show One User    |
| PUT    | /api/v1/users/{id} | update  | Update One User  |
| DELETE | /api/v1/users/{id} | destroy | Destroy One User |

Write something cool.. 🦊
