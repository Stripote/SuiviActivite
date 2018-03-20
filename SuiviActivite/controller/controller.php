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
		//--------------------------------	
		case "insertNiveau":
			echo insertNiveau($_POST['libelle']);
			break;
		case "updateNiveau":
			echo updateNiveau($_POST['id'], $_POST['libelle']);
			break;
		case "deleteNiveau":
			echo supprimerNiveau($_POST['id']);
			break;
		//--------------------------------
		case "insertStatut":
			echo insertStatut($_POST['libelle']);
			break;
		case "updateStatut":
			echo updateStatut($_POST['id'], $_POST['libelle']);
			break;
		case "deleteStatut":
			echo supprimerStatut($_POST['id']);
			break;
		//--------------------------------
		case "insertMembre":
			echo insertMembre($_POST['libelle']);
			break;
		case "updateMembre":
			echo updateMembre($_POST['id'], $_POST['libelle']);
			break;
		case "deleteMembre":
			echo supprimerMembre($_POST['id']);
			break;
		//--------------------------------
		case "reload":
			reload($_POST['what']);
			break;
		default:
			break;
	}
}

function chargerNiveaux(){
	include("connectBdd.php");
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
	include("connectBdd.php");
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
	include("connectBdd.php");
	$query = "SELECT * FROM type_realisations WHERE supprime = 0";
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

function reload($what){
	include("connectBdd.php");
	$query = "";
	$query2 = "";
	switch($what){
		case "types":
			$query = "SELECT * FROM type_realisations WHERE supprime = 0";
			break;
		case "niveaux":
			$query = "SELECT * FROM niveau_realisations WHERE supprime = 0";
			break;
		case "statuts":
			$query = "SELECT * FROM statut_realisations WHERE supprime = 0";
			break;
		case "membre":
			$query = "SELECT * FROM membres WHERE role = 'user' AND supprime = 0 ORDER BY Libelle";
			break;
	}
	
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		while($row = $stmt->fetch()){
			echo'<tr><td value="'.$row['N'].'">'.$row['Libelle'].'</td></tr>';
		}
	}else{
		echo'<option>Erreur lors du chargement des types</option>';
	}
}


function chargerMembres($typeGet=null){
	include("controller/connectBdd.php");
	if(isset($typeGet))
		$query = "SELECT * FROM membres WHERE role <> 'admin' and supprime = 0 ORDER BY Libelle";
	else
		$query = "SELECT * FROM membres WHERE role = 'admin' and supprime = 0";
	$stmt = $bdd->prepare($query);
	if($stmt->execute()){
		while($row = $stmt->fetch()){
			if(isset($typeGet))
				echo'<tr><td value="'.$row['N'].'">'.$row['Libelle'].'</td></tr>';
			else
				echo'<option value="'.$row['N'].'">'.$row["Libelle"].'</option>';
		}
	}else{
		echo'<option>Erreur lors du chargement des types</option>';
	}
}

/*sans param : tous les auteurs, avec param : auteurs ayant 1 réalisation au moins */
function chargerAuteurs($typeGet=null){
	include("connectBdd.php");
	if(isset($typeGet))
		$query = "SELECT DISTINCT N, Auteur as Libelle FROM realisations";
	else
		$query = "SELECT * FROM membres WHERE role = 'user' AND supprime = 0 ORDER BY Libelle";
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

/*CRUD TYPE*/
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

/*CRUD NIVEAU*/
function supprimerNiveau($id){
	include("connectBdd.php");
	$query = "UPDATE niveau_realisations SET supprime = 1 WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	if($stmt->execute()){
		echo "<a class='text-success'>Niveau supprimé.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}
function updateNiveau($id, $libelle){
	include("connectBdd.php");
	$query = "UPDATE niveau_realisations SET libelle = :libelle WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	$stmt->bindValue(":libelle", $libelle);
	if($stmt->execute()){
		echo "<a class='text-success'>Niveau modifié.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}
function insertNiveau($libelle){
	include("connectBdd.php");
	$query = "INSERT INTO niveau_realisations(libelle) VALUES(:libelle)";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":libelle", $libelle);
	if($stmt->execute()){
		echo "<a class='text-success'>Niveau ajouté.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}

/*CRUD STATUT*/
function supprimerStatut($id){
	include("connectBdd.php");
	$query = "UPDATE statut_realisations SET supprime = 1 WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	if($stmt->execute()){
		echo "<a class='text-success'>Statut supprimé.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}
function updateStatut($id, $libelle){
	include("connectBdd.php");
	$query = "UPDATE statut_realisations SET libelle = :libelle WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	$stmt->bindValue(":libelle", $libelle);
	if($stmt->execute()){
		echo "<a class='text-success'>Statut modifié.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}
function insertStatut($libelle){
	include("connectBdd.php");
	$query = "INSERT INTO statut_realisations(libelle) VALUES(:libelle)";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":libelle", $libelle);
	if($stmt->execute()){
		echo "<a class='text-success'>Statut ajouté.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}

/*CRUD MEMBRE*/

function supprimerMembre($id){
	include("connectBdd.php");
	$query = "UPDATE membres SET supprime = 1 WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	if($stmt->execute()){
		echo "<a class='text-success'>Statut supprimé.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}
function updateMembre($id, $libelle){
	include("connectBdd.php");
	$query = "UPDATE membres SET Libelle = :libelle WHERE N = :id";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":id", $id);
	$stmt->bindValue(":libelle", $libelle);
	if($stmt->execute()){
		echo "<a class='text-success'>Statut modifié.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}
function insertMembre($libelle){
	include("connectBdd.php");
	$query = "INSERT INTO membres(Libelle) VALUES(:libelle)";
	$stmt = $bdd->prepare($query);
	$stmt->bindValue(":libelle", $libelle);
	if($stmt->execute()){
		echo "<a class='text-success'>Statut ajouté.</a>";
	}else{
		echo"<a class='text-danger'>Une erreur est survenue.</a>";
	}
}

?>