<?php

namespace core;

//imports
use PDO;
use PDOException;
use App\Config;

/**
 * Base Model
 * 
 * Explanation: Connecting to the Database is costly. 
 * An ideal approach will be to connect once per request.
 * Reusing the same connection on multiple queries is the base
 * We store this model in the core folder, as the models in Models folder will not connect to the DB
 * Neither will the methods in the Models in the models folder. 
 * It makes more sense to have one base model to inherit from.
 * This class will use static calls, accessing the methods directly, instead of an instance
 * 
 */
abstract class Model
{
    /**
     * Get the PDO database connection. 
     * What is a pseudo type? 
     * Answer: Any type that artificial/not concrete.
     * mixed is a pseudo type, meaning that it can take any type.
     * Do not cast a variable into mixed. 
     * @return mixed
     */
    protected static function getDB()
    {
        //declare database as a null type
        //static variable: the value will not change, should the function be called again.
        //To better understand: if you have count and increment it inside the function,
        //multiple calls will increment the function and not lose its value. 
        static $db = null;

        //add values to the database if it is empty.
        if ($db === null) {
            //THIS WAS THE HARD CODED WAY
            //$host = 'localhost';
            //$dbname = 'mvc';
            //$username = 'root';
            //FOR AMPPS, the password is mysql.
            //$password = 'mysql';
            //We removed the try-catch statement for a cleaner looking handler.
            /**
             * The PDO is a class and has a constructor holding the folowing properties:
             * DSN: Data Source Name. The info required to connect the database.
             * The user name
             * The Password
             */
            //for cleaner code, we will create a variable for the data source name
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME .
                ';charset=utf8';

            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            //Throw the exception when an error occurs
            // setAttribute is a setter in the PDO class
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }
}
