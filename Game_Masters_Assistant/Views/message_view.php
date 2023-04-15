<?php

class MessageView{
	


		public function displayMessage($message){
			if ($message != null){
				?>
				<div class= 'message'>
				<?php
					$message = $message->MESSAGE;
					if(str_contains($message, "Announcement:")){
						echo "<p style=color:red> $message</p>";
					}elseif(str_contains($message, ":Dice:")){
						echo "<p style=color:gray> $message</p>";
					}else{
					    echo "<p> $message</p>";
					}
					?>
			</div>
			<?php
			}
			
		}

		

	
}
?>