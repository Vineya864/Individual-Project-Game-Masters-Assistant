<?php

class playerCharacterView{
	
/* show player character details
*/

		public function displayCharacter($character){
			if ($character != null){
				?>
				
				<div class= 'character_sheet'>
				<?php
					$name = $character->CHARACTER_NAME;
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
				$name = $character->CHARACTER_NAME;
				?>
				
				<?php echo "<h3>$name</h3>"; ?> 
				
				<?php
					// $stats = $character->CHARACTER_STATS;
					// $arrayStats= explode(",",$stats);
					// $primary = $arrayStats[0] ;
					// echo "<p>$primary";
					// for ($x =1; $x< count($arrayStats); $x++){
					// 	echo "</br>$arrayStats[$x]";
					// 	?>
						
					 	<?php
					// }
					?></p>
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="user_character" value="<?php echo $character->CHARACTER_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Open_Details_Character" value="Open Details"/>
				</form>
			
			<?php
			}else{
				echo "<p>no Character <p>";
			}
			
		}


		public function displayCharacterSheet($character){
			if ($character != null){
				$name = $character->CHARACTER_NAME;

				echo "<h1>$name</h1>";
				if(!is_null($character->PICTURE)){
				$picture = $character->PICTURE;
				
				?>
				<div id= "character_picture">
				<img src="<?php echo $picture ?>" alt="Character Picture">
				</div>

				<?php
				}
					$stats = $character->CHARACTER_STATS;
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
					<textarea id ="note_text" name="note_text"><?php echo $character->CHARACTER_NOTES?></textarea></br>
					<?php
					?>
			<?php
			}else{
				echo "<p>no Character <p>";
			}
			?><?php
			
		}
	
}