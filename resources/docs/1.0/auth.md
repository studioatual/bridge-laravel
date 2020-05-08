# Authentication Api

---

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

#### Return of Auth

```javascript
{
  "token": "eyJ0eXAiOiJKV1.cwMWM0MDA4NzJkYjdhNTk3NmY3In0.TFHO6L725civqXsN5sc",
}
```

---
