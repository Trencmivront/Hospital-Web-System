# Hospital-Web-System
A full-stack hospital web application template. Patients can log in to see their appointments, treatments and bills. Admins can add, remove doctor information, make changes over everything. And doctors, they are data, not user.

## Setup Instructions

### 1. Prerequisites
You need to install the following tools:
- **PHP** (Latest stable version)
- **Apache**
- **MySQL**
- **Composer**
- **Mailhog** (For email testing)
- **Firebase JWT** (PHP Library)
- **PHPMailer** (PHP Library)

### 2. Installation Guide

#### Linux (Ubuntu/Debian)
1. **Update packages:**
   ```bash
   sudo apt update
   ```
2. **Install Apache, MySQL, and PHP:**
   ```bash
   sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql php-curl php-gd php-mbstring php-xml php-zip
   ```
3. **Install Composer:**
   ```bash
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   ```
4. **Install Mailhog:**
   ```bash
   sudo curl -L -o /usr/local/bin/mailhog https://github.com/mailhog/MailHog/releases/download/v1.0.1/MailHog_linux_amd64
   sudo chmod +x /usr/local/bin/mailhog
   ```

#### Windows
1. **Apache, MySQL, PHP:** The easiest way is to install [XAMPP](https://www.apachefriends.org/index.html) or [WampServer](https://www.wampserver.com/en/).
2. **Composer:** Download and run the [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe).
3. **Mailhog:** Download the `MailHog_windows_amd64.exe` from [MailHog Releases](https://github.com/mailhog/MailHog/releases) and run it.

#### MacOS
1. **Install Homebrew** (if not already installed):
   ```bash
   /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
   ```
2. **Install PHP, Apache, and MySQL:**
   ```bash
   brew install php httpd mysql
   ```
3. **Install Composer:**
   ```bash
   brew install composer
   ```
4. **Install Mailhog:**
   ```bash
   brew install mailhog
   ```

### 3. Project Dependencies
After installing Composer, run the following commands in the project root to install the required PHP libraries:
```bash
composer require firebase/php-jwt phpmailer/phpmailer
```

### 4. Apache Configuration
1. **Create Virtual Host:**
   Create a new configuration file (e.g., `hospital.conf`) in your Apache sites-available directory (e.g., `/etc/apache2/sites-available/hospital.conf` on Linux).

   Add the following content:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "path_to_project_folder"
       ServerName hospital.test
       <Directory "path_to_project_folder">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
       ErrorLog ${APACHE_LOG_DIR}/error.log
       CustomLog ${APACHE_LOG_DIR}/access.log combined
   </VirtualHost>
   ```

2. **Enable Site and Rewrite Module (Linux):**
   Run the following commands in your terminal:
   ```bash
   sudo a2ensite hospital.conf
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

3. **Update Hosts File:**
   To access the site via `http://hospital.test`, add the following line to your system's hosts file:
   ```text
   127.0.0.1 hospital.test
   ```
   - **Linux/MacOS:** `/etc/hosts`
   - **Windows:** `C:\Windows\System32\drivers\etc\hosts`

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