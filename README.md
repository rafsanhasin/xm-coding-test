## About This Project
- Laravel Version `8.75`
- PHP Version `8.3`

## Instruction to run this project
- COPY `.env.example` to `.env`
- COPY `docker-compose-example.yaml` to `docker-compose-example.yaml` and configure http port
- RUN `docker-compose build && docker-compose up`
- RUN `docker-exec -it <php-container-name> /bin/bash`
- RUN `composer install` inside container

Now the application should be ready to use

## Tests
- RUN `php artisan config:clear` inside container
- RUN `php artisan test` inside container

## Remarks
- Added cache on both API fetch. For now `ttl` value is static. 
- Implemented queued event-driver mail sending service.
- Couldn't test mail sending for configuration difficulties.

If you face any difficulty running this project please send me an email at `rafsanhasin@gmail.com`
