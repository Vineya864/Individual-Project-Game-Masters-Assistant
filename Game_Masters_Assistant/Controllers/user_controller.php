<?php
include_once("../views/user.php");
require_once("../env.php");
class UserController {
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

public function getUserByUsername($username) {
    $this->Connect();
    $query=$this->pdo->prepare("SELECT * FROM `user` WHERE user_name =?;");
    $query->execute([$username]);
    $row=$query->fetch();
    if ($row != null){
        return new User($row["USER_ID"], $row["USER_NAME"]);
    }
  }

  public function getUserByID($id) {
    $this->Connect();
    $query=$this->pdo->prepare("SELECT * FROM `user` WHERE USER_ID =?;");
    $query->execute([$id]);
    $row=$query->fetch();
    if ($row != null){
        return new User($row["USER_ID"], $row["USER_NAME"]);
    }
  }

  public function getIdByUsername($username) {
    $this->Connect();
    $query=$this->pdo->prepare("SELECT * FROM `user` WHERE user_name =?;");
    $query->execute([$username]);
    $row=$query->fetch();
    if ($row != null){
        return ($row["USER_ID"]);
    }
  }

public function userExists($username){
    if(str_contains($username, 'dice') or str_contains($username, 'announce')  ){
      return true;
    }
    $this->Connect();
    $query=$this->pdo->prepare("SELECT * FROM `user` WHERE user_name =?;");
    $query->execute([$username]);
    $row=$query->fetch();
    if ($row != null){
        return true;
    }
  }

public function addAccount($username, $pass){
    $this->Connect();
    $query = $this->pdo->prepare("INSERT INTO`user` (`USER_NAME`,`USER_PASSWORD`) VALUES(?,?)");
    $query->execute([$username, $pass ]);
}

public function checkPassword($pass, $name){
    $this->Connect();
     $query=$this->pdo->prepare("SELECT * FROM `user` WHERE user_name =?;");
     $query->execute([$name]);
     $row=$query->fetch();
    if ($row != null){//if an account is found
        if($pass == password_verify($pass,$row["USER_PASSWORD"])){
            
                return True;
    
            }
        }
    return False;		  
  }


public function changeName($oldUsername,$newUsername){
  $this->Connect();
  $sth=$this->pdo->prepare("UPDATE user SET USER_NAME=? WHERE USER_NAME =? ");
  $sth->execute([$newUsername,$oldUsername]);
}

public function changePassword($userName,$newPassword,$oldPassword){
  if($this->checkPassword($oldPassword,$userName)){
    $this->Connect();
    $sth=$this->pdo->prepare("UPDATE user SET USER_PASSWORD=? WHERE USER_NAME =? ");
    $sth->execute([$newPassword,$userName]);
  }else{
    echo "incorrect password";
  }
}


public function deleteAccount($user_id){
  $this->Connect();
  $sth=$this->pdo->prepare("DELETE FROM `user` WHERE USER_ID =?; ");
  $sth->execute([$user_id]);
  
}

}


?>