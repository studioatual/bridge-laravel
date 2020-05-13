# Balances Api

---

-   [Routes](#balances-routes)
-   [Table](#balances-table)
-   [Store Batches](#balances-batches)
-   [Delete All Companies](#balances-destroy)

<a name="balances-routes"></a>

## Companies Routes

Base Address: http://localhost/api/v1/companies

| Method | URL                      | Action       | Description               |
| ------ | ------------------------ | ------------ | ------------------------- |
| GET    | /api/v1/balances         | index        | Balance List              |
| POST   | /api/v1/balances/batches | storeBatches | Store Batches of Balances |
| DELETE | /api/v1/balances/destroy | destroyAll   | Destroy All Balances      |

<a name="balances-table"></a>

### Companies Table

| Field       | Type          | Description             |
| ----------- | ------------- | ----------------------- |
| id          | bigIncrement  |                         |
| company_id  | bigInteger    |                         |
| description | string(100)   |                         |
| type        | boolean       | 0 expenses or 1 revenue |
| value       | decimal(14,2) | Ex: 127.00              |
| created_at  | timestamp     | auto                    |
| updated_at  | timestamp     | auto                    |

<a name="balances-batches"></a>

### Store Batches of Balances ( /api/v1/companies/batches )

```javascript
{
  "companies": [
    {
      "company": "13171390000104",
      "balances": [
        {
            "description": "Água e Luz",
            "type": 0,
            "value": 253.78
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

<a name="balances-destroy"></a>

### Delete All Balances ( /api/v1/balances/destroy )

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
