<?php
	if(!isset($_SESSION))
		session_start();
	
	if(isset($_POST) && isset($_POST['action'])){
		$action = $_POST['action'];
		switch($action){
				case "checkCode":
					checkCode($_POST['login'], $_POST['code']);
					break;
				case "sendEmail":
					sendEmail($_POST['login']);
					break;
		}		
	}
	else{
			echo '<a class="text-danger">Erreur lors de l\'envoi du code. [Pas de données]"</a>';
	}

	function checkCode($login, $code){
		include("connectBdd.php");
		 $codeCorrect = false;
		 $sendDt = new Date();
		 $query = "SELECT * FROM codes WHERE login = :login";
		 $stmt = $bdd->prepare($query);
		$stmt->bindValue(":login", $login);
		if($stmt->execute()){
			while($row = $stmt->fetch()){
				if($row['code'] == $code && $sendDt >= $row['dateCreation']){
					$codeCorrect = true;
				}	
			}
		}
		if($codeCorrect)
			echo 'success';
		else
			echo 'failure';
	}
	
	function sendEmail($login){
		include("connectBdd.php");
		$createDt = new DateTime("now");;
		$query = "SELECT * FROM membres WHERE login = :login";
		$stmt = $bdd->prepare($query);
		
		$stmt->bindValue(":login", $login);
		if($stmt->execute()){
			while($row = $stmt->fetch()){
				$email = $row['N']; //$row['email'];
			}
		}
		$code = substr(md5(openssl_random_pseudo_bytes($_SESSION['connectedId'])), 5, 5);
		
		
		if(isset($email)){
			 // Plusieurs destinataires
			 $to  = 'matclemp@hotmail.fr'; // notez la virgule
			 // Sujet
			 $subject = 'SuiviActivité : Votre code de confirmation';

			 // message
			 $message = '<html><h4>SuiviActivite<h4><br><div><p>Votre code de confirmation vous permettant de changer votre mot de passe est : <b> '.$code.'</b></p></div></html>';
			

			 // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
			 $headers  = 'MIME-Version: 1.0' . "\r\n";
			 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			 // Envoi
			 //$mailSent = mail($to, $subject, $message, $headers);
			 $query = "INSERT INTO code(login, code) VALUES(:login, :code)";
			 $stmt = $bdd->prepare($query);
			 $stmt->bindValue(":login", $login);
			 $stmt->bindValue(":code", $code);

			 if( $stmt->execute()/* && $mailSent*/)
				echo '<a class="text-success">Email envoyé. :'.$code.'</a>';
			 else
				 '<a class="text-danger">Erreur lors de l\'envoi de l\'email</a>';
		}else{
				echo '<a class="text-danger">Erreur lors de l\'envoi de l\'email</a>';
		}
	}
?>