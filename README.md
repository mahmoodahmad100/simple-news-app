# 📰 Simple News App

A backend system built with Laravel for aggregating news articles from multiple external providers (NewsAPI, The Guardian, The New York Times ...etc). The system normalizes, stores, and serves articles through a unified API with support for search, filtering, and user preferences.

---

## 🚀 Tech Stack

...

---

## 🧠 Architecture Overview

...

---

## Improvements

## 🔐 User Preferences Storage

User preferences (sources, categories, and authors) are stored as a JSON column in the `users` table.

This approach keeps the data model simple while providing enough flexibility to support personalization and filtering within the current scope of the application.

In a more advanced or large-scale system, this would typically be normalized into dedicated pivot tables to improve relational integrity and enable more complex querying and analytics.