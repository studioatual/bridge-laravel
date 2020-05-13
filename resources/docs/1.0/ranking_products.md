# Ranking Products Api

---

-   [Routes](#ranking_products-routes)
-   [Table](#ranking_products-table)
-   [Store Batches](#ranking_products-batches)
-   [Delete All Ranking](#ranking_products-destroy)

<a name="ranking_products-routes"></a>

## Ranking Products Routes

Base Address: http://localhost/api/v1/ranking_products

| Method | URL                              | Action       | Description                       |
| ------ | -------------------------------- | ------------ | --------------------------------- |
| GET    | /api/v1/ranking_products         | index        | Ranking Product List              |
| POST   | /api/v1/ranking_products/batches | storeBatches | Store Batches of Ranking Products |
| DELETE | /api/v1/ranking_products/destroy | destroyAll   | Destroy All Ranking Products      |

<a name="ranking_products-table"></a>

### Ranking Products Table

| Field       | Type          | Description |
| ----------- | ------------- | ----------- |
| id          | bigIncrement  |             |
| company_id  | bigInteger    | foreign key |
| code        | integer       |             |
| description | string(100)   |             |
| type        | string(2)     | Ex: UN      |
| total       | decimal(18,2) | Ex: 127.32  |
| created_at  | timestamp     | auto        |
| updated_at  | timestamp     | auto        |

<a name="ranking_products-batches"></a>

### Store Batches of Ranking Products ( /api/v1/ranking_products/batches )

```javascript
{
  "companies": [
    {
      "company": "13171390000104",
      "products": [
        {
            "code": 156,
            "description": "Product 001",
            "type": "UN",
            "total": 128.71
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

<a name="ranking_products-destroy"></a>

### Delete All Ranking Products ( /api/v1/ranking_products/destroy )

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
