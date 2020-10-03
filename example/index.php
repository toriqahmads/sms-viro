<?php
require (__DIR__."/../vendor/autoload.php");

use Toriqahmads\SmsViro\SmsViro;

$smsviro = new SmsViro('707474e01fead92a7c9421a4069f21cd-12969e36-b3ef-46d8-8e93-f78804cee22d', 'kawan kewan');

$smsviro->sendSms('089668639048', 'Your otp code is 6989');

var_dump($smsviro->isRequestSuccess());
