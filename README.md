# DiZ-Guide

## Technology Stack

-   https://laravel.com/
-   https://vuejs.org/
-   https://inertiajs.com/
-   https://tailwindcss.com/

## Development Setup

1. Create the `.env` file. Check the `.env.example file for reference`.

2. Create the `.npmrc` file to be able to install the `@hfh-dlc/hfh-styleguide` package.

3. Install the php dependencies with `composer install`.

4. Run the laravel migrations with `php artisan migrate`.

5. Run the frontend with `pnpm dev`.

6. Start the development server with `php artisan serve`.

To run the php tests, use `php artisan test`.
To run the js tests, use `npm run test`.

## Production Setup

1. Create the `.env` file. Check the `.env.example file for reference`.

2. Create the `.npmrc` file to be able to install the `@hfh-dlc/hfh-styleguide` package.

3. Install the php dependencies with `composer install`.

4. Run the laravel migrations with `php artisan migrate`.

5. Build the frontend with `pnpm build`.

6. Run the `php artisan storage:link` command to allow for the necessary storage access.

7. For file uploads ensure that the tmp folder exists and is writable (currently at /home/www/diz_guide/tmp).

## User Creation

All users have access to the admin panel at `/admin`. In order to create a new user, run the `php artisan app:create-user` command.
