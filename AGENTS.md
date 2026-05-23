# LOST AND FOUND

## Project Structure & Module Organization

This repository is split into two applications. `Backend/` contains the Laravel 12 API: controllers in `app/Http/Controllers`, requests in `app/Http/Requests`, models in `app/Models`, routes in `routes/`, database files in `database/`, and docs in `docs/`. `Frontend/` contains the Vue 3 app: views in `src/views`, layouts in `src/Layout`, router setup in `src/router`, components in `src/components`, stores in `src/stores`, and styles/assets in `src/assets`.

## Tech Stack

- Laravel 12
- Vue 3
- Tailwind
- MySQL

## Build, Test, and Development Commands

Run commands from the relevant app directory:

- `cd Backend && composer install && npm install`: install deps.
- `cd Backend && php artisan migrate --seed`: create and seed database tables.
- `cd Backend && composer run dev`: run Laravel, queue, logs, and Vite.
- `cd Backend && php artisan test`: run PHPUnit.
- `cd Backend && ./vendor/bin/pint`: format PHP.
- `cd Frontend && npm install`: install Vue deps.
- `cd Frontend && npm run dev`: start Vite.
- `cd Frontend && npm run build`: production build.
- `cd Frontend && npm run lint`: run Oxlint and ESLint with fixes.
- `cd Frontend && npm run format`: format `src/` with Prettier.

## Coding Style & Naming Conventions

Use Laravel conventions in `Backend`: PSR-4 namespaces, StudlyCase classes, singular Eloquent models, and descriptive controller/request names such as `AuthController` and `UserLoginRequest`. Keep API endpoints under `routes/api.php`. Use Laravel Pint defaults.

Use Vue single-file components in `Frontend`, with PascalCase component and layout names such as `MainLayout.vue`. Keep route-level views in `src/views`, shared UI in `src/components`, and Pinia stores in `src/stores`.

## Testing Guidelines

Backend tests are configured through `Backend/phpunit.xml` with `tests/Unit` and `tests/Feature` suites. Add feature tests for API behavior and unit tests for isolated service/model logic. Name tests after behavior, for example `AuthLoginTest.php`.

No frontend test framework is configured. For frontend changes, run `npm run lint`, `npm run build`, and verify affected views.

## Commit & Pull Request Guidelines

Recent history uses short subjects such as `Initial commit: Laravel 12 Backend + Vue 3 Frontend` and `New Update`. Prefer specific imperative subjects, for example `Add claim status validation`.

Pull requests should include a summary, linked issue when available, setup or migration notes, test results, and screenshots for UI changes. Keep backend and frontend changes separated when practical.

## Security & Configuration Tips

Do not commit `.env`, generated caches, logs, or local database files. Keep secrets in environment variables. For API changes, verify Sanctum authentication, validation, and CORS behavior.
