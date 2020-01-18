# AyoSekolah Dev Project

1. Change Permission

```
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

2. Create Link Storage

```
php artisan storage:link

```

3. Create Table Schema

```
php artisan migrate

```

4. Clear Cache and Config

```
php artisan config:cache
php artisan config:clear
```
