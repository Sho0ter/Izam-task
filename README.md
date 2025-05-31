# E-commerce Platform

A full-stack e-commerce platform built with Laravel (Backend) and React (Frontend).

## Features

- User authentication (Register/Login)
- Product catalog with categories
- Shopping cart functionality
- Order management
- Admin dashboard
- Responsive design

## Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: React 18, React Router 6
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **API**: RESTful API

## Prerequisites

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- MySQL >= 8.0
- npm

## Installation with Docker

### Prerequisites

- Docker and Docker Compose installed on your system
- Git

### Setup Instructions

1. Clone the repository:
   ```bash
   git clone [your-repository-url]
   cd FullStackDeveloperTestTask
   ```

2. Create a `.env` file by copying the example:
   ```bash
   cp backend/.env.example backend/.env
   ```

3. Make the setup scripts executable:
   ```bash
   chmod +x setup.sh docker-entrypoint.sh
   ```

4. Start the Docker containers:
   ```bash
   docker-compose up -d
   ```

5. The containers will automatically run the setup process which includes:
   - Installing PHP dependencies
   - Generating application key (if not exists)
   - Setting proper file permissions
   - Running database migrations
   - Creating storage link
   - Caching configuration

6. Monitor the setup process:
   ```bash
   docker-compose logs -f app
   ```
   
   Wait until you see "Setup complete!" in the logs.

### Manual Setup (if needed)

If you need to run setup steps manually:

1. Install PHP dependencies:
   ```bash
   docker-compose exec app composer install
   ```

2. Generate application key:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

3. Run database migrations and seeders:
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

4. Generate storage link:
   ```bash
   docker-compose exec app php artisan storage:link
   ```

5. Set proper permissions:
   ```bash
   docker-compose exec app chown -R www-data:www-data /var/www/storage
   docker-compose exec app chmod -R 775 /var/www/storage
   ```

### Accessing the Application

- **Frontend Application**: http://localhost:3000
  - **User Login**:
    - Email: user@user.com
    - Password: password
- **Backend API**: http://localhost:8001
- **phpMyAdmin**: http://localhost:8080
  - Username: laravel_user
  - Password: secret
  - Server: mysql

### Common Docker Commands

- Start containers: `docker-compose up -d`
- Stop containers: `docker-compose down`
- View logs: `docker-compose logs -f`
- Run Artisan commands: `docker-compose exec app php artisan [command]`
- Run Composer: `docker-compose exec app composer [command]`
- Access container shell: `docker-compose exec app bash`

### Frontend Development

If you need to work on the frontend separately:

1. Navigate to the resources/js directory:
   ```bash
   cd backend/resources/js
   ```

2. Install dependencies and start the development server:
   ```bash
   npm install
   npm run dev
   ```

   The frontend will be available at http://localhost:3000

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user

### Products
- `GET /api/products` - Get all products (paginated)
- `GET /api/products/{id}` - Get single product
- `POST /api/products` - Create new product (admin)
- `PUT /api/products/{id}` - Update product (admin)
- `DELETE /api/products/{id}` - Delete product (admin)

### Orders
- `GET /api/orders` - Get user's orders
- `GET /api/orders/{id}` - Get order details
- `POST /api/orders` - Create new order
- `DELETE /api/orders/{id}` - Cancel order

## Environment Variables

### Backend (.env)
```env
APP_NAME="E-commerce"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8001

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=laravel
DB_USERNAME=laravel_user
DB_PASSWORD=secret

MAIL_MAILER=log
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"

QUEUE_CONNECTION=database
```

## Project Structure

```
backend/
├── app/                  # Application code
│   ├── Console/          # Artisan commands
│   ├── Http/             # Controllers, Middleware, Requests
│   ├── Models/           # Eloquent models
│   ├── Repository/       # Repository pattern implementation
│   └── ...
├── config/              # Configuration files
├── database/
│   ├── factories/       # Model factories
│   ├── migrations/       # Database migrations
│   └── seeders/         # Database seeders
├── public/              # Publicly accessible files
├── resources/
│   └── js/             # Frontend assets (React)
├── routes/              # API routes
└── ...

resources/js/
├── public/             # Static files
└── src/
    ├── components/      # Reusable components
    ├── views/           # Page components
    ├── App.jsx          # Root component
    ├── main.jsx         # Entry point
    └── router.jsx       # Application routes
```


## Deployment

### Backend

1. Set up a web server (Nginx/Apache)
2. Configure the environment for production
3. Run:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan migrate --force
   ```

### Frontend

1. Build for production:
   ```bash
   npm run build
   ```

2. Deploy the `build` directory to your web server

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
