## Server notes

### How to clear logs on server

```
truncate -s 0 laravel.log
```

### Cron job set up

**`/etc/cron.d/shareiftar`**
```
* * * * * root php /var/www/shareiftar.org/current/artisan schedule:run >> /dev/null 2>&1
```
