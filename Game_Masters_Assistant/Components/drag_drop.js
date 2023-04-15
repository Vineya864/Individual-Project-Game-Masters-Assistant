
  
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev, pin) {
  ev.dataTransfer.setData("text", ev.target.id);
  sessionStorage.currentPin = pin ;
}



function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  
  ev.target.appendChild(document.getElementById(data));

  
  
}
