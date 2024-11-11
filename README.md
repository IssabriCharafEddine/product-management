# Product Management System

A Laravel-based product management system with support for CSV imports, API synchronization, and efficient product processing.

## Features

- Import products from CSV files
- Sync products with external API
- Support for product variations with quantity tracking
- Soft deletion of outdated products
- Queue-based processing for better performance
- Complete REST API
- Dockerized development environment

## Requirements

- Docker and Docker Compose
- PHP 8.2+
- Composer
- MySQL 8.0

## Installation

1. Clone the repository:
```bash
cd product-management
```

2. Copy the environment file:
```bash
cp .env.example .env
```

3. Start the Docker environment:
```bash
docker-compose up --build
```

4. Install dependencies:
```bash
docker-compose exec app composer install
```

5. Generate application key:
```bash
docker-compose exec app php artisan key:generate
```

6. Run migrations:
```bash
docker-compose exec app php artisan migrate
```

## Usage
this commands to use the file for test
```bash

docker exec -it product_management_app mkdir -p /var/www/storage/app/private

docker cp ~/product-management/products.csv product_management_app:/var/www/storage/app/private/products.csv
```


### Importing Products

1. From CSV:
```bash
docker-compose exec app php artisan products:import csv --file=products.csv
```

2. From API:
```bash
docker-compose exec app php artisan products:import api
```

### API Endpoints

- GET `/api/products` - List all products
- GET `/api/products/{id}` - Get single product
- POST `/api/products` - Create new product
- PUT `/api/products/{id}` - Update product
- DELETE `/api/products/{id}` - Delete product

### Automated Tasks

The system automatically synchronizes with the external API daily at midnight. Make sure the Laravel scheduler is running:

```bash
docker-compose exec app php artisan schedule:work
```

### Queue Processing

The system uses Redis for queue processing. Start the queue worker:

```bash
docker-compose exec app php artisan queue:work
```

## Testing

Run the test suite:

```bash
docker-compose exec app php artisan test
```

## Architecture

### Database Structure

- `products` table: Stores basic product information
- `product_variations` table: Stores variation-specific data including quantity

### Key Components

1. Importers:
   - `CsvProductImporter`: Handles CSV file imports
   - `ApiProductImporter`: Handles API synchronization

2. Services:
   - `ProductSynchronizer`: Manages product synchronization logic

3. Jobs:
   - `ProcessProductImport`: Handles individual product processing
   - Various notification jobs for external integrations

### Performance Optimizations

1. Queue-based Processing:
   - All time-consuming operations are processed in the background
   - Redis is used as the queue driver for better performance

2. Batch Processing:
   - Products are processed in parallel using Laravel's job system
   - Database operations are wrapped in transactions

3. Efficient Database Design:
   - Proper indexing on frequently queried columns
   - Separate table for variations to improve query performance
