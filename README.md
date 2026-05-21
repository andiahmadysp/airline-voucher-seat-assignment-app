# Airline Voucher Seat Assignment

Web application for airline crew to generate 3 unique random seat assignments for voucher winners per flight.

**Stack:** React 19 + Laravel 13 + SQLite

## Prerequisites

| Tool | Minimum Version |
|---|---|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18+ |
| npm | 9+ |


## Project Structure

```
airline-voucher-seat-assignment-app/
├── backend/    # Laravel 13 REST API
├── frontend/   # React 19 SPA
└── README.md
```


## Backend Setup

### 1. Install dependencies

```bash
cd backend
composer install
```

### 2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` — set the SQLite database path:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/backend/database/vouchers.db
```

> Create the file if it doesn't exist: `touch database/vouchers.db`

### 3. Run migrations

```bash
php artisan migrate
```

### 4. Start the server

```bash
php artisan serve
```

API will be available at `http://localhost:8000`.


## Frontend Setup

### 1. Install dependencies

```bash
cd frontend
npm install
```

### 2. Configure environment

```bash
cp .env.example .env
```

Default `.env`:

```env
VITE_API_BASE_URL=/api
```

The Vite dev server proxies `/api` requests to `http://localhost:8000` — no CORS configuration needed in development.

### 3. Start the dev server

```bash
npm run dev
```

App will be available at `http://localhost:5173`.


## Running Tests

```bash
cd backend
php artisan test
```


## API Reference

### `POST /api/check`

Check if vouchers have already been generated for a flight + date.

**Request:**
```json
{
  "flightNumber": "GA102",
  "date": "2025-07-12"
}
```

**Response `200`:**
```json
{
  "exists": false
}
```


### `POST /api/generate`

Generate 3 unique random seats based on aircraft layout and persist to database.

**Request:**
```json
{
  "name": "Sarah",
  "id": "98123",
  "flightNumber": "GA102",
  "date": "2025-07-12",
  "aircraft": "Airbus 320"
}
```

**Response `200`:**
```json
{
  "success": true,
  "seats": ["3B", "7C", "14D"]
}
```

**Error responses:**

| Status | Condition |
|---|---|
| `422` | Validation failed (missing/invalid fields) |
| `409` | Vouchers already generated for this flight + date |


## Seat Layout Reference

| Aircraft | Rows | Columns | Example |
|---|---|---|---|
| ATR | 1–18 | A, C, D, F | `1A`, `18F` |
| Airbus 320 | 1–32 | A, B, C, D, E, F | `1A`, `32F` |
| Boeing 737 Max | 1–32 | A, B, C, D, E, F | `1A`, `32F` |


## Postman Collection

Import `backend/postman_collection.json` into Postman. Set the `base_url` variable to `http://localhost:8000`.
