# tracker

# My tracker API Documentation

## Overview
This API provides services related to Bitcoin pricing and subscription management. It is ideal for applications that require real-time financial data and user subscription functionalities.

## Authentication
No authentication is required. This app has been made for testing purposes

### Get Current Bitcoin Price
- **URL:** `/bitcoin/price/{currencyPair}`
- **Method:** `GET`
- **Auth Required:** No
- **Description:** Fetches the current price of Bitcoin for a specified currency pair.
- **URL Parameters:**
  - `currencyPair`: The currency pair for which the price is requested (e.g., `BTCEUR`, `BTCUSD`).
- **Example Request:**
GET https://api.myapp.com/bitcoin/price/BTCEUR

- **Responses:**
- `200 OK`: JSON object containing the current price.
- `400 Bad Request`: If the currency pair is invalid.
- `500 Internal Server Error`: Server error.

### Get Historical Bitcoin Prices
- **URL:** `/bitcoin/historical/{currencyPair}`
- **Method:** `GET`
- **Auth Required:** No
- **Description:** Provides historical price data of Bitcoin for a specified currency pair.
- **URL Parameters:**
  - `currencyPair`: Specifies the currency pair for historical data.
- **Query Parameters:**
  - `time_frame`: Time frame for historical data (default `24_hours`).
  - Supported time frames: `1_hour`, `6_hours`, `24_hours` and `168_hours`
  - `date`: Specific date for historical data (default today's date).
- **Example Request:** 
GET https://api.myapp.com/bitcoin/historical/BTCUSD?time_frame=24_hours&date=2024-01-15

- **Responses:**
- `200 OK`: JSON array of historical prices.
- `400 Bad Request`: Invalid parameters.
- `500 Internal Server Error`: Server error.

### Create Subscription
- **URL:** `/subscription/create`
- **Method:** `POST`
- **Auth Required:** No
- **Description:** Creates a new subscription with provided details.
- **Request Body Example:** 
  ```json
  {
    "email": "user@example.com",
    "currency_pair": "BTCUSD",
    "notification_conditions": [
      {
        "type": "price_limit",
        "value": 50000
      },
      {
        "type": "percentage_change",
        "value": 5,
        "time_interval": "1_hour"
      }
    ]
  }
- **Responses:**
- `201 Created`:  Subscription created successfully.
- `500 Internal Server Error`: Subscription creation failed.

### Health Check
- **URL:** `/health`
- **Method:** `GET`
- **Auth Required:** No
- **Description:** Checks the health status of the API.
- **Example Request:** 
GET https://api.myapp.com/health

- **Responses:**
- `200 OK`: JSON indicating the service is online.

---

## Error Codes
- `400 Bad Request`: Request is invalid or missing required parameters.
- `401 Unauthorized`: Missing or incorrect authentication credentials.
- `500 Internal Server Error`: Unexpected server error.

## Rate Limiting
Be aware of rate limits to ensure fair usage. Exceeding these limits will result in throttling of requests.

## Additional Information

### Request and Response Format
- Requests and responses are formatted in JSON.
- Include `Content-Type: application/json` in request headers.
