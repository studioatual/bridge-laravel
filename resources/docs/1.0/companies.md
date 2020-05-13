# Companies Api

---

-   [Routes](#companies-routes)
-   [Table](#companies-table)
-   [Store Batches](#companies-batches)
-   [Delete All Companies](#companies-destroy)

<a name="companies-routes"></a>

## Companies Routes

Base Address: http://localhost/api/v1/companies

| Method | URL                       | Action       | Description                |
| ------ | ------------------------- | ------------ | -------------------------- |
| GET    | /api/v1/companies         | index        | Company List               |
| POST   | /api/v1/companies/batches | storeBatches | Store Batches of Companies |
| DELETE | /api/v1/companies/destroy | destroyAll   | Destroy All Companies      |

<a name="companies-table"></a>

### Companies Table

| Field      | Type         | Description               |
| ---------- | ------------ | ------------------------- |
| id         | bigIncrement |                           |
| group_id   | bigInteger   |                           |
| code       | integer      | nullable                  |
| company    | string(100)  |                           |
| name       | string(100)  |                           |
| cnpj       | string(14)   | Unique in Companies Table |
| ie         | string(20)   | 0 or 1                    |
| created_at | timestamp    | auto                      |
| updated_at | timestamp    | auto                      |

<a name="companies-batches"></a>

### Store Batches of Companies ( /api/v1/companies/batches )

```javascript
{
  "companies": [
    {
        "group": "38161274000135",
        "company":"FBS Sistemas do Brasil Ltda",
        "name": "FBS Sistemas",
        "code": 223,
        "cnpj": "16.918.339/0001-01",
        "ie": "325.348.219-05",
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

<a name="companies-destroy"></a>

### Delete All Companies ( /api/v1/companies/destroy )

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
