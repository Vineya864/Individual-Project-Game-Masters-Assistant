<?php
include_once("../views/shared_image.php");
include_once("../views/shared_image_view.php");
require_once("../env.php");
class SharedImageController {
private $server;
private $dbname;
private $username;
private $password;
private $pdo;
# define the constructor which has four arguments for $server, $dbname, $username, $password. 
# The $pdo field should be assigned as null  

public function __construct($a,$b){
    $this->server = $a;
    $this->dbname = $b;
	$this->username = apache_getenv('USER_NAME');
	$this->password = apache_getenv('PASSWORD');
    $this->pdo =null;
}

public function Connect(){
    
    try{
        $this->pdo = new PDO("mysql:host=127.0.0.1;dbname=FYP", $this->username, $this->password );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $ex) {
    ?>
<p>Sorry, a database error occurred.</p>
<p> Error details: <em> <?= $ex->getMessage() ?> </em></p>
<?php	
}
}


public function getActiveimage($id) {
    $this->Connect();
    $query=$this->pdo->prepare("SELECT * FROM `shared_images` WHERE CAMPAIGN_ID =? AND ACTIVE = TRUE;");
     $query->execute([$id]);
     $row=$query->fetch();
    if ($row != null){
        return new SharedImage($row["IMAGE_ID"], $row["PATH"], $row["ACTIVE"],$row["BACK_GROUND"]);
    }
}
public function getBackGroundimage($id) {
    $this->Connect();

    $query=$this->pdo->prepare("SELECT * FROM `shared_images` WHERE CAMPAIGN_ID =? AND BACK_GROUND = TRUE;");
     $query->execute([$id]);
    
     $row=$query->fetch();
    if ($row != null){
        return new SharedImage($row["IMAGE_ID"], $row["PATH"], $row["ACTIVE"],$row["BACK_GROUND"]);
    }
}

public function getImage($id) {
    $this->Connect();

    $query=$this->pdo->prepare("SELECT * FROM `shared_images` WHERE image_ID =?");
     $query->execute([$id]);
    
     $row=$query->fetch();
    if ($row != null){
        return new SharedImage($row["IMAGE_ID"], $row["PATH"], $row["ACTIVE"] ,$row["BACK_GROUND"]);
    }
}

public function getCampaign($id){
    $this->Connect();

    $query=$this->pdo->prepare("SELECT * FROM `shared_images` WHERE image_ID =?");
     $query->execute([$id]);
    
     $row=$query->fetch();
    if ($row != null){
        return $row["CAMPAIGN_ID"];
    }

}

public function addImage($location, $Campaign){
    $true_location=$location;
    $this->Connect();
	$query = $this->pdo->prepare("INSERT INTO`shared_images` (`CAMPAIGN_ID`,`PATH`) VALUES(?,?)");
	$query->execute([ $Campaign,$true_location]);
}



public function showCampainImages($id,$token){
    $this->Connect();
    $sth=$this->pdo->prepare("SELECT * FROM `shared_images` WHERE CAMPAIGN_ID =?; ");
    $sth->execute([$id]);
    $view = new sharedImageView();
    while($row =  $sth->fetch(PDO::FETCH_ASSOC)) {
            $image=$this->getImage($row["IMAGE_ID"]);
            $view->displayImageDropDown($image,$token);

        }
    
}

public function clearImages($id){
    $this->Connect();
    $sth=$this->pdo->prepare("UPDATE `shared_images` SET ACTIVE = FALSE WHERE CAMPAIGN_ID =? AND ACTIVE = TRUE; ");
    $sth->execute([$id]);

}
public function clearBack($id){
    $this->Connect();
    $sth=$this->pdo->prepare("UPDATE `shared_images` SET BACK_GROUND = FALSE WHERE CAMPAIGN_ID =? AND BACK_GROUND = TRUE; ");
    $sth->execute([$id]);
}


public function setBackGroundImage($id,$campaign){
    $this->Connect();
    $sth=$this->pdo->prepare("UPDATE `shared_images` SET BACK_GROUND = FALSE WHERE CAMPAIGN_ID =? AND BACK_GROUND = TRUE; ");
    $sth->execute([$campaign]);
    $sth=$this->pdo->prepare("UPDATE `shared_images` SET BACK_GROUND =TRUE WHERE IMAGE_ID =? AND CAMPAIGN_ID =? ; ");
    $sth->execute([$id,$campaign]);
}

public function shareImage($id,$campaign){
    $this->Connect();
    $sth=$this->pdo->prepare("UPDATE `shared_images` SET ACTIVE = FALSE WHERE CAMPAIGN_ID =? AND ACTIVE = TRUE; ");
    $sth->execute([$campaign]);
    $sth=$this->pdo->prepare("UPDATE `shared_images` SET ACTIVE =TRUE WHERE IMAGE_ID =? AND CAMPAIGN_ID =? ; ");
    $sth->execute([$id,$campaign]);
}

public function deleteImage($id){
    $this->Connect();
    $sth=$this->pdo->prepare("SELECT * FROM`shared_images` WHERE IMAGE_ID =? ; ");
    $sth->execute([$id]);
    $row=$sth->fetch();
    if(is_dir("../Resources/uploads/".$row["CAMPAIGN_ID"])){
    if(is_file($row["PATH"])){ 	
        unlink( $row["PATH"]); 
    }
    $sth=$this->pdo->prepare("DELETE FROM`shared_images` WHERE IMAGE_ID =? ; ");
    $sth->execute([$id]);
}

}

public function delete_campaign($campaign_id){
    $this->Connect();
    $sth=$this->pdo->prepare("DELETE FROM`shared_images` WHERE CAMPAIGN_ID =? ; ");
    $sth->execute([$campaign_id]);
    if(is_dir("../Resources/uploads/".$campaign_id)){
        $toRemove = glob("../Resources/uploads/".$campaign_id.'/*');
        foreach($toRemove as $file){
            if(is_file($file)){ 
                unlink($file); 
            }  
        } 
        rmdir("../Resources/uploads/".$campaign_id);
    }
}


}