<?php
// Sous WAMP (Windows)
	echo '<h3>Test connexion 1</h3><br>';
	try{
		$bdd = new PDO('mysql:host=10.37.1.17;dbname=tickets;charset=utf8', 'root', '$Strip17079449');
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$bdd->query("SET NAMES UTF8");
		$bdd->query("SET lc_time_names = 'fr_FR'");
		echo '<a>Connexion réussie</a><br>';
	}
	catch(Exception $e)
	{
		echo ("Connexion BDD échouée <br>" .  $e->getMessage());
	}
	
	echo '<h3>Test connexion 2</h3><br>';
	try{
		$bdd = new PDO('mysql:host=10.37.1.17;dbname=tickets;charset=utf8', 'tickets', 'khXtFI8yS5GPptHY');
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$bdd->query("SET NAMES UTF8");
		$bdd->query("SET lc_time_names = 'fr_FR'");
		echo '<a>Connexion réussie</a><br>';
	}
	catch(Exception $e)
	{
		echo ("Connexion BDD échouée <br>" .  $e->getMessage());
	}

?>