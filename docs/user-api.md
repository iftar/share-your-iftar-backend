# User API Documentation

The User API allows users to register, login and reset their passwords.

<strong>NOTE: These APIs handle [Personal information](https://ico.org.uk/for-organisations/guide-to-data-protection/guide-to-the-general-data-protection-regulation-gdpr/key-definitions/what-is-personal-data/). Please use these APIs with care.</strong>

## Frontend Authentication

### Form Headers

All API endpoints require the following 

```
Accept  application/json
```

---

### User Registration

Default user type is `user`

User will receive an email to verify their email on successful registration

#### Method & URI
```
POST /api/register
```

#### Form Data
```
{
    *"email": "my@email.com",
    *"password": "password",
    *"confirm": "password",
    "first_name": "John",
    "last_name": "Smith",
    "type": "user" | "charity",
}
```

#### Success Result
```
200 OK

{
    "status": "success",
    "data": {
        "user": {
            "first_name": "John",
            "last_name": "Smith",
            "email": "my@email.com",
            "type": "user",
            "status": "approved",
            "updated_at": "2020-04-11T23:03:48.000000Z",
            "created_at": "2020-04-11T23:03:48.000000Z",
            "id": 1
        }
    }
}
```

#### Error Results
```
422 Unprocessable Entity

{
    "status": "error",
    "message": "User already exists with this email"
}

{
    "status": "error",
    "message": "Validation error",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ],
        "confirm": [
            "The confirm and password must match."
        ]
    }
}
```

---

### User Login

User will need to verify email before being allowed to login

#### Method & URI
```
POST /api/login
```

#### Form Data
```
{
    *"email": "my@email.com",
    *"password": "password"
}
```

#### Success Result
```
200 OK

{
    "status": "success",
    "data": {
        "user": {
			"id": 1,
        	"first_name": "John",
            "last_name": "Smith",
            "email": "my@email.com",
            "email_verified_at": "2020-04-11T23:05:23.000000Z",
            "type": "user",
            "status": "approved",
            "updated_at": "2020-04-11T23:03:48.000000Z",
            "created_at": "2020-04-11T23:03:48.000000Z",
        },
        "token": "eyJ1eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMzljZjc5Y2U4MzYzOTg1MzBkOTBlZmRiYzM5ZTBiZmRiOWM4NTJhMmRmYmNlNjZhZjI0YzI0MzNlNDBmNWY3N2RlNTE1MDRjOTdmMTNhZmQiLCJpYXQiOjE1ODY2NDYzNjgsIm5iZiI6MTU4NjY0NjM2OCwiZXhwIjoxNjE4MTgyMzY3LCJzdWIiOiIxMDIiLCJzY29wZXMiOltdfQ.l_g-XjvduyiFdWCps8tT0uEPTwi9irwua4fS-PmCaPS93tLWxsEj5Zb9ULRFpjOai0elkYVy3OUJKupGXYfmejxgn6tokqyl_sPgcdUgSIZUjQXcP7kUqWDdmjY_aeIrrmBmu0aV4l_xQrIkMr8SadxXMSrm-wZecgzoAqbI0c-gnT_jWpfkmWrd-crPFB9r-D-NQZerCTfNMAS-7sS8tR-9W8YsGsvnMguNVlvQtej4S0qQe-TY1kA3eOmLgCINRiWNgtfmWprX--dFk5bm9admEzjmobWzJF7qB_N7WYCpGjYIPmtmiFIiFVhMG5Uc3zWGtcQkTmHmmnPLQgSaJyKftkko-bN8_CTmuQJmBhwLkbYLfA1sXoBhjPfA6Bk6ljQT63HqSs19tG81q_bwldLskIy7bepq_Tuqe2MFPSUp_aWcMLRQcaK7ktxUQzMbRKEIkBcHkBVV2gLqlbh9zNdLwlHnAroYKQ_NvYPSha-UtqYYVW15bm0Wz5Zxoov4YrJJbu3XLhUlAYGM0j7ZKTDQSOQzoqDqtOu5yd8SkdZWP9ORNennechR7QSxnq9L0ln1GI6PBF4U3hm8bR6j6GnBAgIOsa0CClY2SrMtX3izRMWCTYi8sSTL9RCubqhFsiEobf_NNiBGozoVTt1hg6143zmDrQAN73xBB8b2_sQ"
    }
}
```

#### Error Results
```
422 Unprocessable Entity

{
    "status": "error",
    "message": "Validation error",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    }
}

401 Unauthorized

{
    "status": "error",
    "message": "Invalid login details"
}
```

---

### Get Logged In User Details

### Form Headers

All authenticated API routes will need the following additional header

```
Authorization	Bearer {{ TOKEN_FROM_LOGIN }}
```

#### Method & URI
```
GET /api/user
```

#### Success Result
```
200 OK

{
    "status": "success",
    "data": {
        "user": {
			"id": 1,
        	"first_name": "John",
            "last_name": "Smith",
            "email": "my@email.com",
            "email_verified_at": "2020-04-11T23:05:23.000000Z",
            "type": "user",
            "status": "approved",
            "updated_at": "2020-04-11T23:03:48.000000Z",
            "created_at": "2020-04-11T23:03:48.000000Z",
        }
    }
}
```

---

### User Logout

#### Method & URI
```
GET /api/logout
```

#### Success Result
```
200 OK

{
    "status": "success"
}
```
