<?php

namespace Core;

/**
 * Error and exception handler
 * 
 * PHP Version 8.0.7
 * 
 * Explanation: This is class is to convert errors into exceptions. 
 * With Exceptions, we can handle them and with stack trace, find out what led to failure
 * The handler is simply the details of what went wrong.
 */

class Error
{
    /**
     * We convert all errors by throwing an error exception
     * 
     * @param int $level: this argument is for the error level
     * @param string $message: The error message itself.
     * @param string $file: The Filename the error was raised in
     * @param int $line: The line number in the file, which is where the error is from
     * 
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        /**
         * Error levels: There are 16 level errors, represneted by an integer. 
         * error_reporting: if the error is in one of the 16, and NOT zero.
         */

        //to keep the @ operator working?
        if (error_reporting() !== 0) {
            //Interface: what the class has to fulfill. keyword implements
            //Error exception is a class extending the Exception parent class
            /**
             * constructors: 
             * string message
             * int code
             * int severity
             * string filename (optional)
             * int line (optional)
             * Throwable previous (optional) (throwable is an interface)
             */
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception Handler.
     * 
     * Essentially shows th user in the view side of things, based on tags
     * @param Exception $exception: the exception
     * 
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        //Since we are now working error codes, it will be a good idea to show 'user'
        //these codes for reference?
        //Exception->getCode method: returns the exception code, which is of type int
        //200 is OK, 404 not found, 500 server side...
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        //http_response_code: basically sets the response code to the var above
        http_response_code($code);

        if (\App\Config::SHOW_ERRORS) {
            echo "<h1>Fatal error!<h1>";
            //get_class simply grabs the object
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace: <pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception .
                $exception->getLine() . "</p>";
        } else {
            //this $log variable grabs the string in which the log file exists.
            $log = dirname(__DIR__)  . '/logs/' . date('Y-m-d')  . '.txt';
            //initializes the file above as the error log, where code for developer can be seen
            //better looking for deployment
            ini_set('error_log', $log);

            //the message that is sent to the file.
            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in " . $exception->getFile() . "' on line " .
                $exception->getLine();

            //function to actually put it there.
            error_log($message);
            //what user sees.
            //NOTE: Double quoting forced php to evaulauate the string, 
            //which will make it look for variables.
            View::renderTemplate("$code.html");

            //echo "<h1>An error occured!</h1>";
            /**if ($code == 404) {
                echo '<h1>Page not found</h1>';
            } else {
                echo '<h1>An error occured</h1>';
            }*/
        }
    }
}
