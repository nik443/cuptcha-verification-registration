<?php
    spl_autoload_register(
        function($classname) {
            require_once "classes/{$classname}_class.php";
        }
    );
    
    if (isset($_POST['registration_form'])) {
        $registration = new Registration($_POST['email'], $_POST['password'], $_POST['repiat_password'], $_POST['captcha_code']);
        $successful_reg = $registration->check_data();
        if ($successful_reg == 1) {
            echo 'Вы успешно зарегистрировались. ';
        };
    }

    if (!session_id()) session_start();
    if (isset($_SESSION['flag_autorization']) && $_SESSION['flag_autorization'] == true) {
        echo 'Приветствуем, ' . $_SESSION['user_email'];
        ?> <a href="index.php?exit_acc=exit">Выйти из аккаунта</a> <?php
    }

    if (isset($_GET['exit_acc']) && $_GET['exit_acc'] == 'exit') {
        unset($_SESSION['flag_autorization']);
        unset($_SESSION['user_email']);
    }
?>

<div class="registration">
    <h1>Регистрация нового пользователя</h1>
    <form action="index.php" method="POST" name="registration_form">
        <div>Ваш имейл
            <input type="text" name="email">
        </div>
        <div>Ваш пароль
            <input type="password" name="password">
        </div>
        <div>Подтвержение пароля
            <input type="password" name="repiat_password">
        </div>
        <div>Введите код с картинки для подтверждения
            <input type="text" name="captcha_code">
        </div>
        <div>
            <img src="captcha.php" alt="Captcha">
            <a href="index.php?update_captcha=update">Не видно кода</a>
        </div>
        <div>
            <input type="submit" name="registration_form" value="Зарегистрироваться">
        </div>
    </form>
</div>