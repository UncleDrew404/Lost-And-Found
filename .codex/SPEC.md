# Lost & Found — Codebase Assessment & Next Steps

## Current State Summary

### Backend (Laravel 12) — ~85% Complete

| Area | Status | Notes |
|------|--------|-------|
| Models | Done | User, UserProfile, Category, Item, ItemImage, Claim — all with relationships |
| Migrations | Done | 10 migrations covering all tables |
| Auth (Sanctum) | Done | Register, login, logout working; HasApiTokens on User |
| Item CRUD | Done | Full RESTful controller with auth ownership checks |
| User Controller | Partial | Only index — missing profile update, single user fetch |
| Requests | Done | Validated for auth + items |
| Factories | Done | All models have factories |
| Seeders | Done | Category, User, Item, Claim, ItemImage |
| Routes | Done | v1 prefixed, auth-protected where needed |
| Rate Limiting | Done | api:60/min, auth:5/min |
| Exception Handling | Done | JSON responses for API errors |
| CORS | Done | Configured in bootstrap/app.php |
| Tests | ❌ None | phpunit.xml exists but tests/ is empty |
| Sanctum Guard | Done | `sanctum` guard not registered in `config/auth.php` |
| API Resources | Missing | No transformation layer — raw models returned |
| Claims API | Missing | No controller, routes, or requests for claims |
| User Profile API | Missing | No endpoints to update/read user profiles |
| Public Item Browsing | Locked | GET /items requires auth — should be public |

### Frontend (Vue 3) — ~5% Complete

| Area | Status | Notes |
|------|--------|-------|
| Project Setup | Done | Vue 3 + Vite + Pinia + Tailwind + Router configured |
| Layouts | Empty shells | AuthLayout.vue and MainLayout.vue exist but are blank |
| Views | Scaffolding | Only HomeView and AboutView (default Vite template) |
| Router | Scaffolding | Only `/` and `/about` routes |
| Components | Scaffolding | HelloWorld, TheWelcome, WelcomeItem (default template) |
| Stores | Scaffolding | Only counter.js (default template) |
| Auth System | ❌ None | No login/register views, no auth store, no axios |
| Item Browsing | ❌ None | No item list, detail, or creation views |
| API Integration | ❌ None | Axios not installed, no service layer, no .env |
| Navigation | ❌ None | No nav bar, no auth-aware routing |

---

## Recommended Next Steps (Priority Order)

### Phase 1: Backend Fixes & Gaps

| # | Task | Effort | Why |
|---|------|--------|-----|
| 1.1 | Add `sanctum` guard to `config/auth.php` | S | Auth middleware uses `auth:sanctum` but guard doesn't exist — routes may fail |
| 1.2 | Make GET /items and /items/{id} public | S | Users must browse items without logging in first |
| 1.3 | Add `GET /api/v1/auth/user` endpoint | S | Frontend needs current-user endpoint for session restore |
| 1.4 | Create API Resource classes (ItemResource, UserResource, CategoryResource) | M | Standardize JSON output; hide sensitive fields (especially on User) |
| 1.5 | Add Claims controller + routes + requests | M | Core feature — users need to claim found items |
| 1.6 | Add User Profile endpoints (GET/PUT /api/v1/profile) | M | Users need to manage their profile info |
| 1.7 | Add Categories endpoint (GET /api/v1/categories) | S | Frontend needs category list for item forms and filters |
| 1.8 | Add item filtering/query support (status, type, category, search) | M | Public browsing needs filtering |
| 1.9 | Add pagination to GET /items | S | Prevent returning massive datasets |
| 1.10 | Write Feature tests for auth, items, claims | L | Zero test coverage currently |

### Phase 2: Frontend Foundation

| # | Task | Effort | Why |
|---|------|--------|-----|
| 2.1 | Install axios; create `src/lib/axios.js` with interceptors | S | Foundation for all API calls |
| 2.2 | Create `src/stores/auth.js` Pinia store | M | Token management, login/register/logout, session persistence |
| 2.3 | Create `Frontend/.env` with `VITE_API_BASE_URL` | S | Configure API endpoint |
| 2.4 | Create Login and Register views + components | M | Entry point for users |
| 2.5 | Build MainLayout with nav bar and auth-aware routing | M | Consistent layout with login/logout controls |
| 2.6 | Add router guards (guest vs auth routes) | S | Protect routes, redirect unauthenticated users |
| 2.7 | Create API service layer (`src/services/`) | M | Organize API calls per resource |

### Phase 3: Frontend Features

| # | Task | Effort | Why |
|---|------|--------|-----|
| 3.1 | Build Item list view with cards, filters, pagination | L | Main browsing experience |
| 3.2 | Build Item detail view | M | View full item info + claim button |
| 3.3 | Build Item create/edit form | L | Users report lost/found items |
| 3.4 | Build Claim submission flow | M | Users claim found items |
| 3.5 | Build User profile page | M | View and edit profile |
| 3.6 | Build Dashboard/My Items view | M | Users manage their own items and claims |

---

## Critical Issues to Fix First

1. **Sanctum guard missing** — `config/auth.php` has no `sanctum` guard, but routes use `auth:sanctum` middleware. Add:
   ```php
   'api' => [
       'driver' => 'sanctum',
       'provider' => 'users',
   ],
   ```

2. **Items locked behind auth** — `routes/api.php:17` protects the entire Item resource behind auth, so `GET /api/v1/items` requires a token. Move `index` and `show` outside the auth group.

3. **Register doesn't return a token** — `AuthController@register` returns user data but no token, unlike login. Users can't use the API immediately after registration.

4. **Tests directory is empty** — `phpunit.xml` is configured but `tests/Feature/` and `tests/Unit/` directories don't exist. At minimum, auth tests are needed.

---

## Suggested Approach

Start with **Phase 1.1–1.4** (1–2 hours) to fix critical backend gaps, then switch to **Phase 2.1–2.6** (3–4 hours) to get the frontend auth flow working end-to-end. After that, the app is functional for browsing and reporting items (Phases 1.5–1.10 and 3.1–3.6).

Which phase should I begin implementing?
