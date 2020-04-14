# Charity API Documentation

The Charity API documentation allows you to manage a charity's profile and dashboard.

<strong>NOTE: These APIs handle [Personal information](https://ico.org.uk/for-organisations/guide-to-data-protection/guide-to-the-general-data-protection-regulation-gdpr/key-definitions/what-is-personal-data/). Please use these APIs with care.</strong>

## Wireframe

<img src="./assets/Share_your_iftar-_charity_dashboard_.png" />

## GET Charity profile

This API gets the charity profile for the charity user logged in.

| Key     | Value    |
| -------------   |-------------|
| Method          | GET |
| Response type   | JSON |
| Path            | `/api/charity/profile` |
| Authentication  | required |
| User type       | charity    |

**JavaScript (jQuery)**

```javascript
$.ajax({
  url: '/api/charity/profile',
  type: 'GET',
  contentType: 'application/json'
  headers: {
  'Authorization': 'Bearer <token>'
  },
  success: function (result) {
    // CallBack(result);
  },
  error: function (error) {
    // handle error
  }
});
```

**Example response**

```json
{
  "id": 31,
  "name": "ISLAMIC RELIEF (UK)",
  "registration_number": "1112111",
  "max_delivery_capacity": 100,
  "notes": "Some important information about the charity"
}
```

## GET Today's deliveries

This API gets deliveries for the charity user logged in.

| Key     | Value    |
| -------------   |-------------|
| Method          | GET |
| Response type   | JSON |
| Path            | `/api/charity/deliveries` |
| Authentication  | required |
| User type       | charity    |

**JavaScript (jQuery)**

```javascript
$.ajax({
  url: '/api/charity/deliveries',
  type: 'GET',
  contentType: 'application/json'
  headers: {
  'Authorization': 'Bearer <token>'
  },
  success: function (result) {
    // CallBack(result);
  },
  error: function (error) {
    // handle error
  }
});
```

**Example response**

```json
[
  {
    "id": 23,
    "collection_point_id": 31,
    "collection_point_name": "East London Mosque",
    "collection_time": "17:00",
    "quantity_to_pickup": 20
  },
  {
    "id": 24,
    "collection_point_id": 322,
    "collection_point_name": "Brick Lane Mosque",
    "collection_time": "18:00",
    "quantity_to_pickup": 10
  }
]
```

## GET Orders for delivery

This API gets deliveries for the charity user logged in.

| Key     | Value    |
| -------------   |-------------|
| Method          | GET |
| Response type   | JSON |
| Path            | `/api/charity/deliveries/{delivery_id}/orders` |
| Authentication  | required |
| User type       | charity    |

**JavaScript (jQuery)**

```javascript
$.ajax({
  url: '/api/charity/deliveries/{delivery_id}/orders',
  type: 'GET',
  contentType: 'application/json'
  headers: {
  'Authorization': 'Bearer <token>'
  },
  success: function (result) {
    // CallBack(result);
  },
  error: function (error) {
    // handle error
  }
});
```

**Example response**

```json
[
  {
    "id": 31223,
    "name": "John Smith",
    "address_line_1": "123 Fake street",
    "address_line_2": "",
    "address_city": "London",
    "address_post_code": "E1 1AA",
    "type": "delivery",
    "collection_point_id": 31,
    "meals_adults": 2,
    "meals_children": 3,
    "notes": "Some important information about the order"
  },
  {
    "id": 31243,
    "name": "Jane Dean",
    "address_line_1": "321 Blah street",
    "address_line_2": "",
    "address_city": "London",
    "address_post_code": "E2 2AA",
    "type": "delivery",
    "collection_point_id": 31,
    "meals_adults": 2,
    "meals_children": 3,
    "notes": "Some important information about the order"
  },
  {...}
]
```

## CREATE Charity profile

This API creates a charity for the current user.

| Key     | Value    |
| -------------   |-------------|
| Method          | POST |
| Response type   | JSON |
| Path            | `/api/charity` |
| Authentication  | required |
| User type       | charity    |

**Post Data**

| Key     | Required/Optional    | Value |
| -------------   |-------------|-------------|
| name     | required | `{name}` |
| registration_number   | required | `{registration_number}` |
| max_delivery_capacity     | required | `{max_delivery_capacity}` |


**JavaScript (jQuery)**

```javascript
var charityDetails = {
  name: "ISLAMIC RELIEF (UK)",
  registration_number: "1112111",
  max_delivery_capacity: 100,
  notes: "Some important information about the charity"
};

$.ajax({
  url: '/api/charity',
  type: 'POST',
  contentType: 'application/json'
  headers: {
  'Authorization': 'Bearer <token>'
  },
  data: charityDetails,
  success: function (result) {
    // CallBack(result);
  },
  error: function (error) {
    // handle error
  }
});
```

**Example response**

```json
{
  "status": "success",
  "data": {
    "id": 31,
    "user_id": 1,
    "name": "ISLAMIC RELIEF (UK)",
    "registration_number": "1112111",
    "max_delivery_capacity": 100,
    "notes": "Some important information about the charity"
  }
}
```


## UPDATE Charity profile

This API updates the current charity users profile.

| Key     | Value    |
| -------------   |-------------|
| Method          | POST |
| Response type   | JSON |
| Path            | `/api/charity/profile` |
| Authentication  | required |
| User type       | charity    |

**Post Data**

| Key     | Required/Optional    | Value |
| -------------   |-------------|-------------|
| name     | required | `{name}` |
| registration_number   | required | `{registration_number}` |
| max_delivery_capacity     | required | `{max_delivery_capacity}` |


**JavaScript (jQuery)**

```javascript
var charityDetails = {
  name: "ISLAMIC RELIEF (UK)",
  registration_number: "1112111",
  max_delivery_capacity: 100,
  notes: "Some important information about the charity"
};

$.ajax({
  url: '/api/charity/profile',
  type: 'POST',
  contentType: 'application/json'
  headers: {
  'Authorization': 'Bearer <token>'
  },
  data: charityDetails,
  success: function (result) {
    // CallBack(result);
  },
  error: function (error) {
    // handle error
  }
});
```

**Example response**

```json
{
  "status": "success",
  "data": {
    "id": 31,
    "name": "ISLAMIC RELIEF (UK)",
    "registration_number": "1112111",
    "max_delivery_capacity": 100,
    "notes": "Some important information about the charity"
  }
}
```
