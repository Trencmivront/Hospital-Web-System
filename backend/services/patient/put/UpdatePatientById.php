<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . '/../get/JWToken.php';
class UpdatePatientById {
    function execute(PDO $pdo) : bool {
        
        $jwt = new JWToken();

        try {

            if(!isset($_SESSION['patient_jwt'])){
                throw new UserIsNotAuthenticatedException();
            }

            $jwtContents = $jwt->openToken($_SESSION['patient_jwt']);
            // get user id from jwt token
            $patient_id = $jwtContents->user_id;

            $input = json_decode(file_get_contents('php://input'), true);
            
            // turning them into safe and sound values
            // and validating inputs
            $first_name = htmlspecialchars($input['first_name'] ?? '');

            if(!is_string_text($first_name) || (strlen($first_name) < 2) ){
                throw new InvalidFirstNameException();
            }

            $last_name = htmlspecialchars($input['last_name'] ?? '');

            if(!is_string_text($last_name) || (strlen($last_name) < 2)){
                throw new InvalidLastNameException();
            }

            $gender_name = htmlspecialchars($input['gender_name'] ?? '');
            $email = htmlspecialchars($input['email'] ?? '');
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidEmailException();
            }

            $phone_num = htmlspecialchars($input['phone_num'] ?? '');

            if(!is_string_number($phone_num) || strlen($phone_num) != 11){
                throw new InvalidPhoneNumException();
            }

            $blood_id = htmlspecialchars($input['blood_id'] ?? '');
            $birth_date = htmlspecialchars($input['birth_date'] ?? '');

            if($birth_date > date('Y-m-d')){
                throw new InvalidBirthDateException();
            }

            $pat_password = $input['pat_password'] ?? null;

            if (!$first_name || !$last_name || !$gender_name || !$email || !$phone_num || !$blood_id || !$birth_date) {
                throw new NullInputsException();
            }

            $query = "UPDATE Patient SET 
                        first_name = :first_name, 
                        last_name = :last_name, 
                        gender_name = :gender_name,
                        email = :email, 
                        phone_num = :phone_num, 
                        blood_id = :blood_id, 
                        birth_date = :birth_date,
                        update_date = CURRENT_DATE,
                        update_time = CURRENT_TIME";
            
            $params = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender_name' => $gender_name,
                'email' => $email,
                'phone_num' => $phone_num,
                'blood_id' => $blood_id,
                'birth_date' => $birth_date,
                'patient_id' => $patient_id
            ];

            if ($pat_password) {

                if((strlen($pat_password) < 8) || (strlen($pat_password) > 16)){
                    throw new PasswordLengthException();
                }   

                $query .= ", pat_password = :pat_password";
                $params['pat_password'] = password_hash($pat_password, PASSWORD_BCRYPT);
                // artık mail doğrulaması olmasın harbi bıktım yeter
            }

            $query .= " WHERE patient_id = :patient_id";

            $statement = $pdo->prepare($query);
            $statement->execute($params);

            return true;

        } catch (PDOException $e) {
            throw new CouldNotUpdatePatientException();
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }
    }
}
