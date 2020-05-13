# Sales Api

---

-   [Routes](#sales-routes)
-   [Table](#sales-table)
-   [Store Batches](#sales-batches)
-   [Delete All sales](#sales-destroy)

<a name="sales-routes"></a>

## Sales Routes

Base Address: http://localhost/api/v1/sales

| Method | URL                   | Action       | Description            |
| ------ | --------------------- | ------------ | ---------------------- |
| GET    | /api/v1/sales         | index        | Sale List              |
| POST   | /api/v1/sales/batches | storeBatches | Store Batches of Sales |
| DELETE | /api/v1/sales/destroy | destroyAll   | Destroy All Sales      |

<a name="sales-table"></a>

### Sales Table

| Field       | Type          | Description |
| ----------- | ------------- | ----------- |
| id          | bigIncrement  |             |
| company_id  | bigInteger    | foreign key |
| description | string(100)   |             |
| total       | decimal(18,2) | Ex: 157.32  |
| created_at  | timestamp     | auto        |
| updated_at  | timestamp     | auto        |

<a name="sales-batches"></a>

### Store Batches of Sales ( /api/v1/sales/batches )

```javascript
{
  "companies": [
    {
      "company": "13171390000104",
      "sales": [
        {
            "description": "Text Sale",
            "total": 571.38,
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

<a name="sales-destroy"></a>

### Delete All Sales ( /api/v1/sales/destroy )

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
