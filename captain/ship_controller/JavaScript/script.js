
/* import {envoyerDonnees, recupererDonnees} from "./Request.js" */

var slider = document.getElementById("myRange");
var sliderValue = slider.value;
//var nameFile = "boatproject4.txt"
var nameFile = "web_to_arduino.txt"

slider.oninput = function() {
  sliderValue = this.value;
}

const speed = document.getElementById("motor-speed");

slider.addEventListener("input" , function() {
    speed.textContent = sliderValue
    // envoyerDonnees(nameFile, "La valeur du slider est :", sliderValue,"Super !")
});

var url = "https://op-dev.icam.fr/~icam/boatproject4.txt"


// setInterval(callPHP, 2000);
// setInterval(callPHP, 5000);
console.log("Un nouvel essai")




function envoyerDonnees(fileName, speed, direction, action) {
  const url = "https://op-dev.icam.fr/~icam/recordLocation.php";
  
  fetch(`${url}?fileName=${fileName}&lat=${speed}&lon=${direction}&action=${action}`, { mode: 'no-cors' })
  .then(response => response.text())
  .then(data => console.log(data))
  .catch(error => console.error(error));
}

function callPHP() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var data = JSON.parse(xhr.responseText);
      console.log("Les valeurs de php sont :");
      console.log(data.accelero);
      console.log(data.gyro);
      console.log(data.gps);

      var table1 = data.accelero.toString().split(",");
      var table2 = data.gyro.toString().split(",");
      var table3 = data.gps.toString().split(",");

      console.log("La table est :");
      console.log(table1);
      document.getElementById("acx").textContent = table1[0];
      document.getElementById("acy").textContent = table1[1];
      document.getElementById("acz").textContent = table1[2];

      document.getElementById("gyx").textContent = table2[0];
      document.getElementById("gyy").textContent = table2[1];
      document.getElementById("gyz").textContent = table2[2];

      document.getElementById("longi").textContent = table3[0];
      document.getElementById("lati").textContent = table3[1];

      document.getElementById("ult").textContent = table3[3];
      console.log("La ligne ultra est :");
      console.log(table3[3]);
      
    }
  };
  xhr.open("GET", "filescript.php", true);
  xhr.send();

}


function transfer() {
  const vitesse = sliderValue.toString();
  const directionAngle = angle.toString();
  const actionDrop = drop.toString() + "," + mode.toString();

  console.log("Le test marche")
  envoyerDonnees(nameFile,vitesse, directionAngle, actionDrop)
}

setInterval(transfer, 2000);
setInterval(callPHP, 2000);