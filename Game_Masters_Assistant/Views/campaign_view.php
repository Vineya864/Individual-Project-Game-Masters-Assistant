<?php

class campaignView{
	
	
	
		public function displayCampagin($campaign){
			if ($campaign != null){

					$name = $campaign->CAMPAIGN_NAME;
					echo "<h1>$name</h1>";
					?>
			
			<?php
			}else{
				echo "<h3>no Campaign </h3>";
			}
			
		}


		public function displayCampaginSelectionGm($campaign,$token){
			if ($campaign != null){
				$name = $campaign->CAMPAIGN_NAME;?>

				<form method = "post" action= "">
				<input type  = "hidden" name="Campaign_id" value="<?php echo $campaign->CAMPAIGN_ID ?>" />
				<input type  = "hidden" name="token" value="<?php echo $token ?>" />
				<input type  = "submit" name="Campaign" value="<?php echo $name ?>"/>
				</form>
			</br>
				
				<?php
		
				
			}

		}

		public function showCampaignSelectionByID($campaign,$token){
			if ($campaign != null){
				$name = $campaign->CAMPAIGN_NAME;?>

				<form method = "post" action= "">
				<input type  = "hidden" name="Campaign_id" value="<?php echo $campaign->CAMPAIGN_ID ?>" />
				<input type  = "hidden" name="token" value="<?php echo $token ?>" />
				<input type  = "submit" name="Campaign" value="<?php echo $name ?>"/>
				</form>

				
				<?php
		
				
			}

		}

		
	
	
	
}