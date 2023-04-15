<?php

class StatusEffectView{
		public function displayCharacter($effect){
			if ($character != null){
				?>
				
				<div class= 'character_sheet'>
				<?php
					$name = $effect->EFFECT_NAME;
					echo "<h3>$name</h3>";
					?>
			</div>
			<?php
			}else{
				echo "<h3>No Status Effect </h3>";
			}
			
		}		
		public function displayEffectDropDown($effect,$token){
			if ($effect != null){
				$name = $effect->EFFECT_NAME;
				?>
				<?php echo "<h1>$name</h1>"; ?> 
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="status_effect" value="<?php echo $effect->EFFECT_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Open_Details_Effect" value="Open Details"/>
				</form>
				
			<?php
			}else{
				echo "<p>No Status Effect <p>";
			}
			
		}


		public function displayEffectActiveStatus($effect,$token){
			if ($effect != null){
				$name = $effect->EFFECT_NAME;
				?>
				<?php echo "<h3>$name</h3>"; ?> 
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="status_effect" value="<?php echo $effect->EFFECT_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Open_Details_Effect" value="Open Details"/>
				
				<?php 
				if($effect->ACTIVE==0){
					?>
					<input type  = "submit" name="make_active" value="Make Active"/>
					</form><?php
				}else{
					?>
					<input type  = "submit" name="make_inactive" value="Make Inactive"/>
					</form>
					<?php	
				}

				?>
				
			<?php
			}else{
				echo "<p>No Status Effect <p>";
			}
			
		}


		public function displayEffectSheet($effect){
			if ($effect != null){
				$name = $effect->EFFECT_NAME;
				?>
								
				<div id="character_sheet">
				<?php
				echo "<h1>$name</h1>";
                ?>
                <textarea readonly id ="note_text" name="note_text"><?php echo $effect->NOTES?></textarea></br>				
			<?php
			}else{
				echo "<p>no Character </p>";
			}
			?></div><?php			
		}
	
}