## Setup

### create .env and set vars
```bash
cp .env.example .env
```

### install composer dependencies
```bash
composer install
```

### run migrations
```bash
php artisan migrate
```

### create admin
```bash
php artisan admin:create
```

### install npm dependencies
```bash
npm install
```

### build front-end
```bash
npm run build
```

### create storage link
```bash
php artisan storage:link
```

Admin Panel path - /admin