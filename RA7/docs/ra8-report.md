# RA7 API Report

## 1. Theoretical Documentation

### What is a web service
A web service is an application component that exposes functionality over a network
using standard protocols such as HTTP. It allows different systems to communicate
and exchange data regardless of the programming language or platform they use.

### What is a REST API
A REST API (Representational State Transfer) is a web service that follows a set of
architectural constraints. It uses HTTP methods to perform operations on resources
identified by URLs, and typically returns data in JSON format.

### Common use cases of REST APIs
- Mobile applications consuming backend data
- Frontend JavaScript applications (SPA) talking to a Laravel backend
- Third-party integrations between different services
- Microservices communicating with each other

### Advantages of using an API as an access layer to business logic
Separating business logic into an API layer means the same logic can be consumed by
a web app, a mobile app, and any external service without duplicating code. It also
makes the application easier to test, maintain, and scale independently.

---

## 2. REST Architecture Principles

### Stateless communication
Each HTTP request must contain all the information needed to process it. The server
does not store any session state between requests. In this project the API does not
use session cookies; each request is independent.

### Resource-based URLs
Resources are identified by nouns in the URL. In this project the resource is `tasks`.

| Method | URL | Action |
|--------|-----|--------|
| GET | /api/tasks | List all tasks |
| POST | /api/tasks | Create a task |
| GET | /api/tasks/{id} | Show one task |
| PUT/PATCH | /api/tasks/{id} | Update a task |
| DELETE | /api/tasks/{id} | Delete a task |

### HTTP methods
- **GET** — retrieve data without side effects
- **POST** — create a new resource
- **PUT / PATCH** — update an existing resource
- **DELETE** — remove a resource

### HTTP status codes
- **200 OK** — successful GET or UPDATE
- **201 Created** — resource created successfully
- **404 Not Found** — resource does not exist
- **422 Unprocessable Entity** — validation failed

---

## 3. Technologies used

### HTTP
The transport protocol used by all REST APIs. Requests and responses follow the
HTTP/1.1 standard with headers, status codes, and a body.

### JSON
JavaScript Object Notation. The data format returned by the API. Lightweight,
human-readable, and natively supported by browsers and most languages.

### REST
The architectural style applied to define how the API endpoints are structured and
how HTTP methods map to CRUD operations.

### Laravel
The PHP framework used to build the API. Laravel provides `apiResource` routing,
`FormRequest` validation, Eloquent models, and JSON response helpers out of the box.

---

## 4. API Design Documentation

### Endpoints

#### GET /api/tasks
Returns a list of all tasks with their owner.

**Response 200:**
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 2,
      "title": "Buy groceries",
      "description": "Milk, eggs, bread",
      "completed": false,
      "created_at": "2026-06-08T12:00:00.000000Z",
      "updated_at": "2026-06-08T12:00:00.000000Z",
      "user": { "id": 2, "name": "Student User", "email": "student@example.com" }
    }
  ],
  "total": 1
}
```

---

#### POST /api/tasks
Creates a new task.

**Request body:**
```json
{
  "title": "Finish the report",
  "description": "Write the RA7 documentation",
  "completed": false,
  "user_id": 1
}
```

**Response 201:**
```json
{
  "message": "task created successfully",
  "data": {
    "id": 9,
    "title": "Finish the report",
    "description": "Write the RA7 documentation",
    "completed": false,
    "user_id": 1
  }
}
```

**Validation error 422:**
```json
{
  "message": "The title field is required.",
  "errors": {
    "title": ["The title field is required."]
  }
}
```

---

#### GET /api/tasks/{id}
Returns a single task by ID.

**Response 200:**
```json
{
  "data": {
    "id": 1,
    "title": "Buy groceries",
    "completed": false
  }
}
```

**Response 404:**
```json
{
  "message": "No query results for model [App\\Models\\Task] 999"
}
```

---

#### PUT /api/tasks/{id}
Updates a task.

**Request body:**
```json
{
  "title": "Updated title",
  "completed": true
}
```

**Response 200:**
```json
{
  "message": "task updated successfully",
  "data": { "id": 1, "title": "Updated title", "completed": true }
}
```

---

#### DELETE /api/tasks/{id}
Deletes a task.

**Response 200:**
```json
{
  "message": "task deleted successfully"
}
```

---

## 5. API Consumption Evidence

The web application consumes the API in two ways.

The `index.html` file at the root of the project makes a `fetch` call to
`/api/tasks` and logs the JSON response to the browser console. This demonstrates
that the API can be consumed from any HTML page with a single `fetch`.

The main Blade application at `resources/js/app.js` uses `fetch` with
`PATCH` and `DELETE` methods to call `/tasks/{id}/toggle` and
`/tasks/{id}` from the task list, updating the UI without a full page reload.
These calls use the `X-CSRF-TOKEN` header and `Accept: application/json`
so Laravel returns JSON error responses when something goes wrong.