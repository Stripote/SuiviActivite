<?php
// Sous WAMP (Windows)
	include("connectBdd.php");
	/*Un formulaire d'envoi de réalisation à été soumis*/
	session_start();
	if(isset($_POST)){
		$dateReception = htmlentities($_POST['DateReception']);
		$dateTraitement = htmlentities($_POST['DateTraitement']);
		$type = $_POST['Type'];
		$niveau = $_POST['Niveau'];
		$statut = $_POST['Statut'];
		//$commentaire = $_POST['Commentaire'];
		$commentaire = $_POST['Commentaire'];
		$id =  $_POST['idReal'];
		$activite =  htmlentities($_POST['Activite']);
		$site =  htmlentities($_POST['Site']);
		$description =  $_POST['Description'];
		
		$query = "UPDATE realisations SET DateReception = ?, DateTraitement = ?, Statut = ?, Niveau = ?, Type = ?, Commentaire = ?, RealisePar = ? , Activite = ?, Site = ?, Description = ? WHERE N = ?";
		$query2 = "UPDATE realisations SET DateReception = '".$dateReception."', DateTraitement = '".$dateTraitement."', Statut = ".$statut.", Niveau = ".$niveau.", Type = ".$type.", Commentaire = '".$commentaire."' WHERE N =".$id;
		$stmt = $bdd->prepare($query);
		$stmt->bindValue(1, $dateReception);
		$stmt->bindValue(2, $dateTraitement);
		$stmt->bindValue(3, $statut);
		$stmt->bindValue(4, $niveau);
		$stmt->bindValue(5, $type);
		$stmt->bindValue(6, $commentaire);
		$stmt->bindValue(7, $_SESSION['connectedId']);
		$stmt->bindValue(8, $activite);
		$stmt->bindValue(9, $site);
		$stmt->bindValue(10, $description);
		$stmt->bindValue(11, $id);
		
		if($stmt->execute()){
			echo'<div class="alert alert-warning" role="alert">'
					.'Modification réussie.'
				.'</div>';
		}else{
			echo '<div class="alert alert-danger" role="alert">'
				.'Échec lors de l\'ajout de la nouvelle réalisation. -> '.$query2
			.'</div>';
		}
	}else{
		echo '<div class="alert alert-danger" role="alert">'
				.'Échec lors de l\'ajout de la nouvelle réalisation.'
			.'</div>';
	}
?>