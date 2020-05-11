# Api for Groups

---

-   [Routes](#groups-routes)
-   [Table](#groups-table)
-   [Store Batches](#groups-batches)
-   [Delete All Groups](#groups-destroy)

<a name="groups-routes"></a>

## Groups Routes

Base Address: http://localhost/api/v1/groups

| Method | URL                    | Action       | Description             |
| ------ | ---------------------- | ------------ | ----------------------- |
| GET    | /api/v1/groups         | index        | Group List              |
| POST   | /api/v1/groups/batches | storeBatches | Store Batches of Groups |
| DELETE | /api/v1/groups/destroy | destroyAll   | Destroy All Groups      |

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

<a name="groups-batches"></a>

### Store Batches of Groups ( /api/v1/groups/batches )

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

<a name="groups-destroy"></a>

### Delete All Groups ( /api/v1/groups/destroy )

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
