<!DOCTYPE html>
<html>
<head>
<title>Suivi d'activité - Support & Téléphonie</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/login.css"/>
<link rel="stylesheet" type="text/css" href="css/font-awesome-animation.min.css"/>
<link rel="stylesheet" type="text/css" href="css/summernote-bs4.css"/>

<link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/site.webmanifest">
<link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="img/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="img/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
</head>
<body>
		<nav class="navbar navbar-expand navbar-collapse navbar-dark bg-primary">
			  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			  </button>
			  <a class="navbar-brand" href="index.php">Suivi d'activité</a>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
				  <li class="nav-item">
					<a title="Statistiques" class="nav-link navBtn fa fa-line-chart" href="?page=stats"><span class="sr-only">(current)</span></a>
				  </li>
				</ul>
				<?php include("vues/loginForm.php") ?>
				<a title="Paramétrer le site" hidden class="navBtn float-right nav-link fa fa-cogs" href="?page=param"><span class="sr-only"></span></a>
				<form hidden class="form-inline my-2 my-lg-0">
				  <input disabled class="form-control mr-sm-2" type="text" placeholder="Search">
				  <button disabled class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			  </div>
		</nav>
			
		<div class="container">
		<?php
			if(!isset($_SESSION))
				session_start();
			include("controller/controller.php");
			
			if(isset($_GET['page'])){
				switch($_GET['page']){
					case 'param':
						include("vues/param.php");
						break;
					case 'stats':
						//Avant de diriger vers la page de statistiques, on vérifie que la personne est connectée
						if(isset($_SESSION['connectedId'])){
							include("vues/stats.php");
						}
						else{
							header('Location: index.php');
						}
						break;
					default:
						include("vues/suivi.php");
						break;
				}
			}else{
				include("vues/suivi.php");
			}
		?>
		</div>
		<br>
		<br>
		<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="loginmodal-container">
					<h1>Connexion</h1><br>
					<div id="returnLoginForm"></div>
					<form id="loginForm">
						<input autocomplete="user" type="text" name="login" placeholder="Login">
						<input autocomplete="current-password" type="password" name="password" placeholder="Mot de passe">
						<input type="submit" name="login" class="login loginmodal-submit" value="Login">
					</form>
					
					<div class="login-help">
						<a href="#">Register</a> - <a href="#">Forgot Password</a>
					</div>
				</div>
			</div>
		</div>
</body>
<footer>
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-confirmation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/myscript.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/src/loadingoverlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/extras/loadingoverlay_progress/loadingoverlay_progress.min.js"></script>
<script src="js/summernote-bs4.js"></script>





</footer>

</html>

