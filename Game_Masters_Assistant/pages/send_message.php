<?php
include_once("../Controllers/message_controller.php");


$message= new MessageController(null,null);
$result= $message -> addMessage( 1, 1, "sendtest", "a3a" )



?>