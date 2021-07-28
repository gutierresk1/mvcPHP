<?php

namespace App\Models;

use PDO;
use PDOException;

/**
 * Post model
 * 
 * PHP 8.0.7
 */
class Post extends \Core\Model
{
    /**
     * Get all the posts as an associative array.
     * 
     * static function does not require instance of the class. call it from class directly
     * @return array
     */
    public static function getAll()
    {
        //variables are for creation of PHP Database Object.
        $host = 'localhost';
        $dbname = 'mvc';
        $username = 'root';
        //NOTE FOR AMPPS: THE DEFAULT PASSWORD is 'mysql'
        $password = 'mysql';


        //Re-define the try-catch statement: 
        //try is where the errors might occur
        //catch handles the exception.
        try {
            /**
             * using PDO: PHP Data Object
             * The basic way before was using mysqli, which stands for the MySQL improved extension.
             */

            //because we made the connection in the base model, we simply grab the static function
            //from the base model class.
            $db = static::getDB();
            $stmt = $db->query('SELECT id, title, content FROM posts
                                 ORDER BY created_at');
            //results is the associative array necessary to return all of the columns requested by the sql 
            //statement above. 
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
