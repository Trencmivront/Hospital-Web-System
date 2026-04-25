# Hospital-Web-System
A full-stack hospital web application template. Patients can log in to see their appointments, treatments and bills. Admins can add, remove doctor information, make changes over everything. And doctors, they are data, not user.


## Database Connection File

```php
    <?php
    $host = 'localhost';
    $db   = ''; // use your own database name
    $user = 'root';
    $pass = ''; // use your own server password
    $charset = 'utf8mb4'; // Turkish characters safely used.


    // Specifying our server, host, database we are using and the charset it can contain.
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        // Starting PDO connection.
        $pdo = new PDO($dsn, $user, $pass);
        
        // Throw exception if error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // After that if the connection is success, our $pdo element will be sent to
        // next file that includes or requires this file. Remember that.
    // Throw PDOException 
    } catch (PDOException $e) {
        // Bağlantı hatası olursa burası çalışır
        die("Connection error: " . $e->getMessage());
    }
?>
```