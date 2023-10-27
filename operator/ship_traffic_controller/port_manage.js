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

        weather_data(lat, lng, name, first_name, port, address);

    }
};
request.open("GET", "get_session_data.php", true);
request.send();

function weather_data(lat, lng, name, first_name, port, address) {
    //For a weather data
    const API_key = "c7c670118d30b43fc815538d0a183d05";
    let url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lng}&appid=${API_key}&units=metric`;
    fetch(url).then((response) =>
        response.json().then((data) => {
            console.log(data);
            document.querySelector('#city').innerHTML = 'Name of city : ' + data.name;
            document.querySelector('#temp').innerHTML = "<i class='fas fa-thermometer-half'></i>" + 'Temperature : ' + data.main.temp + '°';
            document.querySelector('#humidity').innerHTML = "<i class='fas fa-tint'></i>" + 'Humidity : ' + data.main.humidity + '%';
            document.querySelector('#wind').innerHTML = "<i class='fas fa-wind'></i>" + 'Wind : ' + data.wind.speed + 'Km/h';

            //For profil
            document.querySelector('#name').innerHTML = 'Name : ' + name;
            document.querySelector('#first_name').innerHTML = 'first name : ' + first_name;
            document.querySelector('#port').innerHTML = 'Port : ' + port;
            document.querySelector('#address').innerHTML = 'Address : ' + address;
        })
    );
}
