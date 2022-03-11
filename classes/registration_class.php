<?php
    spl_autoload_register(
        function($classname) {
            require_once "classes/{$classname}_class.php";
        }
    );

    class Registration {
        private $email;
        private $password;
        private $repiat_password;
        private $captcha;

        public function __construct($email, $password, $repiat_password, $captcha) {
            if ($email) $this->email = $email;
            if ($password) $this->password = $password;
            if ($repiat_password) $this->repiat_password = $repiat_password;
            if ($captcha) $this->captcha = $captcha;
        }

        //VERIFICATION OF USER DATA
        public function check_data() {
            try {
                if ($this->email && $this->password && $this->repiat_password && $this->captcha) {
                    if (!preg_match('/[0-9a-z]+@[a-z]/', $this->email)) throw new Exception('Имейл некорректен');
                    if ($this->password != $this->repiat_password) throw new Exception('Подтверждение пароля не соответсвует введенному паролю');
                    if (!Captcha::checkCapthcaCode($this->captcha)) throw new Exception('Неверно введен код с картинки');

                    //ESTABLISHING A DATABASE CONNECTION
                    define('DB_HOST', 'localhost');
                    define('DB_USER', 'root');
                    define('DB_PASSWORD', '');
                    define('DB_NAME', 'users_database');
                    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    $mysqli->set_charset('utf8');
                    $this->email = $mysqli->real_escape_string(htmlspecialchars($this->email));
                    $this->password = $mysqli->real_escape_string(htmlspecialchars($this->password));

                    //CHECK FOR REGISTERED ACCOUNT
                    $check_reg_acc = $mysqli->query("SELECT COUNT(`email`) FROM `registered_users` 
                    WHERE `email` = '$this->email'");
                    $table = [];
                    while(($row = $check_reg_acc->fetch_assoc()) != false) {
                        $table[] = $row;
                    }
                    if ($table[0]['COUNT(`email`)'] != 0) throw new Exception('Пользователь с введенным email уже зарегистрирован');

                    //USER REGISTRATION
                    $query = "INSERT INTO `registered_users`
                    (`email`, `password`)
                    VALUES ('$this->email', MD5('$this->password'))";
                    $mysqli->query($query);
                    $mysqli->close();
                    if (!session_id()) session_start();
                    $_SESSION['flag_autorization']  = true;
                    $_SESSION['user_email'] = $this->email;
                    return 1; // SUCCESSFUL REGISTRATION

                } else throw new Exception('Какие-то поля не заполнены');
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
?>