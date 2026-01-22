# TORCH - Custom Art Services and E-commerce Platform

A Laravel-based art marketplace connecting artists and clients for artwork sales and commission services.

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- npm
- SQLite (default) or MySQL/PostgreSQL

## Quick Start

```bash
# Clone repository
git clone https://github.com/LeslerJohn/TORCH-Custom-Art-Services.git
cd TORCH-Custom-Art-Services

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database and run migrations
touch database/database.sqlite
php artisan migrate

# Create storage symlink
php artisan storage:link

# Seed the database (choose one)
php artisan db:seed                              # Basic: admin + categories/tags only
php artisan db:seed --class=ComprehensiveSeeder  # Full demo data

# Start development server
composer run dev
```

---

## Environment Configuration

Copy `.env.example` to `.env` and configure the following sections:

### Application Settings

```env
APP_NAME=TORCH
APP_ENV=local
APP_DEBUG=true
APP_TIMEZONE=Asia/Manila
APP_URL=http://localhost:8000
```

### Database Configuration

**SQLite (Default)**

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

**MySQL**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=torchv2
DB_USERNAME=root
DB_PASSWORD=your-password
```

### Mail Configuration (Mailgun)

```env
MAIL_MAILER=mailgun
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
MAILGUN_DOMAIN=your-mailgun-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-api-key
```

> Get credentials from [Mailgun Dashboard](https://app.mailgun.com/)

### Payment Configuration (Xendit)

```env
XENDIT_SECRET_KEY=xnd_development_xxxx
XENDIT_PUBLIC_KEY=xnd_public_development_xxxx
XENDIT_WEBHOOK_VERIFICATION_TOKEN=your-webhook-token
AUTH_PAY=your-auth-pay-key
```

> Get credentials from [Xendit Dashboard](https://dashboard.xendit.co/)

### Google OAuth Configuration

```env
GOOGLE_CLIENT_ID=your-google-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

> Configure at [Google Cloud Console](https://console.cloud.google.com/apis/credentials)

---

## Database Seeding

### Seeder Options

| Command                                           | Description                                                                   |
| ------------------------------------------------- | ----------------------------------------------------------------------------- |
| `php artisan db:seed`                             | Default seeder: Admin user + Categories/Tags                                  |
| `php artisan db:seed --class=ComprehensiveSeeder` | Full demo data with artists, clients, artworks, services, orders, commissions |
| `php artisan db:seed --class=BasicSeeder`         | Minimal: 3 users only (Admin, Artist, Client)                                 |

### Fresh Migration with Seeding

```bash
# Reset database and seed with comprehensive data
php artisan migrate:fresh && php artisan db:seed --class=ComprehensiveSeeder
```

### Seeded User Credentials

All users have password: `password`

| Role   | Email                       | Name                   |
| ------ | --------------------------- | ---------------------- |
| Admin  | admin@gmail.com             | Admin User             |
| Artist | maria.santos@example.com    | Maria Clara Santos     |
| Artist | juan.delacruz@example.com   | Juan Paulo dela Cruz   |
| Artist | ana.reyes@example.com       | Ana Marie Reyes        |
| Artist | miguel.bautista@example.com | Miguel Angelo Bautista |
| Artist | sofia.cruz@example.com      | Sofia Isabelle Cruz    |
| Client | pedro.gonzales@example.com  | Pedro Jose Gonzales    |
| Client | rosa.villanueva@example.com | Rosa Maria Villanueva  |
| Client | carlos.mendoza@example.com  | Carlos Miguel Mendoza  |
| Client | isabella.tan@example.com    | Isabella Grace Tan     |
| Client | antonio.garcia@example.com  | Antonio Luis Garcia    |

### Comprehensive Seeder Includes

- 5 Artists with complete profiles, payment accounts, and tags
- 9 Services (1-2 per artist) with images and tags
- 17 Artworks with images, tags, and showcases
- 5 Clients with addresses and carts
- 2 Completed orders with payments, payouts, and reviews
- 2 Commissions (1 completed, 1 in-progress) with drafts and payments

---

## Storage Setup

Laravel requires a symbolic link from `public/storage` to `storage/app/public`:

```bash
php artisan storage:link
```

### Storage Structure

```
storage/app/public/
├── profiles/      # User profile images
├── covers/        # Artist cover images
├── services/      # Service images
├── artworks/      # Artwork images
├── references/    # Commission reference images
└── drafts/        # Commission draft images
```

### Sample Image for Seeding

Place a sample image at `public/images/anime-girl.jpg` before running seeders.

---

## Running the Application

### Development (Recommended)

Starts server, queue worker, logs, and Vite in parallel:

```bash
composer run dev
```

### Manual Start

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Queue worker (for emails/notifications)
php artisan queue:listen --tries=1

# Terminal 3: Vite dev server
npm run dev

# Terminal 4: Logs (optional)
php artisan pail --timeout=0
```

### Production Build

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Payment Integration (Xendit)

This project uses [Xendivel](https://github.com/glennraya/xendivel) for Xendit payment integration.

### Supported Payment Methods

- GCash
- PayMaya
- Bank Transfer
- Credit/Debit Cards

### Webhook Configuration

1. Set your webhook URL in Xendit Dashboard: `https://yourdomain.com/xendit/webhook`
2. Copy the verification token to `.env`:
    ```env
    XENDIT_WEBHOOK_VERIFICATION_TOKEN=your-token
    ```

### Testing Payments

Use Xendit's test mode credentials for development. Switch to live credentials for production.

---

## Mail Integration

### Mailgun Setup

1. Create a Mailgun account at [mailgun.com](https://www.mailgun.com/)
2. Add and verify your domain
3. Get API credentials from the dashboard
4. Update `.env`:
    ```env
    MAIL_MAILER=mailgun
    MAILGUN_DOMAIN=mg.yourdomain.com
    MAILGUN_SECRET=key-xxxxxxxxxxxxx
    ```

### Queue Configuration

Emails are queued by default. Ensure the queue worker is running:

```bash
php artisan queue:listen
```

---

## Google OAuth

### Setup Steps

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add authorized redirect URI: `http://127.0.0.1:8000/auth/google/callback`
6. Copy Client ID and Secret to `.env`

---

## Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run tests
php artisan test

# Check routes
php artisan route:list

# Run queue worker
php artisan queue:work

# View logs
php artisan pail
```

---

## Troubleshooting

### Storage Link Issues

If images don't load, recreate the storage link:

```bash
# Windows
rmdir public\storage
php artisan storage:link

# Linux/Mac
rm public/storage
php artisan storage:link
```

### Permission Issues (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Queue Not Processing

Ensure queue worker is running:

```bash
php artisan queue:listen --tries=3
```

### Database Reset

```bash
php artisan migrate:fresh --seed
```

---

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade, Alpine.js, Tailwind CSS, Flowbite
- **Database**: SQLite/MySQL
- **Payments**: Xendit (via Xendivel)
- **Mail**: Mailgun
- **Authentication**: Laravel Breeze, Laravel Socialite (Google OAuth)
- **Queue**: Database driver

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
