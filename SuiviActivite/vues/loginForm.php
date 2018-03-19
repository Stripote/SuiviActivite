<a id="showConnectedUser" class="float-right text-white">
<?php
session_start();
if(isset($_SESSION['connectedName'])){
	echo $_SESSION['connectedName'].' <span title="Se déconnecter" onclick="logout()" class="loginBtn navBtn fa fa-sign-out"></span>';
}else{
	echo '<span href="#" title="Se connecter" class="loginBtn navBtn fa fa-sign-in" data-toggle="modal" data-target="#login-modal"></span>';
}
?>
</a>