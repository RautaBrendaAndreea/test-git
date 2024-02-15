<?php
require_once("vendor/autoload.php");

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

$_ENV['TOKEN'] = "MY_SECRET_TOKEN";
$_ENV['DOMAIN'] = "https://domaine.random.com/";

$bot = new Nutgram($_ENV['TOKEN']);

$bot->setRunningMode(Webhook::class);

$bot->onCommand('start', function(Nutgram $bot) {
    $bot->sendMessage('Welcome, please /auth {USER} {TOKEN} yourself!');
});

$bot->onCommand('open', function (Nutgram $bot) {
    $auth = $bot->getUserData('auth');
    $token = $bot->getUserData('token');

    $params = "action=openDoor&user=".$auth."&token=".$token;

    $ch = curl_init($_ENV['DOMAIN']."?".$params);
    curl_exec($ch);
    curl_close($ch);

    return $bot->sendMessage('Sesame!');
})->description('I will open the door for you');

$bot->onCommand('auth {user} {token}', function (Nutgram $bot, $user, $token) {
    $bot->setUserData('auth', $user);
    $bot->setUserData('token', $token);
    return $bot->sendMessage('You can now open the door!');
})->description('Auth you with your username + token');

$bot->onCommand('credentials', function (Nutgram $bot) {
    $user = $bot->getUserData('auth');
    $token = $bot->getUserData('token');
    return $bot->sendMessage('User: '.$user." token: ".$token);
})->description('Show my credentials');

$bot->run();