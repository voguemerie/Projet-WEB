<?php
header("Access-Control-Allow-Origin: *");
session_start();
// require_once("inscription.php");
$_SESSION["log"] ??= false;


if (!$_SESSION["log"]) {
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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjGU6qqUqh4U4BOgbd2yIgyKHTkNw4YTc&libraries=places"></script>
    <script src="http://openlayers.org/api/OpenLayers.js"></script>

    <!-- icone serach -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />


</head>

<body>
    <header>
        <nav>
            <ul id="nav-bar">
                <li><a href="#content_com">Accès commentaires</a></li>
                <li><a href="">Les musées</a></li>
                <li><a href="contact.php">Nous contacter</a></li>
                <div id="floating-panel">
                    <b>Mode de transport: </b>
                    <select id="mode">
                        <option value="DRIVING">Voiture</option>
                        <option value="WALKING">Marche</option>
                        <option value="BICYCLING">Vélo</option>
                        <option value="TRANSIT">Transports en commun</option>
                    </select>
                </div>
                <input type="text" id="search-bar" placeholder="Rechercher un musée" list="musee">
                <datalist id=musee></datalist>
                <button id="chercher" class="material-symbols-outlined">search</button>
                <!-- <button id="chercher">search</button> -->
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
            <button id="posi" class="material-symbols-outlined">pin_drop</button>
        </div>
        <select id="list1"></select>
        <button id=entrer>Valider</button>
        <button id="reset">Annuler</button>
    </div>
    <div id="container">
        <div id="map" style="width: 1000px; height: 600px;"></div>
        <div id="sidebar"></div>
    </div>

    <div class="commentaire">
        <h1>Envoyez nous vos commentaires !</h1>
        <p> Votre avis nous intéresse, racontez-nous comment s'est passé votre visite :)</p>
        <textarea name="comment_area" id="comment_area" cols="30" rows="10" placeholder="Rédigez votre commentaire"></textarea>
        <button id="post_comment">Commenter</button>
    </div>


    <div id="steps" style="display: none;"></div>

</body>

<script>
    $(document).ready(function() {
        $("#post_comment").click(function() {
            var ajaxURL = "addcomment.php";
            var data = {
                'content': $("#comment_area").val(),
                'user': 1,
                'date': Date.now()
            }
            $.post(ajaxURL, data, function(res) {});
        });
    });

    var directionsRenderer = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();
    var map = new google.maps.Map(document.getElementById('map'), { //initialisation de la map
        center: {
            lat: 48.863753,
            lng: 2.336715
        },
        zoom: 13,
    });

    document.getElementById("mode").addEventListener("change", () => {
        calculateAndDisplayRoute(directionsService, directionsRenderer);
    });

    const icon = {
        url: 'icone.png', // url
        scaledSize: new google.maps.Size(20, 25), // scaled size
        origin: new google.maps.Point(0, 0), // origin
        anchor: new google.maps.Point(0, 0) // anchor
    };

     //////////////////////////////////// METEO ////////////////////////////////////////////////////////////////////
     $.ajax({
        type: "GET",
        url: "https://api.openweathermap.org/data/2.5/weather?lat=48.853&lon=2.349&appid=cc496e03e4215064006f974df45c603a",
        success: function(retour) {
            console.log(retour.main.temp - 273.15);
            $("#zone_meteo").html(Math.floor(retour.main.temp - 273.15));
        }
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    var markers = [];
    var search = document.getElementById("chercher");




    $.ajax({ //requete ajax pour prendre les informations des musées
        method: 'GET',
        url: "https://data.culture.gouv.fr/api/records/1.0/search/?dataset=liste-et-localisation-des-musees-de-france&q=&rows=131&facet=region_administrative&facet=departement&refine.region_administrative=%C3%8Ele-de-France&refine.departement=Paris",
        success: function(data) {
            JSON.stringify(data)

            var lat, lon;
            var select = document.getElementById("list1");
            var select2 = document.getElementById("musee");
            var str = '';
            for (let i = 0; i < data['records'].length; i++) {
                lat = data['records'][i]['fields']['geolocalisation'][0];
                lon = data['records'][i]['fields']['geolocalisation'][1];
                var url = data['records'][i]['fields']['url'];
                var S = "site officiel du musée";
                var currentInfoWindow = null;
                var marker = new google.maps.Marker({
                    position: {
                        lat: lat,
                        lng: lon
                    },
                    map: map,
                    title: data['records'][i]['fields']["nom_officiel_du_musee"],
                    icon: icon
                });
                markers.push(marker);



                var newOption = new Option(data['records'][i]['fields']["nom_officiel_du_musee"]); //ajout des options dans la liste déroulante
                select.options.add(newOption);

                str += "<option>" + newOption.value + "<option/>"; // ajout des suggestions de la barre de recherches
                var my_list = document.getElementById("musee");
                my_list.innerHTML = str;
                // console.log(markers);
                console.log(markers[0]["title"]);

                (function(marker, i) {
                    google.maps.event.addListener(marker, 'click', function() {
                        var infowindow = new google.maps.InfoWindow({
                            content: data['records'][i]['fields']["nom_officiel_du_musee"] + '<br>' + S.link("https://" + data['records'][i]['fields']['url'])
                        });
                        infowindow.addListener('closeclick', function() {
                            map.panTo(new google.maps.LatLng(48.863753, 2.336715))
                            map.setZoom(13);
                        });

                        infowindow.open(map, marker);
                        if (currentInfoWindow != null) {
                            currentInfoWindow.close();
                        }
                        infowindow.open(map, marker);
                        currentInfoWindow = infowindow;
                        map.panTo(new google.maps.LatLng(marker.position));
                        map.setZoom(18);

                    });

                })(marker, i);

            }

        }
    });


    function trouver() { //centrer sur le musée cherché avec la barre de recherche
        var recherche = document.getElementById("search-bar").value;
        for (j = 0; j < markers.length; ++j) {
            if (markers[j]["title"] == recherche) {
                map.panTo(new google.maps.LatLng(markers[j]["position"]));
                map.setZoom(18);
                console.log(j)
            }
        }

    };

    search.addEventListener("click", trouver);

    $user_pop = document.getElementById("user_pop-up");

    function openForm() { //Fonction pour faire apparaitre le formulaire user_pop-up  
        document.getElementById("user_pop-up").style.display = "block";
        document.getElementById("user_icon").style.display = "none";

    }

    function closeForm() { //Fonction pour faire disparaitre le formulaire user_pop-up
        $user_pop.style.display = "none";
        document.getElementById("user_icon").style.display = "block";
    }


    var input = document.getElementById("pac-input");
    const options = {
        fields: ["formatted_address", "geometry", "name"],
        bounds: { // bounds of NSW
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

    function onChangeHandler() {
        calculateAndDisplayRoute(directionsService, directionsRenderer);
    };

    const reset = document.getElementById("reset")
    reset.addEventListener("click", supprimer);

    function supprimer() {
        directionsRenderer.setMap(null);
        // directionsRenderer.setDirections(null);
        console.log(directionsRenderer)
        directionsRenderer.setPanel(null)



    }

    function getAdresse() {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lati = position.coords.latitude;
            var lng = position.coords.longitude;
            const geocoder = new google.maps.Geocoder();
            var pos = position.coords.latitude + "," + position.coords.longitude
            input.value = pos;
        })
    }

    var po = document.getElementById("posi");
    po.addEventListener("click", getAdresse);

    function calculateAndDisplayRoute(directionsService, directionsRenderer) { //calcul de l'itinéraire
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
            .catch((e) => window.alert("Directions request failed due to " + status));
    }
    document.getElementById("entrer").addEventListener("click", valider);

    function valider() {
        directionsRenderer.setPanel(document.getElementById("sidebar"));
        directionsRenderer.setMap(map);
        onChangeHandler();
    }
   
</script>

</html>