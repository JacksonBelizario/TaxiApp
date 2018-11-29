# taxiapp

## Client setup
```
yarn install
```

### Compiles and hot-reloads for development
```
yarn run serve
```

### Compiles and minifies for production
```
yarn run build
```

### Lints and fixes files
```
yarn run lint
```
### Iniciar Postgres
```
sudo systemctl start postgresql
```

### Server setup
```
cd server
composer install
```

### Criar tabelas no servidor
```
php artisan migrate
```

### Iniciar Servidor PHP
```
cd server/public
php -S localhost:8000 -t public
```