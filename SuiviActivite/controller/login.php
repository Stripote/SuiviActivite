<?php
// Sous WAMP (Windows)
	include("connectBdd.php");
	session_start();
	if(isset($_POST) ){
		if(isset($_POST['getConnected'])){
			$array = array(
				"login" => $_SESSION['connectedLogin'],
				"password" => $_SESSION['connectedPass'],
			);
			echo JSON_encode($array);
		}
		elseif(isset($_POST['check'])){
			if(isset($_SESSION['connectedId']))
				echo "true";
			else
				echo "false";
		}
		elseif(isset($_POST['logout'])){
			session_destroy();
			echo '<span href="#" title="Se connecter" class="loginBtn navBtn fa fa-sign-in" data-toggle="modal" data-target="#login-modal"></span>';
		}
		elseif(isset($_POST['login']) && isset($_POST['password'])){
			/*Récupération des variables passées via le formuaire de connexion + antiXSS*/
			$sel = "SuiViActiviteServiceSupport";
			$login = htmlspecialchars($_POST['login'], ENT_QUOTES, 'UTF-8');
			$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
			
			/*Préparation de la requête permettant de récupérer les informations récupérées grace au login*/
			$query = "SELECT * FROM membres WHERE login = :login";
			$stmt = $bdd->prepare($query);
			$stmt->bindValue(":login", $login);
			$connected = false;
			$knownasmember = false;
			$error = "";
			/*Parcour des résultats*/
			if($stmt->execute()){
				while($row = $stmt->fetch()){
					/*Test vérifiant si le password renseigné dans le formulaire correspond à celui en BDD*/
					if(password_verify($password, $row['password']) || hash_equals($password, $row['password'])){
						/*Si connexion réussi, passage de l'ID de la personne connectée en session*/
						$_SESSION['connectedId'] = $row['N'];
						$_SESSION['connectedName'] = $row['Libelle'];
						$_SESSION['connectedPass'] = $row['password'];
						$_SESSION['connectedLogin'] = $row['login'];
						echo "<a class='text-success'>Connexion réussie</a>";
						$connected = true;
					}
					$knownasmember = true;
				}
				/*Détermination de l'erreur*/
				if(!$knownasmember){
					$error = "<a class='text-danger'>Login inconnu.</a>";
				}
				elseif(!$connected){
					$error = "<a class='text-danger'>Mot de passe incorrect.</a>";
				}
				/*Affichage de l'erreur*/
				if($knownasmember || !$connected){
					echo $error;
				}
			}else{
				echo '<a class="text-danger">La requête de connexion n\'a pas pu aboutir.</a>';
			}
			return 0;
		}else{
		if(isset($_SESSION['connectedName']))
			echo $_SESSION['connectedName'];
		}
	}else{
		echo 'NO DATA PASSED';
	}
?>