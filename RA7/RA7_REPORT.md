# RA7 — REST API Report
**Student:** Cristian Álvarez Hernández
**Project:** Laravel Task Manager  

---

## 1. Theoretical Documentation

### What is a Web Service

A web service is a software component that exposes functionality over a network using standard protocols such as HTTP. It enables communication between different systems regardless of the programming language, operating system, or platform they use. Web services act as a contract between a provider and a consumer: the provider defines what operations are available and what data format is used, and the consumer calls those operations over the network.

There are two main types: SOAP (Simple Object Access Protocol), which uses XML and is common in enterprise environments, and REST (Representational State Transfer), which uses HTTP and JSON and is the dominant approach in modern web and mobile development.

### What is a REST API

A REST API (Representational State Transfer Application Programming Interface) is a web service that follows a set of architectural constraints defined by Roy Fielding in his 2000 doctoral dissertation. It uses standard HTTP methods to perform operations on resources identified by URLs, and typically returns data in JSON format.

The key idea is that the server exposes resources (such as tasks, users, or products) as URLs, and clients interact with those resources using HTTP verbs: GET to read, POST to create, PUT or PATCH to update, and DELETE to remove.

### Common Use Cases of REST APIs

REST APIs are used in virtually every modern application:

- **Mobile applications** — an iOS or Android app calls a REST API to retrieve and send data to the backend.
- **Single Page Applications (SPA)** — a React, Vue, or Angular frontend calls a Laravel REST API instead of rendering full HTML pages on the server.
- **Third-party integrations** — payment providers (Stripe), email services (Mailgun), or mapping services (Google Maps) all expose REST APIs for other applications to consume.
- **Microservices** — large systems split into small independent services that communicate with each other via REST calls.
- **IoT devices** — sensors and embedded devices send data to a backend REST API.

In this project, the REST API allows any external client (Postman, a mobile app, or a JavaScript frontend) to manage tasks without needing to go through the Blade web interface.

### Advantages of Using an API as an Access Layer to Business Logic

Placing business logic behind an API layer provides several important benefits:

**Separation of concerns** — the API defines a clear contract between the frontend and the backend. The frontend does not need to know how data is stored or processed; it only needs to know which endpoints to call.

**Reusability** — the same API can be consumed by a web app, a mobile app, and third-party services simultaneously without duplicating any logic.

**Testability** — API endpoints can be tested independently using tools like Postman or PHPUnit without needing a browser or a rendered HTML page.

**Scalability** — the frontend and backend can be deployed, scaled, and updated independently.

**Consistency** — all consumers of the API receive data in the same format and subject to the same validation rules, reducing bugs caused by inconsistent data handling.

---

## 2. REST Architecture Principles

### Stateless Communication

In a stateless architecture, each HTTP request must contain all the information needed for the server to process it. The server does not store any session state between requests. Each request is independent.

In this project, the REST API (`/api/tasks`) does not use cookies or server-side sessions. Every request is handled in isolation, which makes the API predictable and easy to cache or load-balance.

### Resource-Based URLs

REST APIs expose resources, not actions. URLs are nouns that identify a resource, and the HTTP method determines the action performed on it.

In this project the resource is `tasks`. The full set of endpoints is:

| Method | URL | Action |
|--------|-----|--------|
| GET | `/api/tasks` | List all tasks |
| POST | `/api/tasks` | Create a new task |
| GET | `/api/tasks/{id}` | Show a single task |
| PUT / PATCH | `/api/tasks/{id}` | Update a task |
| DELETE | `/api/tasks/{id}` | Delete a task |

Notice that the URL never contains verbs like `/getTasks` or `/deleteTask` — the verb is expressed by the HTTP method.

### HTTP Methods

Each HTTP method has a defined semantic meaning in REST:

- **GET** — retrieve data without side effects. Safe and idempotent.
- **POST** — create a new resource. Not idempotent (calling it twice creates two resources).
- **PUT** — replace an existing resource completely.
- **PATCH** — partially update an existing resource (update only the fields provided).
- **DELETE** — remove a resource. Idempotent (deleting twice has the same result as deleting once).

### HTTP Status Codes

Status codes communicate the result of a request without needing to inspect the response body:

| Code | Meaning | When used in this project |
|------|---------|--------------------------|
| 200 OK | Request succeeded | GET and PUT/PATCH responses |
| 201 Created | Resource created | POST `/api/tasks` success |
| 404 Not Found | Resource does not exist | GET `/api/tasks/999` |
| 422 Unprocessable Entity | Validation failed | POST with missing `title` |
| 500 Internal Server Error | Server error | Unexpected exceptions |

---

## 3. Technologies Used

### HTTP

HTTP (HyperText Transfer Protocol) is the transport protocol that underpins all REST APIs. Every request and response follows the HTTP/1.1 standard, carrying headers (such as `Content-Type` and `Accept`), a status code, and an optional body. In this project, all API communication happens over HTTPS in production (via GitHub Codespaces port forwarding) and plain HTTP in local development.

### JSON

JSON (JavaScript Object Notation) is the data format used by the API for both request bodies and response payloads. It is lightweight, human-readable, and natively supported by browsers, mobile platforms, and virtually every programming language. Laravel automatically serializes Eloquent models to JSON when a controller returns a `response()->json()` call.

Example JSON response from `GET /api/tasks/1`:
```json
{
  "data": {
    "id": 1,
    "user_id": 2,
    "title": "Buy groceries",
    "description": "Milk, eggs, bread",
    "completed": false,
    "created_at": "2026-06-08T12:00:00.000000Z",
    "updated_at": "2026-06-08T12:00:00.000000Z",
    "user": {
      "id": 2,
      "name": "Student User",
      "email": "student@example.com"
    }
  }
}
```

### REST

REST is the architectural style applied to define how the API endpoints are structured and how HTTP methods map to CRUD operations. Laravel's `Route::apiResource()` helper automatically registers all five RESTful routes (index, store, show, update, destroy) following REST conventions with a single line of code.

### Laravel

Laravel is the PHP framework used to build the API. It provides several features that make building REST APIs straightforward:

- `Route::apiResource()` — registers all RESTful routes automatically.
- Eloquent ORM — maps database tables to PHP models with built-in relationship support.
- Form Request validation — centralises validation rules and returns standardised 422 responses automatically when validation fails.
- JSON response helpers — `response()->json($data, $status)` serialises data and sets the correct headers.
- Route model binding — automatically resolves a `Task` model from the `{task}` URL parameter and returns 404 if it does not exist.

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

Creates a new task. Requires `title`.

**Required headers:**
```
Accept: application/json
Content-Type: application/json
```

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
    "user_id": 1,
    "created_at": "2026-06-08T12:00:00.000000Z",
    "updated_at": "2026-06-08T12:00:00.000000Z"
  }
}
```

**Validation error 422** (when `title` is missing):
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
    "completed": false,
    "user": { "id": 2, "name": "Student User" }
  }
}
```

**Response 404** (task does not exist):
```json
{
  "message": "No query results for model [App\\Models\\Task] 999"
}
```

---

#### PUT /api/tasks/{id}

Updates an existing task.

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
  "data": {
    "id": 1,
    "title": "Updated title",
    "completed": true
  }
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

### How the Web Application Consumes the API

The web application consumes the API in two complementary ways that together demonstrate a full integration between the frontend layer and the business logic layer.

#### Server-side via Eloquent (shared business logic)

The `TaskController` uses Eloquent models directly to perform all CRUD operations: `Task::create()`, `Task::query()`, `$task->update()`, and `$task->delete()`. This means the business logic defined in the `Task` model and its relationships is shared between the web layer and the API layer — there is no code duplication. Both the Blade web interface and the REST API operate on the same data through the same model.

The `TaskController` also enforces role-based access control using `$user->isAdmin()` and `$user->canManageTask($task)`, ensuring that non-admin users can only see and modify their own tasks. This same logic could be enforced in the API layer as needed.

#### Client-side via AJAX (JSON consumption from the browser)

The `toggle` and `destroy` methods in `TaskController` detect whether the incoming request expects a JSON response by calling `$request->expectsJson()`. When the browser sends the header `Accept: application/json`, these methods return a JSON response instead of a full page redirect. This allows the Blade views to call these endpoints via JavaScript `fetch` without reloading the page — effectively consuming the application's own API from the frontend.

Example of how the task list view calls the toggle endpoint via fetch:

```javascript
fetch(`/tasks/${taskId}/toggle`, {
    method: 'PATCH',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    }
})
.then(res => res.json())
.then(data => {
    console.log(data.message); // "task status updated"
    console.log(data.task);    // updated task object
});
```

This pattern means the same controller method handles both a traditional form submission (returning a redirect) and an AJAX call (returning JSON), which is a clean and efficient approach to API consumption within a Laravel application.

#### Shared Validation

Both the web layer and the API layer reuse the same validation rules defined in `StoreTaskRequest` and `UpdateTaskRequest`. This ensures that data integrity is enforced consistently regardless of whether a task is created through the Blade form or through a direct API call, eliminating the risk of inconsistent validation between the two interfaces.