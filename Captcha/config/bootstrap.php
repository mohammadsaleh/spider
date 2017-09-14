<?php
\Spider\Lib\Hook::component('*', 'Captcha.Captcha');
$captchaStatus = \Settings\Lib\Settings::find('captcha.status', false);
$captchaStatus = !empty($captchaStatus) ? (int)$captchaStatus[0]['value'] : false;
\Cake\Core\Configure::write('captcha_enable', $captchaStatus);