<?php
    require_once 'classes/registration_class.php';
    
    if (isset($_POST['registration_form'])) {
        $registration = new Registration($_POST['email'], $_POST['password'], $_POST['repiat_password'], $_POST['captcha_code']);
        echo $registration->check_data();
    }

    $captcha_img_path = 'captcha.php';
    /* if (isset($_GET['update_captcha']) && $_GET['update_captcha'] == 'update') {
        Captcha::createCaptcha();
        $captcha_img_path = 'captcha.php';
    } */
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
            <img src="<?= $captcha_img_path ?>" alt="Captcha">
            <a href="index.php?update_captcha=update">Не видно кода</a>
        </div>
        <div>
            <input type="submit" name="registration_form" value="Зарегистрироваться">
        </div>
    </form>
</div>