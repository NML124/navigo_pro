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

        getWeather(lat, lng);

    }
};
request.open("GET", "get_session_data.php", true);
request.send();

function getWeather(lat, lon) {
    const API_key = "c7c670118d30b43fc815538d0a183d05";
    let url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${API_key}&units=metric`;
    fetch(url).then((response) =>
        response.json().then((data) => {
            console.log(data);
            document.querySelector('#city').innerHTML = 'Name of city : ' + data.name;
            document.querySelector('#temp').innerHTML = "<i class='fa-solid fa-temperature-three-quarters'></i>" + 'Temperature : ' + data.main.temp + '°';
            document.querySelector('#humidity').innerHTML = "<i class='fa-solid fa-droplet-percent'></i>" + 'Humidity : ' + data.main.humidity + '%';
            document.querySelector('#wind').innerHTML = "<i class='fa-solid fa-wind'></i>" + 'Wind : ' + data.wind.speed + 'Km/h';
        })
    );
}

