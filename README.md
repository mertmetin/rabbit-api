# Rabbit API (2020–21)

**The first backend for Rabbit, a grocery delivery service in Ottawa.** A Laravel 8 REST API that the original [customer app](https://github.com/mertmetin/rabbit-app) ran on in 2020–21.

> **Archived.** In 2026 this API was replaced by [rabbit-server](https://github.com/mertmetin/rabbit-server), a TypeScript/Next.js backend that ports this data model to Prisma. This repo is kept to show where the project started.

Part of [Rabbit](https://github.com/mertmetin/rabbit-server): [backend](https://github.com/mertmetin/rabbit-server) · [customer app](https://github.com/mertmetin/rabbit-app) · [driver app](https://github.com/mertmetin/rabbit-driver) · **2021 API**

## What it did

- **Accounts:** registration with an SMS activation code (AWS SNS), JWT login (`tymon/jwt-auth`), password reset by SMS, profile and password changes.
- **Stores:** the closest store to the customer, using MySQL spatial columns and queries (`laravel-mysql-spatial`), and the cities served.
- **Catalogue:** products, categories, inventory per store, promotions and product lists, with **Algolia** search through Laravel Scout.
- **Addresses** with address types.
- **Orders and checkout:** baskets checked against store inventory, orders that can be closed or cancelled, and saved cards through **Stripe**.
- **Admin:** a Voyager back office for managing stores, products and orders.

## Engineering

- **Stack:** PHP 7.3, Laravel 8, MySQL 8 with spatial types, Redis.
- **Services:** Stripe, AWS SNS (SMS), Algolia.
- **Tests:** 41 PHPUnit feature tests across addresses, auth, checkouts, inventory, orders, payments, promotions, search, stores and users.
- **Local environment:** Docker Compose with the API, Nginx, MySQL (app and test databases), Redis and MailHog.

## What the 2026 rewrite changed

Looking back at this code from the rewrite:
- **Inventory endpoints had no authentication.** In `routes/api.php`, creating, updating and deleting inventory sat outside the `auth:api` group. In [rabbit-server](https://github.com/mertmetin/rabbit-server) stock changes are admin-only.
- **Card charging moved to authorise-then-capture**, so customers pay only for what the driver actually finds.
- **Search moved in-house** (MySQL), dropping the Algolia dependency for a catalogue of this size.
- **Secrets moved out of the code:** an early version of the app had AWS keys pasted in comments; the new stack reads every secret from AWS SSM, and CI deploys through OIDC without stored keys.

## Run locally (historical)

```bash
cp .env.example .env
docker-compose up -d
docker-compose exec api composer install
docker-compose exec api php artisan key:generate
docker-compose exec api php artisan migrate --seed
docker-compose exec api php artisan test
```
