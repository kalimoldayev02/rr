#!/bin/sh
cp .env.sample .env

echo "Running database migrations"
php app.php migrate

echo "Cache clear"
php app.php cache:clean

echo "Generate encrypt key"
php app.php encrypt:key

echo "Starting RoadRunner server..."
exec rr serve -c .rr.yaml