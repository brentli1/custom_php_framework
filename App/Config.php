<?php

namespace App;

/**
 * Application configuration
 * 
 * PHP version 7.1.9
 */
class Config
{
    /** @var string DB_HOST Database Host */
    const DB_HOST = 'localhost:8889';

    /** @var string DB_NAME Database Name */
    const DB_NAME = 'custom_mvc';
    
    /** @var string DB_USER Database User */
    const DB_USER = 'root';

    /** @var string DB_PASS Database Password */
    const DB_PASS = 'root';

    /** @var boolean SHOW_ERRORS Shows or hides error messages */
    const SHOW_ERRORS = false;
}
