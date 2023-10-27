var request = new XMLHttpRequest();
request.onreadystatechange = function () {
    if (request.readyState === 4 && request.status === 200) {
        var reponse = request.responseText;
        var data = JSON.parse(reponse);

        var name = data.name;
        var first_name = data.first_name;
        var port = data.port;
        var address = data.address;
        var lat = data.lat;
        var lng = data.lng;

        init(port, address, lat, lng, name, first_name);

    }
};
request.open("GET", "get_session_data.php", true);
request.send();


function init(port, address, lat, lng, name, first_name) {
    /*Part for authentifie operator*/
    console.log('inside initMap');

    const map = L.map('map').setView([lat, lng], 13);
    const mainLayers = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });
    mainLayers.addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup('Name : ' + port + '<br>Address : ' + address + '<br>Operator name : ' + name + ' ' + first_name)
        .openPopup();

    map.setView([lat, lng], 12);

    fetch("get_all_data.php")
        .then(response => response.json()) // On convertit la réponse en objet JS
        .then(data => {
            // On parcourt le tableau des données avec une boucle for...of
            for (let operator of data) {
                // On récupère les informations de chaque recette
                var name_other = operator.name;
                var first_name_other = operator.first_name;
                var port_other = operator.port;
                var address_other = operator.address;
                var address_decode = decodeURIComponent(address_other.replace(/\+/g, ' '));

                var latitude = operator.lat; // On corrige la casse ici
                var longitude = operator.lng;

                if (address_decode != address) {
                    L.marker([latitude, longitude]).addTo(map)
                        .bindPopup('Chief Operator : ' + name_other + ' ' + first_name_other + '<br>Name of port : ' + port_other + '<br>Address : ' + address_decode)
                        .openPopup();
                }
            }

            // Ajouter des marqueurs pour chaque bateau
            function addBoatMarker(boat) {
                var marker = L.marker([boat.latitude, boat.longitude]).addTo(map);
                marker.bindPopup("<b>" + boat.name + "</b><br>" + boat.speed + " knots").openPopup();
            }

            // Récupérer les données de position des bateaux à intervalles réguliers
            setInterval(function () {
                // Récupérer les données de position des bateaux via une requête AJAX
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "getBoatsPositions.php", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var boats = JSON.parse(xhr.responseText);
                        for (var i = 0; i < boats.length; i++) {
                            var boat = boats[i];
                            addBoatMarker(boat);
                        }
                    }
                };
                xhr.send();
            }, 5000);
        });
}
