<?php

if(isset($_POST['get'])){
	$type = $_POST['get'];
	switch($type){
		case "deleteType":
			echo supprimerType($_POST['id']);
			break;
		case "updateType":
			echo updateType($_POST['id'], $_POST['libelle']);
			break;
		case "insertType":
			echo insertType($_POST['libelle']);
			break;
		default:
			break;
	}
}

function chargerNiveaux(){
	include("controller/connectBdd.php");
	$query = "SELECT * FROM niveau_realisations";
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		while($row = $stmt->fetch()){
			echo'<option value="'.$row['N'].'">'.$row["Libelle"].'</option>';
		}
	}else{
		echo'<option>Erreur lors du chargement des niveaux</option>';
	}
}

/* sans param : charger pour tableau réalisations || avec param : charger pour select de tri */
function chargerStatuts($typeChargement = null){
	include("controller/connectBdd.php");
	if(isset($typeChargement)){
		$query = "SELECT * FROM statut_realisations";
		$stmt = $bdd->prepare($query);
		if($stmt->execute()){
			while($row = $stmt->fetch()){
				echo'<option name="critereValue" value="'.$row['N'].'">'.$row["Libelle"].'</option>';
			}
		}else{
			echo'<option>Erreur lors du chargement des statuts</option>';
		}
	}else{
		$query = "SELECT * FROM statut_realisations";
		$stmt = $bdd->prepare($query);
		if($stmt->execute()){
			while($row = $stmt->fetch()){
				echo'<option value="'.$row['N'].'">'.$row["Libelle"].'</option>';
			}
		}else{
			echo'<option>Erreur lors du chargement des statuts</option>';
		}
	}
}

function chargerTypes($forTable = null){
	include("controller/connectBdd.php");
	$query = "SELECT * FROM type_realisations";
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		while($row = $stmt->fetch()){
			if(!isset($forTable))
				echo'<option value="'.$row['N'].'">'.$row["Libelle"].'</option>';
			else
				echo'<tr><td value="'.$row['N'].'">'.$row['Libelle'].'</td></tr>';
		}
	}else{
		echo'<option>Erreur lors du chargement des types</option>';
	}
}


function chargerMembres(){
	include("controller/connectBdd.php");
	$query = "SELECT * FROM membres WHERE role = 'admin'";
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		while($row = $stmt->fetch()){
			echo'<option value="'.$row['N'].'">'.$row["Libelle"].'</option>';
		}
	}else{
		echo'<option>Erreur lors du chargement des types</option>';
	}
}

/*sans param : tous les auteurs, avec param : auteurs ayant 1 réalisation au moins */
function chargerAuteurs($typeGet){
	include("controller/connectBdd.php");
	if(isset($typeGet))
		$query = "SELECT DISTINCT Auteur as Libelle FROM realisations";
	else
		$query = "SELECT * FROM membres WHERE role = 'user' ORDER BY Libelle";
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		if(isset($typeGet)){
			while($row = $stmt->fetch()){
				echo'<option value="'.$row['N'].'">'.$row["Libelle"].'</option>';
			}
		}else{
			while($row = $stmt->fetch()){
				echo'<option>'.$row["Libelle"].'</option>';
			}
		}
		
	}else{
		echo'<option>Erreur lors du chargement des types</option>';
	}
}

function supprimerType($id){
	include("connectBdd.php");
	$query = "UPDATE type_realisations SET supprime = 1 WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	if($stmt->execute()){
		echo "<a class='text-success'>Type supprimé.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}
function updateType($id, $libelle){
	include("connectBdd.php");
	$query = "UPDATE type_realisations SET libelle = :libelle WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	$stmt->bindValue(":libelle", $libelle);
	if($stmt->execute()){
		echo "<a class='text-success'>Type modifié.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}
function insertType($libelle){
	include("connectBdd.php");
	$query = "INSERT INTO type_realisations(libelle) VALUES(:libelle)";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":libelle", $libelle);
	if($stmt->execute()){
		echo "<a class='text-success'>Type ajouté.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}


?>