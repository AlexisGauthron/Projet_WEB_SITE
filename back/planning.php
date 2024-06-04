<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous</title>
	<link rel="stylesheet" href="style_back.css">
    <link rel="stylesheet" href="style_planning.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

	<script type="text/javascript">

		function jourconv (jourchiffre){
			let sortie = "numéro de jour incorrect";
			if (jourchiffre == 1){
				sortie = "Lundi";
			}
			if (jourchiffre == 2){
				sortie = "Mardi";
			}
			if (jourchiffre == 3){
				sortie = "Mercredi";
			}
			if (jourchiffre == 4){
				sortie = "Jeudi";
			}
			if (jourchiffre == 5){
				sortie = "Vendredi";
			}
			if (jourchiffre == 6){
				sortie = "Samedi";
			}
			if (jourchiffre == 7){
				sortie = "Dimanche";
			}
			return sortie;
		}	
	
		function semaine(ia){

			let jourmax=[0,31,29,31,30,31,30,31,31,30,31,30,31];

			let moischiffre =aujourdhui[5]+aujourdhui[6];
			let tailleoriginale = moischiffre.length;
			let jourdebut = aujourdhui[8]+aujourdhui[9];
			let taillejour = jourdebut.length;
			jourdebut -= jour-ia;
			//moischiffre =parseInt(moischiffre) +1;
			if (jourdebut <= 0){
				moischiffre = parseInt(moischiffre)- 1;
				if (moischiffre<1){
					moischiffre = 12;
				}
				jourdebut = jourdebut + jourmax[parseInt(moischiffre)];
			}
			else if (jourdebut>jourmax[parseInt(moischiffre)]){
				moischiffre= parseInt(moischiffre)+1;
				jourdebut = 1;
			}
			//alert(jourdebut+" "+parseInt(moischiffre));

			let moislettre = "pb chiffre";

			if (moischiffre == "01"){
				moislettre = "Janvier";
			}
			else if (moischiffre == "02"){
				moislettre = "Février";
			}
			else if (moischiffre == "03"){
				moislettre = "Mars";
			}
			else if (moischiffre == "04"){
				moislettre = "Avril";
			}
			else if (moischiffre == "05"){
				moislettre = "Mai";
			}
			else if (moischiffre == "06"){
				moislettre = "Juin";
			}
			else if (moischiffre == "07"){
				moislettre = "Juillet";
			}
			else if (moischiffre == "08"){
				moislettre = "Août";
			}
			else if (moischiffre == "09"){
				moislettre = "Septembre";
			}
			else if (moischiffre == "10"){
				moislettre = "Octobre";
			}
			else if (moischiffre == "11"){
				moislettre = "Novembre";
			}
			else if (moischiffre == "12"){
				moislettre = "Décembre";
			}

		
			let actuelle = " Lundi "+jourdebut +" "+moislettre ;

			moischiffre = String(moischiffre);
			ajoutzero = tailleoriginale - moischiffre.length;
			while (ajoutzero>0){
				moischiffre= '0'+moischiffre;
				ajoutzero--;
			}

			jourdebut = String(jourdebut);
			ajoutzero = taillejour - jourdebut.length;
			while (ajoutzero>0){
				jourdebut= '0'+jourdebut;
				ajoutzero--;
			}
			aujourdhui = aujourdhui[0]+aujourdhui[1]+aujourdhui[2]+aujourdhui[3]+aujourdhui[4]+moischiffre+aujourdhui[7]+jourdebut;
		
			return actuelle;
		}

		function planning (){
			let semainedoc = document.getElementById("semaine");
			let actuelle = "Semaine du ";
			actuelle = actuelle+ semaine(0);
			semainedoc.innerHTML = actuelle;
			if (jour != 0){
				jour = 0;
			}
			for (let i = 0;i<7;i++){
				let jourlettre = jourconv(i+1);
				let colonne = document.getElementById("colonne"+i);
				if (i==0) semaine(0);
				else semaine (1);
				let text =jourlettre;
				text+= " "+aujourdhui[8]+aujourdhui[9];
				let val ="";
				for (let j = 9;j<18;j++){
					
					for (let k = 0;k<60;k+=20){
						let passe = 0;
						var rajout ="";
						if (j==9){
							rajout = "0";
						}
						val = rajout+ j+":"+k;
						if (k==0){
							val = val+'0';
						}
						valseconde = val+":00";
						for (let l = 0; l<taille;l++){

							if (heuresFromPHP[l]==valseconde && datesFromPHP[l] == aujourdhui){
								text = text+' <input type="hidden" id ="'+val+'"class="case red" value ='+val+' >';
								text += '<button type="button" id ="'+val+'" class="case red">'+val+'</button>';

								passe = 1;
							}
							
						}
						if (passe==0){
							text += '<input type="button" id ="' + val + '" class="case green" value ="' + val + '" onclick="envoyerform(\'' + val + '\', \'' + aujourdhui + '\', \'' + valseconde + '\')">';
						}
					}

				}
				colonne.innerHTML =  text;
			}
		}
		
		document.addEventListener("DOMContentLoaded", function() {
			planning();
		});
		function envoyerform(id,dates,heure){
			var form = document.createElement('form');
				form.method = 'POST';
				form.action = 'rdv.php';
				
				var inputid = document.createElement('input');
				inputid.type = 'hidden';
				inputid.name = 'id';
				inputid.value = id;

				var inputdates = document.createElement('input');
				inputdates.type = 'hidden';
				inputdates.name = 'dates';
				inputdates.value = dates;

				var inputheure = document.createElement('input');
				inputheure.type = 'hidden';
				inputheure.name = 'heure';
				inputheure.value = heure;

				var inputcoach = document.createElement('input');
				inputcoach.type = 'hidden';
				inputcoach.name = 'id_coach';
				inputcoach.value = idcoach;

				
				form.appendChild(inputid);
				form.appendChild(inputdates);
				form.appendChild(inputheure);
				form.appendChild(inputcoach);

				document.body.appendChild(form);
				form.submit();
		}

		function prece (){
			jour =13;

			planning();
		}
		function suiv (){
			jour =-1;

			planning();
		}

	</script>
</head>
<body>
    <header class="planning">
        <nav class="navbar navbar-expand-md">
            <a class="navbar-brand" href="#">Sportify</a>
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main-navigation">
                <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../acceuil.html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#">A propos</a></li>
                </ul>
            </div>
        </nav>

        <div class="container_titre_plan"> 
            <h1><spam class ="auto-typing"></spam></h1> 
        </div>
	
		<div class ="sem">
			<div id = "semaine"></div>
			<button type="button" id ="prec" class="case red" onclick="prece()">Précédente</button>
			<button type="button" id ="suiv" class="case red" onclick="suiv()">Suivante</button>
		</div>
		<div id = "container">
			<div id = "gameGrid0" class = "style_colonne">
				<div id = "colonne0">
					<td></td>
				</div>
				<div id = "colonne1">
					<td></td>
				</div> 
				<div id = "colonne2">
					<td></td>
				</div>
				<div id = "colonne3">
					<td></td>
				</div>
				<div id = "colonne4">
					<td></td>
				</div>
				<div id = "colonne5">
					<td></td>			
				</div>
				<div id = "colonne6">
					<td></td>	
				</div>
			</div>
		</div>
		<div class="espace"></div>
 	<?php
 		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
 		$database = "Projet";
		$db_handle = mysqli_connect('localhost', 'root', 'root');
		$db_found = mysqli_select_db($db_handle, $database);
		$idcoach = isset($_POST["idcoach"])? $_POST["idcoach"] : "";
		$idcoach = intval($idcoach);
		if ($db_found) {
	        $sql = "SELECT Date,Heure FROM Coach,Consultation WHERE ID_Coach = $idcoach AND ID_Coach = IDcoach";
	        $result = mysqli_query($db_handle, $sql);
	        $nbresult = mysqli_num_rows($result);
			$dates =array();
			$heures = array();
			for ($i = 0;$i<$nbresult;$i++){
				$data = mysqli_fetch_assoc($result);
				$dates[$i] = $data['Date'];
				$heures[$i] = $data['Heure'];
			}
			$nbresult = json_encode($nbresult);
			$jsonDates = json_encode($dates);
	        $jsonHeures = json_encode($heures);
	        $aujourdhui = date("Y-m-d");   
	        $jsonaujourdhui = json_encode($aujourdhui);
	        $jour = date('w',strtotime($aujourdhui));
	        $jsonJour = json_encode ($jour);
	        $jsoncoach = json_encode($idcoach);
	    }
    	else {
        	$jsonData = json_encode("Database not found");
    	}


	?>
    </header>

	<script>
		var taille = <?php echo $nbresult;?>;
		var datesFromPHP = <?php echo $jsonDates; ?>;
		var heuresFromPHP = <?php echo $jsonHeures; ?>;
		var aujourdhui = <?php echo $jsonaujourdhui;?>;
		var jour = <?php echo $jsonJour;?>;
		if (jour == 0){
			jour = 7;
		}
		jour -=1;
		var idcoach =  <?php echo $jsoncoach;?>;
    </script>
	<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script>
        let typed = new Typed('.auto-typing', {
            strings: ['<i><b>Planning de votre Coach<b><i>'],
            typeSpeed: 150,
            backSpeed: 2000,
            onComplete: (self) => {
                document.querySelector('.typed-cursor').style.display = 'none';
            }
        });


    </script>
</body>
</html>















