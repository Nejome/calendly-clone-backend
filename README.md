<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

### Calendly Clone (Backend)

Mini clone for Calendly meeting application.

### Installation

- After clone the repo install the dependencies using
    ```bash
    composer install
    ```

- copy .env file and fill it with required variables
    ```bash
    cp .env.example .env
    ```

- run migration
    ```bash
    php artisan migrate
    ```

- run server
    ```bash
    php artisan serve
    ```

- run scheduler
    ```bash
    php artisan schedule:work
    ```
