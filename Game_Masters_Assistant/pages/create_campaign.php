<?php
/* used to create a campaign is only refrenced in the launch_selection page */

session_start();
if( hash_equals($_SESSION['token'], $_POST['token'])){
include_once("../Controllers/campaign_controller.php");
include_once("../Controllers/user_controller.php");
include_once("../Controllers/user_controller.php");
include_once("../Controllers/invite_controller.php");
$invite        = new InviteController(null,null);
$user= new UserController(null,null);
$user_class = ($user->getUserByUsername($_SESSION['login']));
$user_id = $user_class->id;
$campaign= new CampaignController(null,null);
$current_campaign= $campaign->createCampaign(filter_var($_POST['Campaign_Name'], FILTER_SANITIZE_STRING),$user_id); 
$new_invite=$invite ->send_invite($user_id,$current_campaign);
$invite->resolve_invite($new_invite, 1);
?>
<script> window.location.replace("launch_selection.php") </script>
<?php

}

?>