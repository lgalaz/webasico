@servers(['carlitos_server' => ['ubuntongo@webasico.com']])

@task('deploy', ['on' => 'carlitos_server'])
    cd webasico
    git reset --hard HEAD
    git fetch
    git checkout master
    git pull
    composer clearcache
    composer install --no-dev --no-progress --prefer-dist
    php artisan migrate:fresh --force --no-interaction
    php artisan db:seed --force --no-interaction
    php artisan ziggy:generate "resources/js/ziggy.js"
    npm install --only=production
    npm run prod
@endtask