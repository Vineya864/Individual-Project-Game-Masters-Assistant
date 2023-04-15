<?php

class InviteView{
	


		public function displayPlayers($Player){
			
			echo $Player->username.", ";
			
			
		}


		public function showInviteOptions($invite_name,$invite_gm,$invite_id,$token){
			echo "<p>$invite_name : $invite_gm</p>";
			?>
			<div id="invite_reponse">
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="invite_id" value="<?php echo $invite_id; ?>" />
				<input type  = "submit" name="accept_invite" value="Accept"/>
				<input type  = "submit" name="refuse_invite" value="Refuse"/>
				</form>
			</div>
			</br>
			<?php

		}



		

	
}
?>