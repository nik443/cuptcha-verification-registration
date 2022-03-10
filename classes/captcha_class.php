<?php
    class Captcha {

        public static function createCaptcha() {
            session_start();
            $image = imagecreatetruecolor(100, 50);
            $bg_color = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 1, 1, $bg_color);
            $captcha_words = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
            $font = 'fonts/sfns-display-thin.ttf';

            //GENERATE CAPTCHA TEXT
            $code = '';
            for ($i = 0; $i < 4; $i++) { 
                $word = $captcha_words[mt_rand(0, count($captcha_words) - 1)];
                $word_color = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
                imagettftext($image, 20, mt_rand(-9, 9), 20 + $i * 20, 20, $word_color, $font, $word);
                $code .= $word;
            }
            $_SESSION['code'] = $code;

            //GENERATE CAPTCHA BACK TEXT
            for ($i = 0; $i < 35; $i++) {
                $word = $captcha_words[mt_rand(0, count($captcha_words) - 1)];
                imagettftext($image, 6, 0, mt_rand(1, 100), mt_rand(1, 50), imagecolorallocate($image, 193, 0, 0), $font, $word);
            }

            header('Content-Type: image/png');
            imagepng($image);
        }

        //VERIFICATION OF CAPTCHA
        public static function checkCapthcaCode($code) {
            if (!session_id()) session_start();
            return $code === $_SESSION['code'];
        }
    
    }
?>