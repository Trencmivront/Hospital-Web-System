document.querySelectorAll(".qa-question").forEach(function(btn){

btn.addEventListener("click", function(){

const answer = this.nextElementSibling;

if(answer.style.display === "block"){
answer.style.display = "none";
}
else{
answer.style.display = "block";
}

});

});
