# Use https://jbaysolutions.github.io/vue-grid-layout/guide/
# should softdelete accounts and websites

#Local setup
- Use `php artisan migrate:fresh --seed` So it runs seeders after the migration.
- Login as an admin with `admin@webasico.com` and password `Ar1zp3!` (Created in TestUsersSeeder.php)

#Deployment instructions

- make sure to export composers bin if you want to use envoy: 
`export PATH="$PATH:$HOME/.composer/vendor/bin"`

- `cp .env.example .env`

- `php artisan key:generate`

- migrate the database `php artisan migrate`

- You need to have the routes created for Vue.js to use `php artisan ziggy:generate "resources/js/ziggy.js"`

- if you are using mysql >7.x you might get an error if trying to use root for the database. You need to create a user with mysql_native_password. E.g:
```
CREATE USER 'webasico'@'localhost' IDENTIFIED WITH mysql_native_password BY 'webasico';
GRANT ALL PRIVILEGES ON webasico.* TO 'webasico'@'localhost';
FLUSH PRIVILEGES;
```

- Update all env variables.
 - Update `APP_DOMAIN=webasico.test`
 - DB variables:
 ```
  DB_DATABASE=webasico
  DB_USERNAME=webasico
  DB_PASSWORD=webasico`
 ```

#Testing

- We are using sqlite for tests. 

- We need a `dump.sqlite` file to exist in the database directory because the `ResetsDatabase` trait will copy the dump file as `database.sqlite` so that we have a fresh database on each test run. See `sqlite_dump` connection in `config/database.php`
  For this we can create the dump file with `touch dump.sqlite`. We need to make sure that the file has read write permissions (`chmod 775 dump.sqlite`).

- Before every test run we need to ensure that the dump file is up to date. 
  We can migrate the most recent dump as (need to add env testing cause telescope fails):
  `php artisan migrate:fresh --seed --database=sqlite_dump --env=testing`

