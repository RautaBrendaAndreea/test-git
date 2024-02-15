<?php
declare(strict_types = 1);

// Manage actions
if(isset($_GET["action"]) && isset($_GET["token"])){
	$action = $_GET["action"];
	$token = $_GET["token"];

	if(isset($_GET["user"])){
		$user = $_GET["user"];
	}

	switch ($action) {
		case 'isOpen':
			echo isOpen($token);
			break;
		case 'open':
			manageOpening($user, $token);
			break;
	}
}

// Manage Opening
function manageOpening(string $user, string $token) :void{
	if(isset($_GET["time"])){
		$time = $_GET["time"];
		open($user, $token, $time);
	}
	else{
		open($user, $token);
	}
}

// Check if Open
function isOpen($token) :string{
	$users = parse_ini_file("secret_users_list.txt");

	if($token === $users["raspberrypibot"]){
		$openUntil = (int)file_get_contents("openUntil.txt");

		if($openUntil>=time()){
			return "true";
		}
	}
	else{
		file_put_contents("openUntil.txt", time()-60); // close the door
		$logMessage = "isOpen() error in token, door closed, IP: "
					  . $_SERVER['REMOTE_ADDR'];
		addLog($logMessage, time());
	}

	return "false";
}


// Open/Close door
function open(string $user, string $token, int $time = 15) :void{
	$users = parse_ini_file("users.ini");
	if($users[$user] === $token){
		file_put_contents("openUntil.txt", time()+$time);
		$logMessage = "Opened for ".htmlspecialchars($user)." until ".(time()+$time);
		addLog($logMessage, time());
	}
	else{
		$logMessage = "Error with ".htmlspecialchars($user)." / ".htmlspecialchars($token);
		addLog($logMessage, time());
	}
}

// Log
function addLog(string $message, int $timestamp) :void{
	$filePath = 'logs.txt';
	$content = file_get_contents($filePath);
	$content.= date("y/m/d H:i:s", $timestamp)." (".$timestamp .") : ". $message."\n";
	file_put_contents($filePath, $content);
}