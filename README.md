# 📰 Simple News App

A backend system built with Laravel for aggregating news articles from multiple external providers (e.g. NewsAPI, The Guardian, The New York Times).

The system normalizes external data, stores it in a unified structure, and exposes it through a consistent REST API with support for filtering, search, and user preferences.

---

## 📚 API Documentation

Full API documentation (Postman collection):  
👉 https://documenter.getpostman.com/view/6359426/2sBY4HV4bM

---

## 🚀 Tech Stack

- PHP 8+
- Laravel 13
- PostgreSQL
- Laravel HTTP Client
- Laravel Queues
- Laravel Scheduler
- PHPUnit (Feature & Unit Testing)
- Docker (Laravel Sail)

---

## 🧠 Architecture Overview

The system follows a **layered architecture with separation of concerns**:

### 1. External Providers Layer
Each news provider (e.g. Guardian, NewsAPI) implements a shared interface:

- `NewsProviderInterface`
- `GuardianProvider`, `NewsApiProvider`, etc.

Responsibilities:
- Fetch raw API data
- Transform raw payload → `ArticleDTO`

---

### 2. Data Transfer Layer (DTO)
`ArticleDTO` acts as a normalized contract between providers and the domain.

Benefits:
- consistent data structure
- isolation from external APIs
- improved testability

---

### 3. Ingestion Layer
`ArticleIngestionService`:
- persists articles
- resolves authors
- syncs categories
- ensures idempotency (`slug + source_id`, `external_id` can be used but some providers don't return id like News API provider.)

---

### 4. Repository Layer
`ArticleRepository`:
- encapsulates query logic
- supports filtering
- handles pagination
- eager loads relationships

---

### 5. API Layer
- `ArticleController`
- `ArticleResource`

Provides clean and consistent JSON responses.

---

### 6. Async Processing
- `news:sync` command
- queued jobs (`news-sync` queue)
- scheduled execution every 15 minutes

---

## 🧪 Tests

Run all tests:
![test results](tests.png)

```bash
php artisan test