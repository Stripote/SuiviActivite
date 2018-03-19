<?php
// Sous WAMP (Windows)
if(isset($_POST['get']) ){
	switch($_POST['get']){
		case 1:
			getAll();
			break;
		case 2: /*by date*/
			getAllSorted(htmlentities($_POST['by']), htmlentities($_POST['val']));
			break;
		case 3: /*by critere : auteur, membre, ...*/
			getByCriteria(htmlentities($_POST['by']), htmlentities($_POST['val']));
			break;
		case 4: /*by critere : auteur, membre, ...*/
			getOne( htmlentities($_POST['val']));
			break;
		case 5 :/*delete by id*/
			deleteOne( htmlentities($_POST['val']));
			break;
		case 6 :/*get all not over*/
			getAll(1);
			break;
		default:/*error*/
			echo'<option class="text-danger">Erreur lors du chargement des réalisations.</option>';
			break;
	}
}

/*avec param, réalisations "restantes", sans param, toutes les réalisations non supprimées*/
function getAll($type=null){
	include("connectBdd.php");
	if(!isset($type)){
		$query = "SELECT realisations.N, Auteur, DateTraitement, statut_realisations.Libelle Statut, type_realisations.Libelle Type, DateReception, membres.Libelle Membre, Niveau, niveau_realisations.Libelle LibelleNiveau, Description, Commentaire, Site, Activite "
				. "FROM realisations "
				. "JOIN type_realisations ON realisations.Type=type_realisations.N "
				. "JOIN statut_realisations ON realisations.Statut=statut_realisations.N "
				. "JOIN niveau_realisations ON realisations.Niveau=niveau_realisations.N "
				. "JOIN membres ON membres.N=realisations.RealisePar WHERE realisations.deleted = 0 ";
		$stmt = $bdd->prepare($query);
		if($stmt->execute()){
			echo json_encode($stmt->fetchAll());
		}else{
			echo'<option class="text-danger">Erreur lors du chargement des réalisations.</option>';
		}
	}else{
		$query = "SELECT realisations.N, Auteur, DateTraitement, statut_realisations.Libelle Statut, type_realisations.Libelle Type, DateReception, membres.Libelle Membre, Niveau, niveau_realisations.Libelle LibelleNiveau, Description, Commentaire, Site, Activite "
				. "FROM realisations "
				. "JOIN type_realisations ON realisations.Type=type_realisations.N "
				. "JOIN statut_realisations ON realisations.Statut=statut_realisations.N "
				. "JOIN niveau_realisations ON realisations.Niveau=niveau_realisations.N "
				. "JOIN membres ON membres.N=realisations.RealisePar WHERE realisations.deleted = 0 AND realisations.Statut NOT IN (5,6)";
		$stmt = $bdd->prepare($query);
		if($stmt->execute()){
			echo json_encode($stmt->fetchAll());
		}else{
			echo'<option class="text-danger">Erreur lors du chargement des réalisations.</option>';
		}
	}
}

function getAllSorted($critere, $valeur){
	include("connectBdd.php");
	$query = "SELECT realisations.N, Auteur, DateTraitement, statut_realisations.Libelle Statut, type_realisations.Libelle Type, DateReception, membres.Libelle Membre, Niveau, Description, Commentaire, Site, Activite "
			. "FROM realisations "
			. "JOIN type_realisations ON realisations.Type=type_realisations.N "
			. "JOIN statut_realisations ON realisations.Statut=statut_realisations.N "
			. "JOIN membres ON membres.N=realisations.RealisePar WHERE realisations.deleted = 0";
	
	if($critere == "dateReception"){
		$query = $query." ORDER BY DateReception";
	}else{
		$query = $query." ORDER BY DateTraitement";}
	
	if($valeur == "DESC"){
		$query = $query." DESC";
	}else{
		$query = $query." ASC";}
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option class="text-danger">Erreur lors du chargement des réalisations.</option>';
	}
}

function getByCriteria($critere, $valeur){
	include("connectBdd.php");
	$query = "SELECT realisations.N, Auteur, DateTraitement, statut_realisations.Libelle Statut, type_realisations.Libelle Type, DateReception, membres.Libelle Membre, Niveau, Description, Commentaire, Site, Activite "
			. "FROM realisations "
			. "JOIN type_realisations ON realisations.Type=type_realisations.N "
			. "JOIN statut_realisations ON realisations.Statut=statut_realisations.N "
			. "JOIN membres ON realisations.RealisePar = membres.N "
			. "WHERE realisations.deleted = 0 AND ";
	
	switch($critere){
		case "auteur":
			$query = $query." Auteur = ";
			break;
		case "membre":
			$query = $query." RealisePar = ";
			break;
		case "statut":
			$query = $query." statut_realisations.N = ";
			break;
	}
	$query = $query." :value";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":value", $valeur);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option class="text-danger">Erreur lors du chargement des réalisations.</option>';
	}
}

function getOne($id){
	include("connectBdd.php");
	$query = "SELECT realisations.N, Auteur, DateTraitement, Statut, Type, Niveau, DateReception, membres.Libelle Membre, Commentaire, Niveau, Description, Commentaire, Site, Activite "
			. "FROM realisations "
			. "JOIN membres ON realisations.RealisePar = membres.N "
			. "WHERE realisations.N = :id AND realisations.deleted = 0";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option>Erreur lors du chargement de la réalisation</option>';
	}
}
function decode($text){
	return html_entity_decode($text);
}

function deleteOne($id){
	include("connectBdd.php");
	$query = "UPDATE realisations SET deleted = 1 WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	if($stmt->execute()){
		echo json_encode($stmt->fetchAll());
	}else{
		echo'<option>Erreur lors de la suppression de la réalisation.</option>';
	}
}
	
	
?>