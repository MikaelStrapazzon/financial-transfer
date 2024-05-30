# Install dependencies
if [ ! -f "./composer.phar" ]; then
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
  php composer-setup.php --version=2.4.4
  php -r "unlink('composer-setup.php');"
fi
php composer.phar install

# Generate .env
if [ ! -f "./.env" ]; then
  cp .env.example .env
  php artisan key:generate
fi

php artisan migrate
# php artisan db:seed

# Server up Laravel
php artisan serve --host 0.0.0.0 --port=7001 &

# Up consumer email send
php artisan app:process-queue-email
