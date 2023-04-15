
const pin = {
  pin_id: "pin1",
  pin_location: 1

 
	

};

 this.update_pin = function(loc) {
       pin.pin_location= loc;
    }

 this.draw_pin = function(loc) {
       document.getElementById("pin1").innerHTML =
    this.pin_location ;
    }

      
	
	document.getElementById("pin1").innerHTML =
    pin.pin_location ;