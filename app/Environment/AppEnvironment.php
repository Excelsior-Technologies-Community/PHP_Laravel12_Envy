<?php

namespace App\Environment;

class AppEnvironment
{
    public function __construct(
        public string $APP_NAME,
        public string $APP_ENV,
        public bool $APP_DEBUG,
        public string $APP_URL,

        public string $DB_CONNECTION,
        public string $DB_HOST,
        public int $DB_PORT,
        public string $DB_DATABASE,
        public string $DB_USERNAME,
        public string $DB_PASSWORD,
    ) {}
}