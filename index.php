<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'vendor/autoload.php';

// function to check if string contains special characters or numbers
function is_string_text(string $str) : bool {
    return preg_match('/[^a-zA-Z]/', $str) == 0;
}
// '^' symbol means "don't count" in regex format
function is_string_number(string $str) : bool{
    return preg_match('/[^0-9]/', $str) == 0;
}

function isValidEmail(string $email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isValidPhoneNumber(string $phone_num) {
    // Phone number verification: check length, is it a number, and is it a form of phone number
    return (strlen($phone_num) >= 10 && strlen($phone_num) <= 11) && is_string_number($phone_num);
}
// Routing system

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$parts = explode('/', $url);

// Define Routes
$routes = [
    'departments' => 'frontend/html/global/departments.html',
    'doctors'     => 'frontend/html/global/doctors.html',
    'about'       => 'frontend/html/global/about.html',
    'login'       => 'frontend/html/user/login.html',
    'register'    => 'frontend/html/global/registration.html',
    'profile'     => 'frontend/html/user/profile.html',
    'q&a'         => 'frontend/html/global/q&a.html',
    'contact'     => 'frontend/html/global/contact.html',
    'admin'       => 'frontend/html/admin/login.html'
];

// Check if we have given url path in html routes
if (array_key_exists($parts[1], $routes)) {
    // get the file path
    $file = $routes[$parts[1]];

    if (file_exists($file)) {
        // reads file and displays it without changing the url
        readfile($file);
        // exit before further execution
        exit();
    }
}

// If URl is in form "api/..." then it is a api call
if ($parts[1] === 'api') {
    // what is second part?
    $controllerName = $parts[2] ?? ''; // e.g., "patient", "doctor"
    // third part is the action
    $action = $parts[3] ?? '';
    // Map URL names to Class names
    $controllerMap = [
        'patient'     => ['file' => 'PatientController.php',     'class' => 'PatientController'],
        'doctor'      => ['file' => 'DoctorController.php',      'class' => 'DoctorController'],
        'department'  => ['file' => 'DepartmentController.php',  'class' => 'DepartmentController'],
        'appointment' => ['file' => 'AppointmentController.php', 'class' => 'AppointmentController'],
        'blood'       => ['file' => 'BloodTypeController.php',   'class' => 'BloodTypeController'],
        'schedule'    => ['file' => 'ScheduleController.php',    'class' => 'ScheduleController'],
        'punishment'  => ['file' => 'PunishmentController.php',  'class' => 'PunishmentController'],
        'admin'       => ['file' => 'AdminController.php',       'class' => 'AdminController'],
        'bill'        => ['file' => 'BillController.php',        'class' => 'BillController'],
        'treatment'   => ['file' => 'TreatmentController.php',   'class' => 'TreatmentController'],
        'patient_punishment' => ['file' => 'PatientPunishmentController.php', 'class' => 'PatientPunishmentController'],
        'doctor_schedule' => ['file' => 'DoctorScheduleController.php', 'class' => 'DoctorScheduleController'],
        'specialization' => ['file' => 'SpecializationController.php', 'class' => 'SpecializationController']
    ];

    if (array_key_exists($controllerName, $controllerMap)) {

        $config = $controllerMap[$controllerName];

        // just a quick peek to the controllers directory
        $currentDir = getcwd();
        chdir('backend/controllers');
        
        if (file_exists($config['file'])) {

            require_once $config['file'];
            $className = $config['class'];
            // it is crazy you can use variables as class names
            // create instance of the class and execute it's method with action
            $controller = new $className();
            $controller->execute($action);

        } else {
            http_response_code(404);
            echo json_encode(["error" => "Request Not Found"]);
        }
        // Come back to the current directory
        chdir($currentDir);
        exit();
    }
}

// POV: G*y people when they couldn't pick a gender.
if ($parts[1] === '' || $parts[1] === 'index.php') {
    if (file_exists('index.html')) {
        readfile('index.html');
    } else {
        // default display is a text
        echo "Welcome to Nova Hospital";
    }
    exit();
}

// Fallback for physical files if .htaccess didn't catch them
if (file_exists($parts[1]) && !is_dir($parts[1])) {
    $ext = pathinfo($parts[1], PATHINFO_EXTENSION);
    if ($ext !== 'php') { // Security: don't serve PHP files directly here
        readfile($parts[1]);
        exit();
    }
}

// POV: L3sb1an people when they are different.
http_response_code(404);
echo "404 - Page Not Found";
