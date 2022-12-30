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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Musées</title>
    <!-- <script src="index_burger.js"></script> -->
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
                <li><a href="">Accès commentaires</a></li>
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
                <li><a href="login.php">Connexion</a></li>
                
            </ul>
            
        </nav>
    </header>

    <p name="mess_log" id="mess_log">Bonjour, <!--<?php $_GET["login"] ?> --> vous êtes connecté</p>   

    <!-- <div id="map" style="width: 1000px; height: 800px;" ></div> -->
    <!-- changement de taille pour map à faire ici -->
    <div id="container">
      <div id="map" style="width: 1000px; height: 600px;" ></div>
      <div id="sidebar"></div>
    </div>
    
    <p id="zone_meteo">toto</p>
    
    <div class="itineraire">
        <div id="pac-container">
            <input id="pac-input" type="text" placeholder="Entrer l'adresse" />
        </div>
        <select id="list1"></select>
        <button id= entrer>Valider</button>
    </div>
    

    <div class="commentaire">
        <textarea  name="comment_area" id="comment_area" cols="30" rows="10" placeholder="taper votre commentaire ici"></textarea>
        <button  id="post_comment">commenter</button>
    </div>
    

    <div id="steps" style="display: none;"></div>

    
</body>

<script>
     
    $(document).ready(function(){
            $("#post_comment").click(function(){
                var ajaxURL = "addcomment.php";
                var data = {'content':$("#comment_area").val(), 'user':1, 'date':Date.now()}
                $.post(ajaxURL, data, function(res){});
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
    

    // $user_pop = document.getElementById("user_pop-up");
    // function openForm() {                                               //Fonction pour faire apparaitre le formulaire user_pop-up  
    //     document.getElementById("user_pop-up").style.display= "block";
    //     document.getElementById("user_icon").style.display= "none";

    // }
    // function closeForm() {                                              //Fonction pour faire disparaitre le formulaire user_pop-up
    //     $user_pop.style.display= "none";
    //     document.getElementById("user_icon").style.display= "block";
    // }









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
            // .catch((e) => window.alert("Directions request failed due to " + status));
        }
        document.getElementById("entrer").addEventListener("click",onChangeHandler);
// window.initMap = initMap;
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap'); /*Font Roboto*/
    body{
        font-family: 'Lucida Bright', sans-serif;
        background-color: #faf0dc;
        /* background-color: rgb(149, 138, 180); */
        /* background-image: url("fond_form.jpg"); */
        /* background-repeat: no-repeat;
        background-size: cover; */
        /* overflow: hidden; */
        
        /* overflow pour cacher la partie où y'a pas de background, bg-size pour la taille du bg iici recouvre tout l'écran  */
        
    }
    html, body{
        height: 100%;
        margin: 0 0 0 0;
        padding: 0 0 0 0;
    }

    nav{
        background-color: #f6e8b1;
        height: 50px;
        /* filter: brightness(50%); */
        margin: 0 0 0 0;
        padding: 10px 0 0 0;
        
    }

    #nav-bar {
        display: flex;
        left: 5%;
        list-style: none;
        margin: 0 0;
        box-sizing: border-box;
    }
    #nav-bar li{
        font-size: 16px;
        width: max-content;
        text-align: center;
        margin-left: 25px;
        float: left;
    }
    #nav-bar li a{
        text-decoration: none;
        color: inherit;
    }
    #nav-bar li:hover{
        color: black;        
        filter: brightness(90%);
    }

    #search-bar{
        
        display: block;
        margin-left: 40%;
        padding-left: 5px;
        border: thin;
        
        border-radius: 6px;
        border-color: grey;
        font-size: 16px;
        
        background-color: transparent;
        box-shadow: none;  
              
    }
    #search-bar:focus{
        color: black;
        border: thin;
    }
    
    #search-icon{
        font-size: 20px;
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
    }
    .list{
        float: left;
    }
    

    /* form[action='logout.php'] input{
        border: 3px solid black;
        margin-bottom: 1rem;
        padding: 8px 16px;
        border-radius: 0.5rem;
        color: black;
        
        width: 150px;
        float: right;
    }

    form[action='logout.php'] input:hover{
        filter: brightness(90%);
    } */

    #mess_log{
        text-align: center;
        font-size: larger;
        color: black;
        font-size: 25px;
    }

    /* #user_icon{
      font-variation-settings:
      'FILL' 200,
      'wght' 400,
      'GRAD' 0,
      'opsz' 48;
      border: none;
      color: black;
      float: right;   
      width: fit-content;  
      font-size: 40px; 
      background-color: inherit;
      
    } */
    /* #user_icon:hover{
        filter: brightness(90%);
    } */

    /* #user_pop-up{
        z-index: 2;
        
        position: absolute;
        top: 50px;
        right: 20px;
        width: 10rem;
        text-align: center;        
        border: solid 3px black;
        border-radius: 0.5rem;
        box-sizing: border-box;
        display: none;    
        background-color: white;
    } */
    /* #user_pop-up input{
        border-radius: 0.5rem;
        padding: 2% 4%;
        outline: none;
        margin-bottom: 4%;
    } */
    /* #user_pop-up input:hover{
        filter:brightness(90%);
    } */
    /* #user_pop-up input[type='submit']{
        background-color: red;
        color: white;

    } */
    #steps {
        width: 280px;
        height: 400px;
        position: absolute;
        right: 24px;
        top: 24px;
        background-color: #FFFFFF;
        border-radius: 8px;
        box-shadow: 0 0 16px #C0C0C0;
        padding: 10px;
        overflow: auto;
        }

    /* Sidenav menu */
    /* .sidenav {
        height: 100%;
        width: 250px;
        position: fixed;
        z-index: 2;
        top: 0;
        left: -250px;
        background-color: brown;
        padding-top: 60px;
        transition: left 0.5s ease;
    } */

    /* Sidenav menu links */
    /* .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: white;
        display: block;
        transition: 0.3s;
    } */

    /* .sidenav a:hover {
        color: #111;
    } */

    /* .sidenav ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    } */

    /* Active class */
    /* .sidenav.active {
        left: 0;
    } */

    /* Close btn */
    /* .sidenav .close {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
    } */
    /* #openBtn{
        width: fit-content;
    } */

    /* #icon_burger{
        font-variation-settings:
        'FILL' 200
        'wght' 400,
        'GRAD' 0,
        'opsz' 48;
        font-size: 40px;
        color: black;
        background-color: inherit;
    } */

    /* #map{
        float: left;
        left: 12%;
        z-index: 0;
        /* visibility: hidden; 
    }
        */
    
    #container {
  height: 100%;
  display: flex;
}

#sidebar {
  flex-basis: 15rem;
  flex-grow: 1;
  padding: 1rem;
  max-width: 30rem;
  height: 100%;
  box-sizing: border-box;
  overflow: auto;
}

#map {
  flex-basis: 0;
  flex-grow: 4;
  height: 70%;
  margin-left: 100px;
}

.commentaire{
    margin-left: 100px;
    z-index: 2;        
    
}
.itineraire{
    margin-left: 30px;
    text-align: center;
    display: flex;
    justify-content: center;
    
    /* flex-wrap: wrap; */
}
.itineraire input,button,select{
    border-radius: 0.5em;
    border: 1px solid black;
    padding-left: 12px;
    margin-right: 20px;

}

.itineraire #pac-container{
    width: fit-content;
    
}

#floating-panel {
  position: absolute;
  /* top: 10px; */
  left: 40%;
  z-index: 5;
  background-color: inherit;
  padding: 5px;
  border: 1px solid #999;
  border-radius: 6px;
  text-align: center;
  font-family: "Roboto", "sans-serif";
  line-height: 30px;
  padding-left: 10px;
}

#floating-panel #mode{
    background-color: inherit;
}

</style>

</html>