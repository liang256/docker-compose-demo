@servers([ 'localhost' =>  '127.0.0.1'])

@task('production')

   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan optimize
   composer dump-autoload --optimize

   supervisord -c ./supervisord.conf
   supervisorctl start laravel-php-fpm
   supervisorctl start nginx

   {{--進程永恆--}}
   tail -f /dev/null
@endtask


@task('php-fpm')
    supervisorctl start laravel-php-fpm
@endtask
