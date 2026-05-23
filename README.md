<p align="center">
  <img src="https://img.shields.io/badge/in%20development-orange?style=for-the-badge" alt="Status" />
  <img src="https://img.shields.io/badge/laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/vue-3-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white" alt="Vue.js" />
  <img src="https://img.shields.io/badge/tailwind-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/mysql-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
</p>

<h1 align="center">Lost & Found</h1>

<p align="center">
  <strong>A modern, full-stack web application for reporting, tracking, and reclaiming lost & found items.</strong>
</p>

<p align="center">
  Built with a fully decoupled architecture — a <b>Laravel 12</b> REST API backend and a <b>Vue 3</b> single-page application frontend.
</p>

---

## 📑 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Architecture](#-architecture)
- [Project Structure](#-project-structure)
- [Prerequisites](#-prerequisites)
- [Getting Started](#-getting-started)
  - [Backend Setup](#backend-setup)
  - [Frontend Setup](#frontend-setup)
- [Environment Variables](#-environment-variables)
- [API Reference](#-api-reference)
- [Database Schema](#-database-schema)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🌟 Overview

**Lost & Found** is a community-driven platform that connects people who have lost personal belongings with those who have found them. Users can post lost or found items with descriptions, images, and location data — and others can browse, search, and submit claims to recover their belongings.

The application follows a **fully decoupled SPA architecture**, where the backend and frontend are independent applications communicating exclusively via a versioned JSON API.

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 🔐 **Authentication** | Secure token-based auth via Laravel Sanctum (register, login, logout) |
| 📝 **Item Reporting** | Report lost or found items with title, description, category, and location |
| 🖼️ **Image Uploads** | Attach multiple images to each item listing |
| 🔍 **Search & Filter** | Search items by keyword, filter by category, status, and type (lost/found) |
| 📂 **Categories** | Organize items into categories (electronics, clothing, documents, etc.) |
| 🤝 **Claim System** | Submit and manage claims on found items |
| 📄 **Pagination** | Paginated API responses with customizable page size |
| ⚡ **Rate Limiting** | API rate limiting to prevent abuse |
| 🎨 **Responsive UI** | Mobile-first design with Tailwind CSS |
| 🛡️ **CORS Protected** | Properly configured cross-origin resource sharing |

---

## 🛠️ Tech Stack

### Backend
| Technology | Version | Purpose |
|------------|---------|---------|
| [PHP](https://www.php.net/) | ^8.2 | Server-side language |
| [Laravel](https://laravel.com/) | 12.x | PHP web framework |
| [Laravel Sanctum](https://laravel.com/docs/sanctum) | ^4.3 | API token authentication |
| [MySQL](https://www.mysql.com/) | 8.x | Relational database |
| [Composer](https://getcomposer.org/) | 2.x | PHP dependency manager |

### Frontend
| Technology | Version | Purpose |
|------------|---------|---------|
| [Vue.js](https://vuejs.org/) | ^3.5 | Progressive JavaScript framework |
| [Vite](https://vitejs.dev/) | ^8.0 | Next-generation frontend build tool |
| [Vue Router](https://router.vuejs.org/) | ^5.0 | Official Vue.js router |
| [Pinia](https://pinia.vuejs.org/) | ^3.0 | State management for Vue |
| [Tailwind CSS](https://tailwindcss.com/) | ^4.2 | Utility-first CSS framework |
| [Axios](https://axios-http.com/) | latest | HTTP client for API requests |

### Development Environment
| Tool | Purpose |
|------|---------|
| [XAMPP](https://www.apachefriends.org/) | Local Apache + MySQL + PHP stack |
| [Node.js](https://nodejs.org/) | ^20.19 or ≥22.12 — JavaScript runtime |
| [npm](https://www.npmjs.com/) | Node package manager |

---

## 🏗️ Architecture

The application uses a **fully decoupled SPA architecture**:

```
┌─────────────────────┐         HTTP/JSON          ┌─────────────────────┐
│                     │ ◄─────────────────────────► │                     │
│   Vue 3 SPA         │                             │   Laravel 12 API    │
│   localhost:5173     │    Authorization: Bearer    │   localhost:8000    │
│                     │ ────────────────────────────►│                     │
│  • Vue Router       │                             │  • Sanctum Auth     │
│  • Pinia Stores     │         JSON Response       │  • Eloquent ORM     │
│  • Axios Client     │ ◄────────────────────────── │  • API Resources    │
│  • Tailwind CSS     │                             │  • Form Requests    │
│                     │                             │                     │
└─────────────────────┘                             └────────┬────────────┘
                                                             │
                                                             │ Eloquent
                                                             ▼
                                                    ┌─────────────────────┐
                                                    │                     │
                                                    │   MySQL Database    │
                                                    │   127.0.0.1:3306   │
                                                    │                     │
                                                    │  • users            │
                                                    │  • items            │
                                                    │  • categories       │
                                                    │  • claims           │
                                                    │  • item_images      │
                                                    │                     │
                                                    └─────────────────────┘
```

### API Versioning

All endpoints are prefixed with `/api/v1/` for future-proof versioning.

---

## 📁 Project Structure

```
LOST-AND-FOUND/
│
├── Backend/                          # Laravel 12 API
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Controller.php
│   │   │   │   └── Api/
│   │   │   │       ├── BaseController.php          # Standardized responses
│   │   │   │       └── V1/
│   │   │   │           ├── AuthController.php      # Auth endpoints
│   │   │   │           ├── ItemController.php      # Item CRUD
│   │   │   │           ├── CategoryController.php  # Categories
│   │   │   │           └── ClaimController.php     # Claims
│   │   │   ├── Requests/Api/V1/                    # Form validation
│   │   │   └── Resources/V1/                       # API transformers
│   │   ├── Models/                                  # Eloquent models
│   │   └── Providers/
│   ├── bootstrap/
│   ├── config/
│   │   ├── cors.php                                 # CORS configuration
│   │   └── sanctum.php                              # Sanctum config
│   ├── database/
│   │   ├── factories/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── docs/
│   │   └── API_ARCHITECTURE.md                      # Detailed API docs
│   ├── routes/
│   │   ├── api.php                                  # API route definitions
│   │   ├── auth.php                                 # Auth routes
│   │   └── web.php
│   ├── composer.json
│   └── .env.example
│
├── Frontend/                         # Vue 3 SPA
│   ├── src/
│   │   ├── assets/                                  # CSS, images, SVGs
│   │   ├── components/                              # Reusable Vue components
│   │   │   ├── common/                              # Shared UI components
│   │   │   ├── items/                               # Item-related components
│   │   │   └── auth/                                # Auth components
│   │   ├── lib/
│   │   │   └── axios.js                             # Axios instance + interceptors
│   │   ├── router/
│   │   │   └── index.js                             # Vue Router config + guards
│   │   ├── services/                                # API service layer
│   │   ├── stores/                                  # Pinia state management
│   │   └── views/                                   # Page-level components
│   ├── index.html
│   ├── package.json
│   ├── vite.config.js
│   └── tailwind.config.js
│
├── .gitignore
└── README.md                         # ← You are here
```

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

| Requirement | Version | Check Command |
|-------------|---------|---------------|
| PHP | ≥ 8.2 | `php -v` |
| Composer | ≥ 2.x | `composer -V` |
| Node.js | ^20.19 or ≥22.12 | `node -v` |
| npm | ≥ 10.x | `npm -v` |
| MySQL | ≥ 8.0 | `mysql --version` |
| XAMPP | Latest | — |

---

## 🚀 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/LOST-AND-FOUND.git
cd LOST-AND-FOUND
```

### Backend Setup

```bash
# 1. Navigate to the backend directory
cd Backend

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and configure it
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure your database in .env
#    Update DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Run database migrations
php artisan migrate

# 7. (Optional) Seed the database with sample data
php artisan db:seed

# 8. Start the development server
php artisan serve
```

> 🟢 The API will be available at **http://localhost:8000**

### Frontend Setup

```bash
# 1. Navigate to the frontend directory (from project root)
cd Frontend

# 2. Install Node dependencies
npm install

# 3. Create the environment file
#    Create a .env file with:
#    VITE_API_BASE_URL=http://localhost:8000/api/v1

# 4. Start the development server
npm run dev
```

> 🟢 The SPA will be available at **http://localhost:5173**

### Running Both Servers

For the full development experience, you need **both servers running simultaneously**:

| Terminal | Directory | Command | URL |
|----------|-----------|---------|-----|
| Terminal 1 | `Backend/` | `php artisan serve` | http://localhost:8000 |
| Terminal 2 | `Frontend/` | `npm run dev` | http://localhost:5173 |

---

## ⚙️ Environment Variables

### Backend (`Backend/.env`)

| Variable | Default | Description |
|----------|---------|-------------|
| `APP_NAME` | `Laravel` | Application name |
| `APP_URL` | `http://localhost` | Backend URL |
| `DB_CONNECTION` | `mysql` | Database driver |
| `DB_HOST` | `127.0.0.1` | Database host |
| `DB_PORT` | `3306` | Database port |
| `DB_DATABASE` | `lost_and_found` | Database name |
| `DB_USERNAME` | `root` | Database user |
| `DB_PASSWORD` | _(empty)_ | Database password |
| `FRONTEND_URL` | `http://localhost:5173` | Frontend URL for CORS |
| `SANCTUM_STATEFUL_DOMAINS` | `localhost:5173` | Sanctum stateful domains |
| `SESSION_DOMAIN` | `localhost` | Session cookie domain |

### Frontend (`Frontend/.env`)

| Variable | Default | Description |
|----------|---------|-------------|
| `VITE_API_BASE_URL` | `http://localhost:8000/api/v1` | Backend API base URL |
| `VITE_APP_NAME` | `Lost and Found` | Application display name |

---

## 📡 API Reference

All API endpoints are prefixed with `/api/v1`.

### Authentication

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `POST` | `/auth/register` | ❌ | Register a new user |
| `POST` | `/auth/login` | ❌ | Login and receive token |
| `POST` | `/auth/logout` | ✅ | Revoke current token |
| `GET` | `/auth/user` | ✅ | Get authenticated user profile |

### Items

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| `GET` | `/items` | ❌ | List all items (paginated) |
| `GET` | `/items/{id}` | ❌ | Get a single item |
| `POST` | `/items` | ✅ | Create a new item |
| `PUT` | `/items/{id}` | ✅ | Update an item |
| `DELETE` | `/items/{id}` | ✅ | Delete an item |

### Query Parameters

| Parameter | Example | Description |
|-----------|---------|-------------|
| `search` | `?search=wallet` | Search items by keyword |
| `status` | `?status=lost` | Filter by status |
| `category` | `?category=electronics` | Filter by category |
| `page` | `?page=2` | Pagination page number |
| `per_page` | `?per_page=15` | Items per page |
| `sort_by` | `?sort_by=created_at` | Sort field |
| `sort_dir` | `?sort_dir=desc` | Sort direction |

### Response Format

All responses follow a standardized JSON envelope:

<details>
<summary>✅ Success Response</summary>

```json
{
  "success": true,
  "message": "Items retrieved successfully.",
  "data": {
    "items": [ ... ],
    "pagination": {
      "current_page": 1,
      "last_page": 5,
      "per_page": 15,
      "total": 73
    }
  }
}
```
</details>

<details>
<summary>❌ Error Response</summary>

```json
{
  "success": false,
  "message": "Validation failed.",
  "errors": {
    "title": ["The title field is required."],
    "category_id": ["The selected category is invalid."]
  }
}
```
</details>

<details>
<summary>🔒 Authentication Error</summary>

```json
{
  "success": false,
  "message": "Unauthenticated."
}
```
</details>

### HTTP Status Codes

| Code | Meaning |
|------|---------|
| `200` | OK — Successful request |
| `201` | Created — Resource successfully created |
| `204` | No Content — Successful deletion |
| `400` | Bad Request — Malformed request |
| `401` | Unauthorized — Invalid or missing token |
| `403` | Forbidden — Not authorized for this action |
| `404` | Not Found — Resource doesn't exist |
| `422` | Unprocessable Entity — Validation errors |
| `429` | Too Many Requests — Rate limit exceeded |

> 📖 For the full API architecture documentation, see [`Backend/docs/API_ARCHITECTURE.md`](Backend/docs/API_ARCHITECTURE.md)

---

## 🗄️ Database Schema

```
┌──────────────┐       ┌──────────────┐       ┌──────────────────┐
│    users     │       │  categories  │       │ personal_access  │
├──────────────┤       ├──────────────┤       │    _tokens       │
│ id           │       │ id           │       ├──────────────────┤
│ name         │       │ name         │       │ id               │
│ email        │       │ slug         │       │ tokenable_type   │
│ password     │       │ icon         │       │ tokenable_id     │
│ created_at   │       │ created_at   │       │ name             │
│ updated_at   │       │ updated_at   │       │ token            │
└──────┬───────┘       └──────┬───────┘       │ abilities        │
       │                      │               │ last_used_at     │
       │ 1:N                  │ 1:N           │ expires_at       │
       ▼                      ▼               └──────────────────┘
┌──────────────────────────────────┐
│             items                │
├──────────────────────────────────┤
│ id                               │
│ user_id (FK → users)             │
│ category_id (FK → categories)    │
│ title                            │
│ description                      │
│ type (lost / found)              │
│ status (open / resolved / closed)│
│ location                         │
│ date_occurred                    │
│ contact_info                     │
│ image_path                       │
│ created_at                       │
│ updated_at                       │
└──────────┬───────────────────────┘
           │
     ┌─────┴─────┐
     │ 1:N       │ 1:N
     ▼           ▼
┌────────────┐  ┌────────────┐
│item_images │  │  claims    │
├────────────┤  ├────────────┤
│ id         │  │ id         │
│ item_id FK │  │ item_id FK │
│ image_path │  │ user_id FK │
│ sort_order │  │ message    │
│ created_at │  │ status     │
│ updated_at │  │ created_at │
└────────────┘  │ updated_at │
                └────────────┘
```

---

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. **Fork** the repository
2. **Create** a feature branch: `git checkout -b feature/amazing-feature`
3. **Commit** your changes: `git commit -m 'Add amazing feature'`
4. **Push** to the branch: `git push origin feature/amazing-feature`
5. **Open** a Pull Request

### Development Guidelines

- Follow **PSR-12** coding standards for PHP
- Use **ESLint + Prettier** for JavaScript/Vue (configured in Frontend)
- Write meaningful commit messages
- Keep API responses consistent with the standardized envelope format
- Add appropriate validation via Form Request classes

---

## 📄 License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
  Made with ❤️ for the community
</p>
