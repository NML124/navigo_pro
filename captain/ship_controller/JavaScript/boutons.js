
const btnUp = document.getElementById("btn-up");
const btnDown = document.getElementById("btn-down");
const btnRight = document.getElementById("btn-right");
const btnLeft = document.getElementById("btn-left");

const valueBtn = document.getElementById("position-control");
const valueBtn2 = document.getElementById("position-control2");


var drop = "stop,stop";
var drop1 = "stop";
var drop2 = "stop";
var test = false;



btnUp.addEventListener('click', function() {
    test =! test;
    if (test == false) {
        drop1 = "up";
    } else {
        drop1 = "stop";
    }
    
    drop = drop1 +","+ drop2;
    valueBtn.textContent = drop1
});

btnDown.addEventListener('click', function() {
    test =! test;
    if (test == false) {
        drop1 = "down";
    } else {
        drop1 = "stop";
    }
    drop = drop1 +","+ drop2;
    valueBtn.textContent = drop1
});

btnRight.addEventListener('click', function() {
    drop2 = "go"
    drop = drop1 +","+ drop2;
    valueBtn2.textContent = drop2
});

btnLeft.addEventListener('click', function() {
    drop2 = "back"
    drop = drop1 +","+ drop2;
    valueBtn2.textContent = drop2
});


const btnMode = document.getElementById("btnmode");
const afficher = document.querySelectorAll("#control");
const panel = document.querySelector(".Panel-control");
var mode = "off"

for (var i = 0; i < afficher.length; i++) {
    afficher[i].style.display = "none";
  }
panel.style.height = "200px";

btnMode.addEventListener('click', function() {
    if (btnMode.textContent == "OFF") {
        btnMode.textContent = "ON"
        btnMode.style.background = "#e73844"
        for (var i = 0; i < afficher.length; i++) {
            afficher[i].style.display = "block";
          }
        panel.style.height = "900px";
        mode = "on"
    } else {
        btnMode.textContent = "OFF"
        btnMode.style.background = "#2b4078"
        for (var i = 0; i < afficher.length; i++) {
            afficher[i].style.display = "none";
          }
        panel.style.height = "200px";
        mode = "off"
    }
});