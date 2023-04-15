var target = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < target.length; i++) {
  target[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var collapsible_content = this.nextElementSibling;
    if (collapsible_content.style.maxHeight){
      collapsible_content.style.maxHeight = null;
    } else {
      collapsible_content.style.maxHeight = collapsible_content.scrollHeight + "px";
    } 
  });
}

