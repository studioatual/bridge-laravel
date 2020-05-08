# Api for Groups

---

-   [Routes](#groups-routes)
-   [Table](#groups-table)
-   [Store or Update](#groups-store-or-update)
-   [Store or Update Batches](#groups-batches)
-   [Delete Batches](#groups-delete-batches)

<a name="groups-routes"></a>

## Groups Routes

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
| DELETE | /api/v1/groups/destroy | destroyAll     | Destroy All Groups        |

<a name="groups-table"></a>

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

<a name="groups-store-or-update"></a>

### Store or Update One Group

```javascript
{
  "name": "FBS Sistemas",
  "cnpj": "80.066.527/0001-58",
  "code": 137,
  "type": 1,
  "active": 1
}
```

#### Return of Store or Update

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

#### Return of Destroy

```javascript
{
  "result": "ok"
}
```

<a name="groups-batches"></a>

### Store or Update Batches of Groups ( /api/v1/groups/batches )

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
