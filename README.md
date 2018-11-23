# taxiapp

## Project setup
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

### Criar tabelas no servidor
```
cd server
php artisan migrate
```

### Iniciar Servidor PHP
```
cd server/public
php -S localhost:8000 -t public
```