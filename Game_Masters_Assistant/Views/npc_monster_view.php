<?php

class NPCMonsterView{
	
/* show player character details
*/

		public function displayCharacter($character){
			if ($character != null){
				?>
				
				<div class= 'character_sheet'>
				<?php
					$name = $character->MONSTER_NAME;
					echo "<h3>$name</h3>";
					?>
			</div>
			<?php
			}else{
				echo "<h3>no Character </h3>";
			}
			
		}
		
		
		
		public function displayCharacterDropDown($character,$token){
			
			if ($character != null){
				$name = $character->MONSTER_NAME;
				?>
				<?php echo "<h1>$name</h1>"; ?> 
					<?php
					?></p>
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user_character" value="<?php echo $character->MONSTER_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Open_Details_Monster" value="Open Details"/>
				</form>
				
			<?php
			}else{
				echo "<p>no Character <p>";
			}
			
		}


		public function displayCharacterActiveStatus($character,$token){
			if ($character != null){
				$name = $character->MONSTER_NAME;
				?>
				<?php echo "<h3>$name</h3>"; ?> 
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user_character" value="<?php echo $character->MONSTER_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Open_Details_NPC" value="Open Details"/>
				
				<?php 
				if($character->ACTIVE==0){
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
				echo "<p>no Character <p>";
			}
			
		}


		public function displayCharacterSheet($character){
			if ($character != null){
				$name = $character->MONSTER_NAME;
				?>
								
				<div id="character_sheet">
				<?php
				echo "<h1>$name</h1>";
					$stats = $character->MONSTER_STATS;
					$arrayStats= explode(",",$stats);
					for ($x =0; $x< count($arrayStats); $x++){
						$stat = explode(":",$arrayStats[$x]);
						if(isset($stat[1]) ){
						$title = $stat[0];
						$level = $stat[1];
						?>
						<input type="text" id="<?php echo $title ?>" name="<?php echo $title ?>" value="<?php echo $title ?> "readonly>
						<input type="text" id="<?php echo $title.$level ?>" name="<?php echo $title.$level ?>" value="<?php echo $level ?> "readonly><br/> 
						<?php
					}}
                    ?>
                 	<textarea id ="note_text" name="note_text"><?php echo $character->NOTES?></textarea></br>
			<?php
			}else{
				echo "<p>no Character <p>";
			}
			

			?></div><?php
			
		}
	
}