<?php

class ItemView{
	
/* show player character details
*/

		public function displayItem($item){
			if ($item != null){
				?>
				
				<div class= 'item'>
				<?php
					$name = $item->ITEM_NAME;
					echo "<h3>$name</h3>";
					?>
			</div>
			<?php
			}else{
				echo "<h3>no item </h3>";
			}
			
		}
		
		
		
		public function displayItemDropDown($item,$token){
			if ($item != null){
				$name = $item->ITEM_NAME;
				?>
				
				<?php echo "<h3>$name</h3>"; ?> 
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="item_id" value="<?php echo $item->ITEM_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Open_Details_Item" value="Open Details"/>
				</form>
			<?php
			}else{
				echo "<p>no item <p>";
			}
			
		}


		public function displayItemActiveStatus($item,$token){
			if ($item != null){
				$name = $item->ITEM_NAME;
				?>
				<button type="button" class="collapsible" ><?php echo "<p>$name</p>"  ?></button>
				<div class="content">
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="current_item" value="<?php echo $item->ITEM_ID; ?>" />
				<input type  = "hidden" name="user" value="<?php echo $_SESSION['login']; ?>" />
				<input type  = "submit" name="Open_Details_Item" value="Open Details"/>
				<?php 
				if($item->ACTIVE==0){
					?>
					<input type  = "submit" name="make_active" value="Make Active"/>
					</form>
					</div><?php
				}else{
					?>
					<input type  = "submit" name="make_inactive" value="Make Inactive"/>
					</form>
				
					<form method ="post" action="">
					<input type  = "String" name = "name" placeholder="UserName" required/> 
					<input type  = "hidden" name="current_item" value="<?php echo $item->ITEM_ID; ?>" />	
					<input type  = "hidden" name="token" value="<?php echo $token; ?>" /></br>
					<input type  = "submit" name="assign_item" value="Assign to Player"/>
					<input type  = "submit" name="take_item" value="Remove from Player"/>
					</form>		
				</div>
					<?php	
				}
				?>
				
			<?php
			}else{
				echo "<p>no item <p>";
			}
			
		}


		public function displayItemSheet($item){
			if ($item != null){
				$name = $item->ITEM_NAME;
				?>
								
				<div id="character_sheet">
				
				<?php
				echo "<h1>$name</h1>";
					?>
                <textarea id ="note_text" name="note_text"><?php echo $item->ITEM_DESCRIPTION?></textarea></br>
			<?php
			}else{
				echo "<p>no item <p>";
			}
			

			?></div><?php
			
		}
	
}