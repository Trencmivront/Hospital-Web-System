# Hospital-Web-System
A full-stack hospital web application template. Patients can log in to see their appointments, treatments and bills. Admins can add, remove doctor information, make changes over everything. And doctors, they are data, not user.


## Database Connection File

This file must be put under "backend" folder. Otherwise, you'll need to configure it's path on all controllers.

```php
    <?php
    $host = 'localhost';
    $db   = ''; // use your own database name
    $user = 'root';
    $pass = ''; // use your own server password
    $charset = 'utf8mb4'; // Turkish characters safely used.

    // Specifying our server, host, database we are using and the charset it can contain.
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    // we define a main exception handler
    // writing "echo responseEntity()" everytime causes boilerplate code
    set_exception_handler(function (Throwable $e){
        // get the current date and time
        $timestamp = date('Y-m-d H:i:s');

        $logEntry = "[$timestamp] Exception: " . get_class($e) . " was thrown in " . $e->getFile() . " at the line " . $e->getLine() . PHP_EOL;
        $logPath = dirname(__FILE__) . "/../logs/error.log";
        // make file path relative to this file
        error_log($logEntry, 3, $logPath);

        echo responseEntity($e->getMessage(), $e->getCode() ?? 500);
    });

    try {
        // Starting PDO connection.
        $pdo = new PDO($dsn, $user, $pass);
        
        // Throw exception if error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        // After that if the connection is success, our $pdo element will be sent to
        // next file that includes or requires this file. Remember that.

    // Throw PDOException 
    } catch (PDOException $e) {
        // Works as exit(). Prints value just before exit.
        die("Connection error: " . $e->getMessage());
    }
    // creating this function here because of every controller will be using it.
    function responseEntity($dataSet, $responseStatus=200){
        header("Content-Type: application/json; charset=utf-8");
        // default is 200
        http_response_code($responseStatus);
        return json_encode($dataSet, JSON_UNESCAPED_UNICODE);
    }
```