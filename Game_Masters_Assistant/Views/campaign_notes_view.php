<?php

class campaignNotesView{
	
	
	
			public function displayCampaginNotesTabs($note){
				?>
				<div class="tab">
  				<button class="tablinks" onclick=" openNotes(event, <?php echo $note->id ?>)"><?php echo $note->chapter ?></button>
				</div>
				<?php	
			}
			public function displayCampaginNotesContent($note,$token){
				?>
				<div id="<?php echo $note->id ?>" class="tabcontent">
  				<h3>
				<?php  echo $note->chapter ?>
				</h3>
  				<p>
				  <?php  echo $note->notes ?>
				</p>
				<div id="edit_button">
				<form method = "post" action= "">
				<input type  = "hidden" name="token" value="<?php echo $token; ?>" />
				<input type  = "hidden" name="note_id" value="<?php echo $note->id; ?>" />
				<input type  = "submit" name="edit_note" value="Edit Note"/>
				</form>
				</div>
				</div>

				
				<?php
			}
	
	
	
}