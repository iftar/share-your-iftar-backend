# Order API Documentation

The Order API documentation allows you to manage orders.

<strong>NOTE: These APIs handle [Personal information](https://ico.org.uk/for-organisations/guide-to-data-protection/guide-to-the-general-data-protection-regulation-gdpr/key-definitions/what-is-personal-data/). Please use these APIs with care.</strong>

## Wireframe

<img src="./assets/share_your_iftar_-_order_flow_.png" />

## GET Available Collection points

This API gets the available collection points for the user based on their Post code.

| Key     | Value    |
| -------------   |-------------|
| Method          | GET |
| Response type   | JSON |
| Path            | `/api/orders/get-available-collection-points` |
| Authentication  | required |
| User type       | normal    |
| Query string    | `postcode={postcode}` |

**JavaScript (jQuery)**

```javascript
$.ajax({
  url: '/api/orders/get-available-collection-points',
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
    "id": 31,
    "name": "East London Mosque",
    "type": "mosque",
    "notes": "Some important information about collection point.",
    "capacity_available": 30,
    "capacity_total": 100,
    "available_time_slots": [
      {
        "id": 23,
        "start_time": "16:00",
        "end_time": "17:00",
        "max_capacity": 33
      },
      {
        "id": 28,
        "start_time": "17:00",
        "end_time": "18:00",
        "max_capacity": 33
      },
      {
        "id": 30,
        "start_time": "18:00",
        "end_time": "19:00",
        "max_capacity": 34
      }
    ]
  },
  {...},
  {...}
]
```

## CREATE Order

TBC

## GET List Order (NOT MVP)

This API gets the orders placed by user.

| Key     | Value    |
| -------------   |-------------|
| Method          | GET |
| Response type   | JSON / paginated |
| Path            | `/api/orders` |
| Authentication  | required |
| User type       | any      |

**JavaScript (jQuery)**

```javascript
$.ajax({
  url: '/api/orders',
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
    "id": 3121,
    "name": "John smith",
    "type": "collection",
    "collection_point_id": 31,
    "collection_point_timeslot_id": 28,
    "meals_adults": 2,
    "meals_children": 3,
    "notes": "Some important information about the order"
  },
  {
    "id": 31223,
    "name": "John smith",
    "address_line_1": "123 Fake street",
    "address_line_2": "",
    "address_city": "London",
    "address_post_code": "E1 1AA",
    "type": "delivery",
    "collection_point_id": 31,
    "collection_point_timeslot_id": 28,
    "meals_adults": 2,
    "meals_children": 3,
    "notes": "Some important information about the order"
  },
  {...}
]
```

## GET Order (NOT MVP)

This API gets the order information.

| Key     | Value    |
| -------------   |-------------|
| Method          | GET |
| Response type   | JSON |
| Path            | `/api/orders/{id}` |
| Authentication  | required |
| User type       | normal   |

**JavaScript (jQuery)**

```javascript
$.ajax({
  url: '/api/orders/3121',
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
  "id": 3121,
  "name": "John smith",
  "type": "collection",
  "collection_point_id": 31,
  "collection_point_timeslot_id": 28,
  "meals_adults": 2,
  "meals_children": 3,
  "notes": "Some important information about the order"
}
```
