<?php
// Sous WAMP (Windows)
	include("connectBdd.php");
	session_start();
	/*Un formulaire d'envoi de réalisation à été soumis*/
	if(isset($_POST)){
		$auteur = htmlentities($_POST['Auteur']);
		$dateReception = htmlentities($_POST['DateReception']);
		$dateTraitement = htmlentities($_POST['DateTraitement']);
		$type = $_POST['Type'];
		$niveau = $_POST['Niveau'];
		$statut = $_POST['Statut'];
		$commentaire = $_POST['Commentaire'];
		$activite =  htmlentities($_POST['Activite']);
		$site =  htmlentities($_POST['Site']);
		$description =  $_POST['Description'];
		
		$query = "INSERT INTO realisations(Auteur, DateReception, DateTraitement, Statut, Niveau, Type, Commentaire, RealisePar, Site, Activite, Description) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$query2 = "INSERT INTO realisations(Auteur, DateReception, DateTraitement, Statut, Niveau, Type, Commentaire) VALUES(".$auteur.", ".$dateReception.", ".$dateTraitement.", ".$statut.", ".$niveau.", ".$type.", ".$commentaire.")";
		$stmt = $bdd->prepare($query);
		$stmt->bindValue(1, $auteur);
		$stmt->bindValue(2, $dateReception);
		$stmt->bindValue(3, $dateTraitement);
		$stmt->bindValue(4, $statut);
		$stmt->bindValue(5, $niveau);
		$stmt->bindValue(6, $type);
		$stmt->bindValue(7, $commentaire);
		$stmt->bindValue(8, $_SESSION['connectedId']);
		$stmt->bindValue(9, $site);
		$stmt->bindValue(10, $activite);
		$stmt->bindValue(11, $description);
		
		if($stmt->execute()){
			echo'<div class="alert alert-success" role="alert">'
					.'Nouvelle réalisation ajoutée.'
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