# Backend - YouTube Clone API

REST API built with Laravel 11 for a YouTube-like platform. Handles users, channels, videos, comments with nested replies, likes, subscriptions, and view history. Thumbnails are uploaded as images; video files are not supported.

## Requirements

- PHP 8.2+
- Composer
- MySQL 8+
- Laravel 11

## Installation

git clone <repo-url> backend
cd backend
composer install
cp .env.example .env
php artisan key:generate

Configure database credentials in .env, then:

php artisan migrate --seed
php artisan storage:link

## Environment

Key variables:

- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- SANCTUM_STATEFUL_DOMAINS
- FILESYSTEM_DISK=public

## Authentication

Token-based via Laravel Sanctum. Send the token in every authenticated request:

Authorization: Bearer <token>
Accept: application/json

Endpoints:

- POST /api/register
- POST /api/login
- POST /api/logout
- GET  /api/me

## Main Endpoints

Users

- GET    /api/users
- GET    /api/users/{user}
- PUT    /api/users/{user}
- DELETE /api/users/{user}

Videos

- GET    /api/videos
- POST   /api/videos
- GET    /api/videos/{video}
- PUT    /api/videos/{video}
- DELETE /api/videos/{video}

Comments

- GET    /api/videos/{video}/comments
- POST   /api/comments
- PUT    /api/comments/{comment}
- DELETE /api/comments/{comment}

Replies use the same POST /api/comments endpoint with comment_id instead of video_id.

Interactions

- POST /api/videos/{video}/like
- POST /api/channels/{user}/subscribe
- GET  /api/history

## Architecture

- Controllers: thin, delegate validation to FormRequests, formatting to Resources
- Resources: control exposed fields via whenLoaded and whenCounted
- Policies: ownership checks for update and delete on User, Video, Comment
- Relations: pivot tables for likes, subscriptions, video_views
- Soft deletes: applied to User, Video, Comment

## Testing

Pest is used for feature tests. Run:

php artisan test

Tests use SQLite in memory via phpunit.xml. Development database is untouched.

Key helper in tests/Pest.php:

actingAsUser()

## Storage

Thumbnails are stored on the public disk at storage/app/public/thumbnails. Accessible via /storage/thumbnails/{file}. The public disk must be linked:

php artisan storage:link

## Project Structure

app/
  Http/Controllers
  Http/Requests
  Http/Resources
  Models
  Policies
database/
  factories
  migrations
  seeders
routes/
  api.php
tests/
  Feature
  Pest.php

## Notes

- All responses are JSON.
- 401 for unauthenticated, 403 for forbidden, 404 for missing, 422 for validation errors.
- Video views are counted only for authenticated users.
- Comment replies are limited to one level.
- Categories are read-only through the API.