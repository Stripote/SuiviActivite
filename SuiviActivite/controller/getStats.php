<?php
// Sous WAMP (Windows)
if(isset($_POST['get']) ){
	switch($_POST['get']){
		case 1: //GLOBAL ALL
			getAll();
			break;
		case 2: //GLOBAL BY TYPE
			getAllByType();
			break;
		case 3://GLOBAL BY LEVEL
			getAllByLevel();
			break;
		case 4://PERSONNAL ALL 
			getAllPersonnel( htmlentities($_POST['member']));
			break;
		case 5 ://PERSONNAL BY TYPE
			getAllPersonnalByType( htmlentities($_POST['member']));
			break;
		case 6 ://PERSONNAL BY LEVEL
			getAllPersonnalByLevel( htmlentities($_POST['member']));
			break;
		default:/*error*/
			echo'<option class="text-danger">Erreur lors du chargement des réalisations. -SWITCH</option>';
			break;
	}
}

/*GLOBAL*/
function getAll(){
	include("connectBdd.php");
	$query = "SELECT COUNT(realisations.N) Nombre,  CONCAT( MONTHNAME(DateReception), ' ', YEAR(DateReception)) Mois "
			. "FROM realisations "
			. "GROUP BY CONCAT( MONTHNAME(DateReception), ' ', YEAR(DateReception))";
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option class="text-danger">Erreur lors du chargement des réalisations. -GETALL</option>';
	}	
}

function getAllByType(){
	include("connectBdd.php");
	$query = "SELECT COUNT(realisations.N) Nombre,  type_realisations.Libelle "
			. "FROM realisations "
			. "JOIN type_realisations ON realisations.Type=type_realisations.N "
			. "GROUP BY type_realisations.Libelle";
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option class="text-danger">Erreur lors du chargement des réalisations. -GETALLBYTYPE</option>';
	}	
}

function getAllByLevel(){
	include("connectBdd.php");
	$query = "SELECT COUNT(realisations.N) Nombre,  niveau_realisations.Libelle "
			. "FROM realisations "
			. "JOIN niveau_realisations ON realisations.Niveau=niveau_realisations.N "
			. "GROUP BY niveau_realisations.Libelle";
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option class="text-danger">Erreur lors du chargement des réalisations. -GETALLBYLEVEL</option>';
	}	
}

/*PERSONNAL*/

function getAllPersonnel($valeur){
	include("connectBdd.php");
	$query = "SELECT COUNT(realisations.N) Nombre,  CONCAT( MONTHNAME(DateReception), ' ', YEAR(DateReception)) Mois "
			. "FROM realisations "
			. "JOIN membres ON realisations.RealisePar=membres.N "
			. "WHERE membres.Libelle = :nom "
			. "GROUP BY CONCAT( MONTHNAME(DateReception), ' ', YEAR(DateReception))";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":nom", $valeur);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option class="text-danger">Erreur lors du chargement des réalisations. --GETALLPERSONNAL</option>';
	}	
}

function getAllPersonnalByType($valeur){
	include("connectBdd.php");

	$query = "SELECT COUNT(realisations.N) Nombre,  type_realisations.Libelle "
			. "FROM realisations "
			. "JOIN type_realisations ON realisations.Type=type_realisations.N "
			. "JOIN membres ON realisations.RealisePar=membres.N "
			. "WHERE membres.Libelle = :nom "
			. "GROUP BY type_realisations.Libelle";	
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":nom", $valeur);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option class="text-danger">Erreur lors du chargement des réalisations. -GETALLPERSONNALBYTYPE</option>';
	}	
}

function getAllPersonnalByLevel($valeur){
	include("connectBdd.php");			
	$query = "SELECT COUNT(realisations.N) Nombre,  niveau_realisations.Libelle "
			. "FROM realisations "
			. "JOIN niveau_realisations ON realisations.Niveau=niveau_realisations.N "
			. "JOIN membres ON realisations.RealisePar=membres.N "
			. "WHERE membres.Libelle = :nom "			
			. "GROUP BY niveau_realisations.Libelle";		
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":nom", $valeur);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option class="text-danger">Erreur lors du chargement des réalisations. -GETALLPERSONNALBYLEVEL</option>';
	}	
}
	
	
?>