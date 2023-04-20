<?php
/*used to add photos for both the gm share option and player photos */
session_start();
if (hash_equals($_SESSION['token'], $_POST['token'])) {
  
$token = $_SESSION['token'];
$location ="../Resources/";
//create file locations
if (!file_exists($location)){
  mkdir($location);
}
$location=$location."uploads/";
if (!file_exists($location)){
  mkdir($location);
}
$location=$location.$_SESSION['Campaign']."/";
if (!file_exists($location)){
  mkdir($location);
}
$return = $_POST["source"];
$target_file=$location.basename($_FILES["fileToUpload"]["name"]);

$success=1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
include_once("../Controllers/shared_image_controller.php");
include_once("../Controllers/Player_character_controller.php");
if(isset($_POST["submit"])) {
if (hash_equals($_SESSION['token'], $_POST['token'])) {
  //check if jpg
	if($fileType !="jpg"){
		$success=0;  
  }
if ($success == 0) {
  echo "Sorry, your file was not uploaded. Make sure it is in type .jpg";
  ?> <a href=<?php echo $return ?>>Back</a> <?php

} else {
//set up new file name
	$temp = explode(".", $_FILES["fileToUpload"]["name"]);
	$newfilename = filter_var($_FILES["fileToUpload"]["name"], FILTER_SANITIZE_STRING);
  if (!file_exists($location)){
    mkdir($location);
  }
  if($_POST['source']=="character_details.php"){
    $location=$location."player_images/";
    mkdir($location);
  }//find correct location to save
  if($_POST['source']=="character_details.php"){
    $character_id   = $_SESSION["current_character"]; //save file
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $location.$character_id."_".$newfilename)) {   
      $character_model = new  PlayerCharacterController(null,null);
      $character      = $character_model->getPlayerCharacterById($character_id);
      $character_model->add_image(filter_var($_REQUEST['character_id'], FILTER_SANITIZE_STRING),$location.$character_id."_".$newfilename);
      ?>
      <script>
      window.location.replace("character_details.php");
      </script>
      <?php
    }else {
      echo "Sorry, there was an error uploading your file.";
      ?> <a href=<?php echo $return ?>>Back</a> <?php
    }  
    }else{ //save file
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $location.$newfilename)) {  
    $image_model=new SharedImageController(null,null,);
    $image_model->addImage($location.$newfilename,$_SESSION['Campaign']);
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    ?>
    <script>
    window.location.replace("gm_pannel.php");
    </script>
    <?php
    }else {
      echo "Sorry, there was an error uploading your file.";
      ?> <a href=<?php echo $return ?>>Back</a> <?php
    }
    } 




}

}else{
  echo "Sorry, there was an error uploading your file.";
    ?> <a href=<?php echo $return ?>>Back</a> <?php
}
}
}
?>

