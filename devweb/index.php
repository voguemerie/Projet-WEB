<?php 

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
    <title>Document</title>
    <script src="index_burger.js"></script>
    
     <script
    src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous"></script>
    <!-- icone burger --> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

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

    <!-- Menu Burger -->
    <div id="mySidenav" class="sidenav">
        <a id="closeBtn" href="#" class="close">×</a>
        <ul>
          <li><a href="#">Accès commentaires</a></li>
          <li><a href="logout.php">Déconnexion</a></li> 
          <li><a href="musees.php">Les musées</a></li>
          <li><a href="#">Nous contacter</a></li>
          
        </ul>
      </div>
      
      <a href="#" id="openBtn">        
        <span id="icon_burger" class="material-symbols-outlined">menu</span>        
      </a>
      
    </div> 
    <p name="mess_log" id="mess_log">Bonjour, <!--<?php $_GET["login"] ?> --> vous êtes connecté</p>


   

    <div id="map" style= "width:100%; height:100%; z-index: 1;"></div>


    <?php 
        
        // foreach($pdo->query($sql)  as $row){ // requête sql
        //     echo "<div class='comment'>".$row['content']." </div>";
        // }
        
    ?>
    <textarea name="comment_area" id="comment_area" cols="30" rows="10" placeholder="taper votre commentaire ici"></textarea>
    <button id="post_comment">commenter</button>
    
    
</body>

<script>
    $(document).ready(function(){
            $("#post_comment").click(function(){
                var ajaxURL = "addcomment.php";
                var data = {'content':$("#comment_area").val(), 'user':1, 'date':Date.now()}
                $.post(ajaxURL, data, function(res){});
            });
        });

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


    $user_pop = document.getElementById("user_pop-up");
    function openForm() {                                               //Fonction pour faire apparaitre le formulaire user_pop-up  
        document.getElementById("user_pop-up").style.display= "block";
        document.getElementById("user_icon").style.display= "none";

    }
    function closeForm() {                                              //Fonction pour faire disparaitre le formulaire user_pop-up
        $user_pop.style.display= "none";
        document.getElementById("user_icon").style.display= "block";
    }

    
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap'); /*Font Roboto*/
    body{
        font-family: 'Roboto', sans-serif;
        background-color: rgb(149, 138, 180);
        
    }
    html, body{
        height: 100%;
    }

    form[action='logout.php'] input{
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
    }

    #mess_log{
        text-align: center;
        font-size: larger;
        color: white;
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

        /* Sidenav menu */
.sidenav {
  height: 100%;
  width: 250px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: -250px;
  background-color: brown;
  padding-top: 60px;
  transition: left 0.5s ease;
}

/* Sidenav menu links */
.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: white;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #111;
}

.sidenav ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

/* Active class */
.sidenav.active {
  left: 0;
}

/* Close btn */
.sidenav .close {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
}
#openBtn{
  width: fit-content;
}

#icon_burger{
  font-variation-settings:
  'FILL' 200,
  'wght' 400,
  'GRAD' 0,
  'opsz' 48;
  font-size: 40px;
  color: black;
  background-color: inherit;
}


</style>

</html>