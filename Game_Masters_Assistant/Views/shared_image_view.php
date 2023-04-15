<?php

class sharedImageView{
	
/* show player character details
*/


		
		
		
		public function displayImageDropDown($image,$token){
			if ($image != null){
                ?>
				<div class= "image_selector">
                <form action="" method="post" >
                <img src="<?php echo $image->path ?>" alt= "<?php echo $image->id ?>" />
				<input type="hidden" name="image_id" value="<?php echo $image->id ?>" />
				<input type="hidden" name="token" value="<?php echo $token ?>" /></br>
                <input type="submit" name="Change_Image" value="Share"  >
                <input type="submit" name="Delete_Image" value="delete"  ></br>
				<input type="submit" name="Ground_Image" value="Set Wallpaper"  >
                </form>
			</div>
			<?php
			}else{
				echo "<p>no image <p>";
			}
			
		}

	
}