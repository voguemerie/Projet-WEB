<?php 
    header("Access-Control-Allow-Origin: *");
    session_start();
    $_SESSION["log"] ??= false;


    if(!$_SESSION["log"]){
        header('Location:login.php');  //redirection sur le login lorsque l'on arrive sur la page
        
        exit;
    }      
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Musées</title>
    <!-- <script src="index_burger.js"></script> -->
    <link rel="stylesheet" href="style_indexng.css">
    <script src="meteo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- icone burger --> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjGU6qqUqh4U4BOgbd2yIgyKHTkNw4YTc&libraries=places"></script>
    <script src="http://openlayers.org/api/OpenLayers.js"></script>

    <!-- <script type=text/javascript src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- icone utilisateur--> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- icone serach --> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    

</head>
<body>
    <header>
        <nav>
            <ul id="nav-bar">
                <li><a href="#commentaire">Accès commentaires</a></li>
                <li><a href="">Les musées</a></li>
                <li><a href="">Nous contacter</a></li>
                <div id="floating-panel">
                    <b>Mode de transport: </b>
                    <select id="mode">
                        <option value="DRIVING">Voiture</option>
                        <option value="WALKING">Marche</option>
                        <option value="BICYCLING">Vélo</option>
                        <option value="TRANSIT">Transports en commun</option>
                    </select>
                </div>
                <input type="search" name="search-bar" id="search-bar" placeholder="Search...">
                <span id="search-icon" class="material-symbols-outlined">search</span>
                <li><a href="login.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <p name="mess_log" id="mess_log">Bonjour, bienvenue sur la carte des musées de Paris !</p>   
    <!----------------------- METEO ------------------------>
    <div class="weatherCard">
        <div class="currentTemp">
            <span class="temp" id="zone_meteo">°C</span>
            <span class="location">Météo de <br> Paris</span>
        </div>
    </div>
    <!------------------------------------------------------>
    <div class="itineraire">
        <div id="pac-container">    
            <input id="pac-input" type="text" placeholder="Adresse de départ" />
        </div>
        <select id="list1"></select>
        <button id= entrer>Valider</button>
    </div>
    <div id="container">
      <div id="map" style="width: 1000px; height: 600px;" ></div>
      <div id="sidebar"></div>
    </div>

    <div id="commentaire" class="commentaire">
        <h1>Envoyez nous vos commentaires !</h1>
        <p> Votre avis nous intéresse, racontez-nous comment s'est passé votre visite :)</p>
        <textarea name="comment_area" id="comment_area" cols="30" rows="10" placeholder="taper votre commentaire ici"></textarea>
        <button id="post_comment">commenter</button>
    </div>
    

    <div id="steps" style="display: none;"></div>

    
</body> 

<script>
     
    $(document).ready(function(){
            $("#post_comment").click(function(){
                var ajaxURL = "addcomment.php";
                var data = {'content':$("#comment_area").val(), 'user':1, 'date':Date.now()}
                $.post(ajaxURL, data, function(res){});
                $("#comment_area").val('');
            });
        });
    // function initMap() {
    const directionsRenderer = new google.maps.DirectionsRenderer();
    const directionsService = new google.maps.DirectionsService();
    const map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 48.863753, lng: 2.336715},
        zoom: 12,
    });
    directionsRenderer.setPanel(document.getElementById("sidebar"));
    directionsRenderer.setMap(map);
    calculateAndDisplayRoute(directionsService, directionsRenderer);
    document.getElementById("mode").addEventListener("change", () => {
        calculateAndDisplayRoute(directionsService, directionsRenderer);
    });
    // }
        
    const icon = {
        url: 'icone.png', // url
        scaledSize: new google.maps.Size(20, 25), // scaled size
        origin: new google.maps.Point(0,0), // origin
        anchor: new google.maps.Point(0, 0) // anchor
    };

    $.ajax({
        method: 'GET',
        url: "https://data.culture.gouv.fr/api/records/1.0/search/?dataset=liste-et-localisation-des-musees-de-france&q=&rows=131&facet=region_administrative&facet=departement&refine.region_administrative=%C3%8Ele-de-France&refine.departement=Paris",
        success : function(data){
            JSON.stringify(data)
            
            var lat,lon;
            for (let i = 0; i < data['records'].length; i++) {
                lat=data['records'][i]['fields']['geolocalisation'][0];
                lon=data['records'][i]['fields']['geolocalisation'][1];
                var url=data['records'][i]['fields']['url'];
                var S="site officiel du musée";
                var currentInfoWindow = null;
                var marker = new google.maps.Marker({
                position: {lat: lat, lng: lon},
                map: map,
                title: data['records'][i]['fields']["nom_officiel_du_musee"],
                icon:icon
                });
                

                var select= document.getElementById ("list1");
                        var newOption = new Option (data['records'][i]['fields']["nom_officiel_du_musee"]);
                        select.options.add (newOption);
                        // add click event
                        
                (function (marker, i) {
                google.maps.event.addListener(marker, 'click', function () {
                    infowindow = new google.maps.InfoWindow({
                    content: data['records'][i]['fields']["nom_officiel_du_musee"]+'<br>'+S.link("https://"+data['records'][i]['fields']['url'])+'<br>'
                    });
                    
                    infowindow.open(map, marker);
                    if (currentInfoWindow != null) {
                    currentInfoWindow.close();
                    }
                    infowindow.open(map, marker);
                    currentInfoWindow = infowindow;
                                    });
                })(marker, i);
            }
        }        
    });

    //////////////////////////////////// METEO ////////////////////////////////////////////////////////////////////
    $.ajax({
        type: "GET",
        url: "https://api.openweathermap.org/data/2.5/weather?lat=48.853&lon=2.349&appid=cc496e03e4215064006f974df45c603a", 
        success: function(retour){
            console.log(retour.main.temp -273.15);
            $("#zone_meteo").html(Math.floor(retour.main.temp -273.15));
        }
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    const input = document.getElementById("pac-input");
    const options = {
    fields: ["formatted_address", "geometry", "name"],
    bounds : { // bounds of NSW
        "south": -54.5247541978,
        "west": 2.05338918702,
        "north": 9.56001631027,
        "east": 51.1485061713
        },
        componentRestrictions: {
        country: 'fr'
        },
    };
    const autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.bindTo("pac-input", map);
    const onChangeHandler = function () {
    calculateAndDisplayRoute(directionsService, directionsRenderer);
    };
  

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        const start = document.getElementById("pac-input").value;
        const end = document.getElementById("list1").value;
        const selectedMode = document.getElementById("mode").value;

        directionsService
            .route({
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode[selectedMode],
            })
            .then((response) => {
            directionsRenderer.setDirections(response);
            })
    }
    document.getElementById("entrer").addEventListener("click",onChangeHandler);

        
</script>
</html>