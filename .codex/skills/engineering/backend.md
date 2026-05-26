# Backend Development Skill

## Purpose
Handle backend architecture, API development, database integration,
authentication, validation, and server-side business logic.

---

# Core Responsibilities

- Design scalable backend architecture
- Create RESTful APIs
- Implement authentication & authorization
- Manage database operations
- Handle validation and error handling
- Optimize performance
- Write maintainable code
- Ensure security best practices

---

# Tech Stack Standards

## Preferred Stack

- Language: PHP 8+
- Framework: Laravel 12
- ORM: Eloquent
- Database: MySQL
- Authentication: Laravel Sanctum
- API Testing: Postman
- Testing Framework: Pest
- Package Manager: Composer

---

# Folder Structure Rules

Use clean architecture structure.

Example:

app/
+-- Http/
|   +-- Controllers/
|   +-- Middleware/
|   +-- Requests/
+-- Models/
+-- Services/
+-- Actions/
+-- Policies/
database/
+-- factories/
+-- migrations/
+-- seeders/
routes/
+-- api.php
+-- web.php

---

# API Design Rules

## REST Conventions

- GET    → fetch data
- POST   → create data
- PUT    → replace data
- PATCH  → partial update
- DELETE → remove data

## Naming

GOOD:
- /users
- /products
- /orders/:id

BAD:
- /getUsers
- /createProduct

---

# Validation Rules

Always validate:
- request body
- query params
- route params

---

# Error Handling Rules

Always:
- use centralized error handler
- return consistent response format
- avoid exposing internal errors

Response format:

{
  "success": false,
  "message": "Invalid credentials"
}

---

# Security Rules

Mandatory:
- hash passwords using bcrypt
- never store plain passwords
- use environment variables
- sanitize inputs
- rate limit authentication routes
- validate JWT tokens
- prevent SQL injection

Never:
- commit .env files
- expose secrets in logs

---

# Database Rules

- Use migrations
- Avoid raw SQL unless necessary
- Add indexes for frequent queries
- Use transactions for critical operations

Naming:
- snake_case for database
- camelCase for TypeScript

---

# Performance Rules

Optimize:
- N+1 queries
- large payloads
- unnecessary database calls

Use:
- pagination
- caching when needed
- async operations properly

---

# Logging Rules

Use structured logging.

Log:
- server startup
- errors
- important actions

Never log:
- passwords
- tokens
- sensitive user data

---

# Testing Rules

Required:
- unit tests for services
- integration tests for APIs

Critical flows:
- authentication
- payments
- database transactions

---

# Refactoring Rules

When refactoring:
- preserve behavior
- keep commits small
- update tests
- improve readability

Focus:
- remove duplication
- simplify logic
- improve naming

---

# AI Agent Instructions

Before coding:
1. Analyze existing architecture
2. Reuse existing patterns
3. Check naming consistency
4. Plan implementation steps

Before finishing:
1. Run tests
2. Validate types
3. Check lint errors
4. Review security concerns

Never:
- introduce breaking changes silently
- create duplicate utilities
- bypass validation
