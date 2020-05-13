# Cash Flow Api

---

-   [Routes](#cashflow-routes)
-   [Table](#cashflow-table)
-   [Store Batches](#cashflow-batches)
-   [Delete All Cashflow](#cashflow-destroy)

<a name="cashflow-routes"></a>

## Cash Flow Routes

Base Address: http://localhost/api/v1/cashflow

| Method | URL                      | Action       | Description               |
| ------ | ------------------------ | ------------ | ------------------------- |
| GET    | /api/v1/cashflow         | index        | Cashflow List             |
| POST   | /api/v1/cashflow/batches | storeBatches | Store Batches of Cashflow |
| DELETE | /api/v1/cashflow/destroy | destroyAll   | Destroy All Cashflow      |

<a name="cashflow-table"></a>

### Cash flow Table

| Field               | Type          | Description |
| ------------------- | ------------- | ----------- |
| id                  | bigIncrement  |             |
| company_id          | bigInteger    | foreign key |
| amount_payable      | decimal(18,2) |             |
| amount_receivable   | decimal(18,2) |             |
| day_balance         | decimal(18,2) |             |
| accumalated_balance | decimal(18,2) |             |
| accumulated_pending | decimal(18,2) |             |
| cashflow_date       | date          |             |
| created_at          | timestamp     | auto        |
| updated_at          | timestamp     | auto        |

<a name="cashflow-batches"></a>

### Store Batches of Cash flow ( /api/v1/cashflow/batches )

```javascript
{
  "companies": [
    {
      "company": "13171390000104",
      "cashflow": [
        {
            "amount_payable": 253.78,
            "amount_receivable": 135.20,
            "day_balance": 571.38,
            "accumalated_balance": 128.71,
            "accumulated_pending": 210.44,
            "cashflow_date": "2020-05-20"
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

<a name="cashflow-destroy"></a>

### Delete All Cash flow ( /api/v1/cashflow/destroy )

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
