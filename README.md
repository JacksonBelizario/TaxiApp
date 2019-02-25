# TaxiApp

[![Login Page](https://raw.githubusercontent.com/JacksonBelizario/TaxiApp/master/docs/Screenshot_TaxiApp_1.png)](https://raw.githubusercontent.com/JacksonBelizario/TaxiApp/master/docs/Screenshot_TaxiApp_1.png) [![Main Page](https://raw.githubusercontent.com/JacksonBelizario/TaxiApp/master/docs/Screenshot_TaxiApp_2.png)](https://raw.githubusercontent.com/JacksonBelizario/TaxiApp/master/docs/Screenshot_TaxiApp_2.png)

[![Search Location Page](https://raw.githubusercontent.com/JacksonBelizario/TaxiApp/master/docs/Screenshot_TaxiApp_3.png)](https://raw.githubusercontent.com/JacksonBelizario/TaxiApp/master/docs/Screenshot_TaxiApp_3.png) [![Example Page](https://raw.githubusercontent.com/JacksonBelizario/TaxiApp/master/docs/Screenshot_TaxiApp_4.png)](https://raw.githubusercontent.com/JacksonBelizario/TaxiApp/master/docs/Screenshot_TaxiApp_4.png)

Conceptual Project for College Work (Like Uber) (Unfinished)

Project with Vue.Js and Laravel

## Client setup
```
cd client
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

### Make tables on database
```
php artisan migrate
```

### Start PHP
```
cd server/public
php -S localhost:8000 -t public
```
