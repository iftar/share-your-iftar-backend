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
| User type       | any      |
| Query string    | `postcode={postcode}` |

**JavaScript (jQuery)**

```javascript
  $.ajax({
   url: '/api/orders/get-available-locations',
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
  ...
]
```


## CREATE Order

TBC

## GET Order

TBC
