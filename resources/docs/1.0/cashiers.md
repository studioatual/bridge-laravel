# Cashiers Api

---

-   [Routes](#cashiers-routes)
-   [Table](#cashiers-table)
-   [Store Batches](#cashiers-batches)
-   [Delete All Cashiers](#cashiers-destroy)

<a name="cashiers-routes"></a>

## Cashiers Routes

Base Address: http://localhost/api/v1/cashiers

| Method | URL                      | Action       | Description               |
| ------ | ------------------------ | ------------ | ------------------------- |
| GET    | /api/v1/cashiers         | index        | Cashiers List             |
| POST   | /api/v1/cashiers/batches | storeBatches | Store Batches of Cashiers |
| DELETE | /api/v1/cashiers/destroy | destroyAll   | Destroy All Cashiers      |

<a name="cashiers-table"></a>

### Cashiers Table

| Field         | Type          | Description             |
| ------------- | ------------- | ----------------------- |
| id            | bigIncrement  |                         |
| company_id    | bigInteger    | foreign key             |
| type          | boolean       | 0 expenses or 1 revenue |
| method        | string(30)    | Ex: Boleto              |
| total         | decimal(18,2) | Ex: 157.32              |
| cashflow_date | date          | Ex: 2020-05-20          |
| created_at    | timestamp     | auto                    |
| updated_at    | timestamp     | auto                    |

<a name="cashiers-batches"></a>

### Store Batches of Cashiers ( /api/v1/cashiers/batches )

```javascript
{
  "companies": [
    {
      "company": "13171390000104",
      "cashiers": [
        {
            "type": 1,
            "method": "BOLETO 30/60/90",
            "total": 571.38,
            "cashier_date": "2020-05-20"
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

<a name="cashiers-destroy"></a>

### Delete All Cashiers ( /api/v1/cashiers/destroy )

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
