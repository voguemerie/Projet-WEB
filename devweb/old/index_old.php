<?php 

session_start();
$_SESSION["log"] ??= false;

if(!$_SESSION["log"]){
    header('Location:login.php');  //redirection sur le login lorsque l'on arrive sur la page
    exit;
}
// $json = file_get_contents("Musées.json");
// $json_a = json_decode($json, true);
            
//  foreach($json_a as $jsonDataKey => $jsonDataValue){
//     foreach($jsonDataValue as $jsonArrayKey => $jsonArrayValue){
//                 // print_r($jsonArrayValue['entities']);
//                 $entities=$jsonArrayValue['entities'];
//                 //  print_r($entities[0]["fieldGeolocation"]["lat"]);

//         }
//           }

// for( $i = 0 ; $i < count($entities) ; $i++ ) {
//     $nom = $entities[$i]["entityLabel"];
//     echo $nom."\n";
//     $lat = $entities[$i]["fieldGeolocation"]["lat"];
//     echo $lat."\n";
//     $lng = $entities[$i]["fieldGeolocation"]["lng"];
//     echo $lng."\n";

//     echo "<table border='1' width='400' align='center'>";
//             echo "<tr>";
//                 echo "<td width='200'><b>Votre nom est : </b></td>";
//                 echo "<td width='200'><b>".$nom."</b></td>";
//             echo "</tr>";
//             echo "<tr>";
//                 echo "<td width='200'><b>Votre prénom est : </b></td>";
//                 echo "<td width='200'><b>".$lat."</b></td>";
//             echo "</tr>";echo "<tr>";
//                 echo "<td width='200'><b>Votre âge est : </b></td>";
//                 echo "<td width='200'><b>".$lng."</b></td>";
//             echo "</tr>";
//         echo "</table>";
//}


                        
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script type=text/javascript src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <!-- icone utilisateur--> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
<button id= "user_icon" class="material-symbols-outlined" onclick="openForm()">account_circle</button>
    <form id="user_pop-up" action="logout.php">
        <p>$identifiant</p> <!--Afficheer l'identifiant-->                                 <!--Metre au début du body-->        
        <input type="submit" value="se déconnecter"><!-- se déconnecte via logout-->
        <input type="button" onclick="closeForm()" value="Fermer"> <!-- Ferme le pop-up-->
    </form>
    <p name="mess_log" id="mess_log">Bonjour, <?php.$_GET["login"],?> vous êtes connecté</p>
    <div id="map" style="width: 500px; height: 400px;"></div>
    
    
</body>

<script>

	const map = L.map('map').setView([48.866667, 2.333333],12);

	const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

	var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
    }


    $user_pop = document.getElementById("user_pop-up");
    function openForm() {                                               //Fonction pour faire apparaitre le formulaire user_pop-up  
        $user_pop.style.display= "block";
        document.getElementById("user_icon").style.display= "none";

    }
    function closeForm() {                                              //Fonction pour faire disparaitre le formulaire user_pop-up
        $user_pop.style.display= "none";
        document.getElementById("user_icon").style.display= "block";
    }

    var Icon = L.icon({ iconUrl: 'icone.png',
    iconSize:     [20, 25], // size of the icon
    iconAnchor:   [0, 0], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, 0] // point from which the popup should open relative to the iconAnchor
    })
    $.ajax({
        method: 'GET',
        url: "https://data.culture.gouv.fr/api/records/1.0/search/?dataset=liste-et-localisation-des-musees-de-france&q=&rows=131&facet=region_administrative&facet=departement&refine.region_administrative=%C3%8Ele-de-France&refine.departement=Paris",
        success : function(data){
            JSON.stringify(data)
            var lat,lon;
            //pas de co donc tester à la maison
            for (let i = 0; i < data['records'].length; i++) {
                console.log(data.nhits);
                lat=data['records'][i]['fields']['geolocalisation'][0];
                lon=data['records'][i]['fields']['geolocalisation'][1];
                console.log(lat,lon);
                var url=data['records'][i]['fields']['url'];
                var S ="site officiel";
                console.log(url)
                L.marker([lat,lon],{icon: Icon}).addTo(map).bindPopup('<b>' + data['records'][i]['fields']["nom_officiel_du_musee"]+'<br>' + S.link(data['records'][i]['fields']['url'])).openPopup();
            }
        }
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap'); /*Font Roboto*/
    body{
        font-family: 'Roboto', sans-serif;
        background-image: url("gradienta-G084bO4wGDA-unsplash.jpg");
    }

    form[action='logout.php']{
        
    }
    form[action='logout.php'] input{
        border: 3px solid black;
        margin-bottom: 1rem;
        padding: 8px 16px;
        border-radius: 0.5rem;
        color: black;
        
        width: 150px;
        float: right;
        

        /* position: absolute;
        left: 95rem; */
    }
    form[action='logout.php'] input:hover{
        filter: brightness(90%);
    }

    #mess_log{
        text-align: center;
        font-size: larger;
        color: grey;
        /* position absolute; */
        /* top: 2rem;
        left:50%; */

    }

    #user_icon{
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
      
    }
    #user_icon:hover{
        filter: brightness(90%);
    }

    #user_pop-up{
        position: absolute;
        top: 50px;
        right: 20px;
        width: 10rem;
        text-align: center;        
        border: solid 3px black;
        border-radius: 0.5rem;
        box-sizing: border-box;
        display: none;    
    }
    #user_pop-up input{
        border-radius: 0.5rem;
        padding: 2% 4%;
        outline: none;
        margin-bottom: 4%;
    }
    #user_pop-up input:hover{
        filter:brightness(90%);
    }
    #user_pop-up input[type='submit']{
        background-color: red;
        color: white;

    }
    /* #mess_log{
        font-size: large;
        color: grey;

        transition-duration: 7s;
        transition-delay: infinite;
        
        transform: translateX(0);
        transform: translateX(20%);
        transform: translateX(40%);
        transform: translateX(60%);
        transform: translateX(80%);
        transform: translateX(100%);
    } */
    
</style>

</html>
