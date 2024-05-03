cp .env.example .env

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs


./vendor/bin/sail up -d

./vendor/bin/sail npm install
./vendor/bin/sail npm run build

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate --path=database/migrations/landlord


