<?php

namespace App;

/**
 * Application Configuration
 * 
 * Explanation: Configuration setting need to in a seperate location, away from code. 
 * These setting need to be easily changed. Having them in code will cause problems.
 * The data used in the base model will no longer be hard coded into that class, but extracted
 * from this class.
 */
class Config
{
    /**
     * Database host
     * const in php: same as js, CANNOT be changed.
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * const type
     * @var string
     */
    const DB_NAME = 'mvc';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * REMINDER: For AMPPS, the password default is 'mysql'
     */
    const DB_PASSWORD = 'mysql';

    /**
     * Show or hide error messages on screen.
     * @var boolean
     */
    const SHOW_ERRORS = false;
}
