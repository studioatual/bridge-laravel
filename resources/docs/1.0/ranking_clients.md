# Ranking Clients Api

---

-   [Routes](#ranking_clients-routes)
-   [Table](#ranking_clients-table)
-   [Store Batches](#ranking_clients-batches)
-   [Delete All Ranking](#ranking_clients-destroy)

<a name="ranking_clients-routes"></a>

## Ranking Clients Routes

Base Address: http://localhost/api/v1/ranking_clients

| Method | URL                             | Action       | Description                      |
| ------ | ------------------------------- | ------------ | -------------------------------- |
| GET    | /api/v1/ranking_clients         | index        | Ranking Client List              |
| POST   | /api/v1/ranking_clients/batches | storeBatches | Store Batches of Ranking Clients |
| DELETE | /api/v1/ranking_clients/destroy | destroyAll   | Destroy All Ranking Clients      |

<a name="ranking_clients-table"></a>

### Ranking Clients Table

| Field      | Type          | Description |
| ---------- | ------------- | ----------- |
| id         | bigIncrement  |             |
| company_id | bigInteger    | foreign key |
| client     | string(100)   |             |
| name       | string(100)   |             |
| total      | decimal(18,2) | Ex: 127.32  |
| created_at | timestamp     | auto        |
| updated_at | timestamp     | auto        |

<a name="ranking_clients-batches"></a>

### Store Batches of Ranking Clients ( /api/v1/ranking_clients/batches )

```javascript
{
  "companies": [
    {
      "company": "13171390000104",
      "clients": [
        {
            "client": "FBS Sistemas do Brasil Ltda",
            "name": "FBS Sistemas",
            "total": 3750.82
        },
        { ... }
      ]
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

<a name="ranking_clients-destroy"></a>

### Delete All Ranking Clients ( /api/v1/ranking_clients/destroy )

```javascript
{
	"companies": ["13171390000104"]
}
```

#### Return of Delete All

```javascript
{
  "result": "ok"
}
```

---
