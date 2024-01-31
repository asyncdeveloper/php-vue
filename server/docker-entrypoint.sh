#!/bin/sh

# Do first-time setup steps that can't be done in the Dockerfile
cp .env.example .env
composer install


# Run the main container command
exec "$@"