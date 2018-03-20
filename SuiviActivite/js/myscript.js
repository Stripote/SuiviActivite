/* VARIABLES */
var currentReal = null;
var toMark = null;


/* EVENEMENTS */
$( document ).ready( function(){
	$("#inputDate2").val( moment().format('YYYY-MM-DD') );
	$("#inputDate1").val( moment().format('YYYY-MM-DD') );
	actualiserRealisations(6);
	actualiserStatuts();
	
	$('[data-toggle=confirmation-delete]').confirmation({
		rootSelector: '[data-toggle=confirmation-delete]',
		container: 'body'
	});
	
	if( ($.cookie("SuiviActiviteLogin") == undefined || $.cookie("SuiviActivitePassword") == undefined) && $.cookie("cancelLogin") == undefined){
		$(".loginBtn").trigger("click");
		toggleForm(1);
	}else{
		if($.cookie("cancelLogin") == undefined){
			var loginData = {};
			loginData.login = $.cookie("SuiviActiviteLogin");
			loginData.password = $.cookie("SuiviActivitePassword");
			login($.param(loginData));
		}else{
			toggleForm(1);
		}
	}
	
	/*On active les graph, si l'on est sur la page des statistiques*/
	activeGraph();
	reloadPersonnalCharts($("#showConnectedUser").text().trim());
	
	/*On active les éditeurs rich-text*/
	$('.summernote').summernote();
});

/*Click en dehors de la box de login : on zappe l'étape de login => Désactivation du formulaire*/
$(".modal").click( function(e){
	if( e.target == this ){
		createCookieIfNotLogged()
		return false;
	} 
});


/* Click sur confirmation suppression Realisation*/
$("#btnDelete").on("confirmed.bs.confirmation", function(){
		deleteReal(currentReal);
		clearForm();
});




$("#newRealisation").submit(function(event){
	event.preventDefault();
	var moreData = { 'idReal' : 0};
	if(currentReal == null){
		toGo = './controller/send_realisation.php';
	}else{
		toGo = './controller/update_realisation.php';
		moreData = { 'idReal' : currentReal.N};
	}
	data = $(this).serialize()+ '&' + $.param(moreData);
	$.ajax({
		type:'POST', 
		data: data, 
		url: toGo,
		success: function(data){
			showSomething(data);
			actualiserRealisations(6);
			clearForm();
		},
		error: function(){
			 showSomething(data);
		}
	});
	 return false;
});
$("#loginForm").submit(function(event){
	event.preventDefault();
	data = $(this).serialize();
	login(data);
	return false;
});




$("#selectCritere").change(function(){
	selected = $(this).find(":selected");
	critere = selected.parents("optgroup").attr("value");
	valeur = selected.attr("value");
	if(valeur== null || valeur == "")
		valeur = selected.text();
	
	if(valeur=="Restantes"){
		actualiserRealisations(6, critere, valeur);
		actualiserStatuts();
	}else if(valeur=="Toutes"){
		actualiserRealisations(1, critere, valeur);
		actualiserStatuts();
	}else if(critere == "dateReception" || critere == "dateTraitement"){
		/* trier par date*/
		actualiserRealisations(2, critere, valeur);
		actualiserStatuts();
	}else{
		/* filtrer par ... */
		actualiserRealisations(3, critere, valeur);
		actualiserStatuts();
	}
});

$("#toggleChartsSuject").on("change", function(){
	selected = $(this).find(":selected");
	reloadPersonnalCharts(selected.text());
});

$( document ).ajaxComplete( function(){
	actualiserStatuts();
});

/*========================================================================================================================================================================================*/
/* FONCTIONS */

function actualiserStatuts(){
	$("#realisationTable").find("tbody").children("tr").each( function(){
		item = $(this).children("td:nth-child(2)").children("a");
		switch($(item).val()){
			case "Reçue":
				item.addClass("text-primary");
				break;
			case "En attente":
				item.addClass("text-info");
				break;
			case "En cours":
				item.addClass("text-warning");
				break;
			case "Livrée":
				item.addClass("text-white");
				item.addClass("bg-success");
				break;
			case "Abandonnée":
				item.addClass("text-danger");
				break;
		}
	});
}




function actualiserRealisations(typeGet, critere, valeur){
	$("#realisationTable tbody").LoadingOverlay("show");
	$.ajax({
		type:'POST', 
		url:'./controller/getRealisations.php',
		data: {get : typeGet, by : critere, val : valeur},
	success: function(data){
		resultats = JSON.parse(data);
		$("#realisationTable").children("tbody").children("tr").remove();
		$("#hiddenTable").children("table").find("tr:not(:first-child)").remove();
		$("#nbItemInTable").text(resultats.length);
		resultats.forEach( function(real){
			niveauWithIcon = getNiveauIcon(real.Niveau);
			statutWithIcon = getStatutIcon(real.Statut);
			$("#realisationTable").children("tbody").append('<tr class=""><td>'+real.Auteur+'</td><td>'+real.Site+'</td><td>'+real.Activite+'</td><td data-toggle="tooltip" title="'+real.Statut+' ['+real.DateTraitement+']">'+statutWithIcon+'</td><td>'+real.Type+'</td><td>'+real.Membre+'</td>'+niveauWithIcon+'<td>'+real.DateReception+'</td><td class="text-right"><a title="Gérer" onclick="chargerModification('+real.N+', this)" class="fa fa-edit btn btn-sm btn-info"></a></td></tr>');
			$("#hiddenTable").children("table").append('<tr><td>'+real.N+'</td><td>'+real.Auteur+'</td><td>'+real.Site+'</td><td>'+real.Activite+'</td><td>'+real.Statut+'</td><td>'+real.Type+'</td><td>'+real.Membre+'</td><td>'+real.LibelleNiveau+'</td><td>'+real.DateReception+'</td><td>'+real.Description+'</td><td>'+real.Commentaire+'</td></tr>');
			
			$('[data-toggle="tooltip"]').tooltip();
		});
		if(resultats.length == 0){
			$("#realisationTable").children("tbody").append('<tr><td colspan=7 style="width:100%" >Aucune réalisation n\'a été trouvée.</td></tr>');
		}
		$("#realisationTable tbody").LoadingOverlay("hide");
	},
	error: function(){
		 showSomething(data);
		 $("#realisationTable tbody").LoadingOverlay("hide");
	 }
	});
	return false;
}

function getNiveauIcon(niveau){
	content = "";
	switch(niveau){
		case "1":
			content = '<td class="text-center" data-toggle="tooltip" title="Secondaire"><span  class="niveauIcon fa fa-thermometer-1 text-info"></span></td>';
			break;
		case "2":
			content = '<td class="text-center" data-toggle="tooltip" title="Normal" ><span  class="niveauIcon fa fa-thermometer-2 text-primary"></span></td>';
			break;
		case "3":
			content = '<td class="text-center" data-toggle="tooltip" title="Urgent" ><span  class="niveauIcon fa fa-thermometer-3 text-warning"></span></td>';			
			break;
		case "4":
			content = '<td class="text-center" data-toggle="tooltip" title="Prioritaire" ><span class="niveauIcon fa fa-thermometer-4 text-danger"></span></td>';
			break;
		default:
			content = '<td class="text-center" data-toggle="tooltip" title="Secondaire"><span class="niveauIcon fa fa-thermometer-1 text-info"></span></td>';
			break;
	}
	return content;
}
function getStatutIcon(statut){
	content = "";
	switch(statut){
		case "Reçue":
			content = '<span value="Reçue" class="statutIcon btn fa fa-inbox faa-vertical animated text-info"></span>';
			break;
		case "En attente":
			content = '<span value="En attente" class="statutIcon btn fa fa-hourglass-half faa-shake animated-hover text-warning"></span>';
			break;
		case "En cours":
			content = '<span value="En cours" class="statutIcon btn fa fa-spinner faa-spin animated text-success"></span>';			
			break;
		case "Livrée":
			content = '<span value="Livrée" class="statutIcon btn fa fa-check-square faa-pulse animated text-success"></span>';
			break;
		case "Abandonnée":
			content = '<span value="Abandonnée" class="statutIcon btn fa fa-times-circle faa-flash animated-hover text-danger"></span>';
			break;
	}
	return content;
}

function chargerModification(idRealisation, clickedElement){
	/*Pour surbrillance quand supprimé*/
	toMark = $(clickedElement).find("tr");
	$("#bodyForm").LoadingOverlay("show");
	$.ajax({
		type:'POST', 
		url:'./controller/getRealisations.php',
		data: {get : 4, val : idRealisation},
	success: function(data){/*Mise a jour du formulaire avec les données chargées*/
		resultats = JSON.parse(data);
		formMod("Modification");
		resultats.forEach( function(real){
			currentReal = real;
			$("#inputEmail3").val(htmlDecode(real.Auteur));
			$("#inputType1").val(htmlDecode(real.Type));
			$("textarea[name='Commentaire']").val(htmlDecode(real.Commentaire));
			$("#inputDate1").val(htmlDecode(real.DateReception));
			$("#inputDate2").val(htmlDecode(real.DateTraitement));
			$("#inputNiveau1").val(htmlDecode(real.Niveau));
			$("#inputStatut1").val(htmlDecode(real.Statut));
			//$("#descript.summernote").summernote('code', htmlDecode(real.Description));
			$("#descript.summernote").summernote('code', real.Description);
			//$("#comment.summernote").summernote('code', htmlDecode(real.Commentaire));
			$("#comment.summernote").summernote('code', real.Commentaire);
			$("#inputSite").val(htmlDecode(real.Site));
			$("#inputActivite").val(htmlDecode(real.Activite));
			$("#bodyForm").LoadingOverlay("hide");
		});
	},
	error: function(){
		 showSomething(data);
		 $("#bodyForm").LoadingOverlay("hide");
	 }
	});
	return false;
}

function htmlEncode(value){
  // Create a in-memory div, set its inner text (which jQuery automatically encodes)
  // Then grab the encoded contents back out. The div never exists on the page.
  return $('<div/>').text(value).html();
}

function htmlDecode(value){
  return $('<div/>').html(value).text();
}

function formMod(typeFormulaire){
	if(typeFormulaire != null){
		switch(typeFormulaire){
			case "Modification" :
				$("#formTitle").text("Modifier");
				activeDeleteBtnIfLogged();
				$("#headerForm").removeClass("bg-info").addClass("bg-warning");
				$("#inputEmail3").attr("disabled", true);
				$("#btnFormRealisation").text("Modifier").removeClass("btn-primary").addClass("btn-warning");
				break;
			case "Ajouter" :
				$("#formTitle").text("Ajouter");
				$("#inputEmail3").attr("disabled", false);
				$("#btnFormRealisation").text("Ajouter").removeClass("btn-warning").addClass("btn-primary");
				break;
			default:
				break;
		}
	}
}

function clearForm(){
	currentReal = null;
	formMod("Ajouter");
	$("#headerForm").removeClass("bg-warning").addClass("bg-info");
	$("#btnDelete").removeClass("fa-trash fa float-right btn btn-large btn-danger");
	$("#inputEmail3").val(null);
	$("#inputType1").val(1);
	$("#descript.summernote").summernote('code', '');
	$("#comment.summernote").summernote('code', '');
	$("#inputDate2").val( moment().format('YYYY-MM-DD') );
	$("#inputDate1").val( moment().format('YYYY-MM-DD') );
	$("#inputNiveau1").val(1);
	$("#inputStatut1").val(1);
}

function clearParamForm(){
	
}

function deleteReal(uneRealisation){
	$.ajax({
		type:'POST', 
		url:'./controller/getRealisations.php',
		data: {get : 5, val : uneRealisation.N},
		success: function(data){
			$(toMark).addClass("animationSuppression");
			showSomething("<div class='alert alert-danger' role='alert'>Réalisation supprimée</div>");
			setTimeout(function(){
				//actualiserRealisations(1);
				//trigger change on select
				$("#selectCritere").trigger("change");
				actualiserStatuts();
			}, 1000);
		},
		error: function(){
			showSomething(data);
		}
	});
}

function showSomething(dataToShow, target){
	var item;
	if( $(target).find(".info").length > 0)
		item = $(target).find(".info");
	else if( $(target).closest("div.d-inline-block").find(".info").length > 0 ){
		item = $(target).closest("div.d-inline-block").find(".info");
	}else{
		item = $(".info");
	}
	$(item).html(dataToShow);
	setTimeout( function(){
		$(item).html("");
	}, 3000);
	
}

/*Fais disparaitre le Modal de login. Modifie l'affichage pour afficher l'utilisateur connecté et un bouton de déconnexion */
function updateLoginForm(data){
	$("#returnLoginForm").empty().append(data);
	if(data.search("success") > 0){
		$("body").removeAttr("Class");
		$("body").removeAttr("Style");
		$("#login-modal").removeClass("show");
		$(".modal-backdrop").remove();
		$("#showConnectedUser").text(data);
		$("#login-modal").css("display", "none");
		
		$.ajax({
			type:'POST', 
			url:'./controller/login.php',
			success: function(data){
				$("#showConnectedUser").html(data+' <span title="Se déconnecter" onclick="logout()" class="loginBtn navBtn fa fa-sign-out"></span>');
			}
		});
	}
}

/*Envoi une requete de déconnexion au serveur */
function logout(){
	$.ajax({
		type:'POST', 
		data: { "logout" : 1},
		url: "./controller/login.php",
		success: function(data){
			$("#showConnectedUser").empty().append(data);
			toggleForm(1);
			/*On supprimes les cookies servant à la connexion automatique*/
			$.removeCookie('SuiviActiviteLogin');
			$.removeCookie('SuiviActivitePassword');
			/*On vide le formulaire*/
			clearForm();
			toggleForm(1);
			/*On recharge les réalisations de toute l'équipe*/
			actualiserRealisations(1);
		},
		error: function(){
			 showSomething("connexion failed:"+data);
		}
	});
}

function login(dataPassed){
	/*On soumet le formulaire*/
	$.ajax({
		type:'POST', 
		data: dataPassed, 
		url: "./controller/login.php",
		success: function(dataReturned){
			toggleForm(2);
			updateLoginForm(dataReturned);
			
			/*Requete Ajax pour récupérer les identifiants de connexion de l'utilisateur qui vient de se logger*/
			$.ajax({
				type:'POST', 
				data: { 'getConnected' : 1 }, 
				url: "./controller/login.php",
				success: function(dataReturned2){
					connectedUser = JSON.parse(dataReturned2);
					$.cookie('SuiviActiviteLogin', connectedUser.login, { expires: 365 });
					$.cookie('SuiviActivitePassword', connectedUser.password, { expires: 365 });
				},
				error: function(){
					 showSomething("connexion failed:"+dataReturned2);
				}
			});
		},
		error: function(){
			 showSomething("connexion failed:"+dataReturned);
		}
	});
}


function activeDeleteBtnIfLogged(){
	$.ajax({
		type:'POST', 
		data: { "check" : 1},
		url: "./controller/login.php",
		success: function(data){
			if(data=="true")
				$("#btnDelete").addClass("fa-trash fa float-right btn btn-sm btn-danger");
		},
		error: function(){
			 showSomething("connexion failed:"+data);
			 return false;
		}
	});
}

function createCookieIfNotLogged(){
	$.ajax({
		type:'POST', 
		data: { "check" : 1},
		url: "./controller/login.php",
		success: function(data){
			if(data=="false"){
				toggleForm(1);
				/*Créé un cookie de 10 minutes pour empêcher de redemander sans cesse à l'utilisateur de se connecter*/
				 var date = new Date();
				 var minutes = 10;
				 date.setTime(date.getTime() + (minutes * 60 * 1000));
				 $.cookie('cancelLogin', true, { expires: date, path: '/' });
			}else{
				toggleForm(2);
			}
		},
		error: function(){
			 showSomething("connexion failed:"+data);
			 return false;
		}
	});
}

/*Active ou désactive le formulaire de saisie de Réalisation. [Paramètres : 1=disabled, 2=enabled]*/
function toggleForm(position){
	if(position != null){
		if(position == 1){
			$("#newRealisation input, #newRealisation select, #newRealisation button, #btnClear").each( function(){
				$(this).attr("disabled", "true");
				$(this).addClass("disabled");
			});
			$(".fa-cogs").attr("hidden", true);
			$("#comment, #descript").each( function(){
				$(this).summernote('disable'); 
			});
		}else if(position==2){
			$("#newRealisation input, #newRealisation select, #newRealisation textarea, #newRealisation button, #btnClear").each( function(){
				$(this).removeAttr("disabled");
				$(this).removeClass("disabled");
				
			});
			$(".fa-cogs").removeAttr("hidden");
			$("#comment, #descript").each( function(){
				$(this).summernote('enable'); 
			});
		}
		$("#returnLoginForm").text("");
	}
}

function activeGraph(){
	/*Graph 1*/
	loadDataForCharts("all");
	loadDataForCharts("byType");
	loadDataForCharts("byLevel");

	
}

function loadDataForCharts(typeGet){
	switch(typeGet){
		case "all":
			$.ajax({
				type:'POST', 
				url:'./controller/getStats.php',
				data: {get : 1},
				success: function(data){
					var toChart = JSON.parse(data);
					var abscisse = [];
					var ordonnee = [];
					toChart.forEach( function(record){
						abscisse.push(record.Nombre);
						ordonnee.push(record.Mois);
					});
					buildGraph("#global1", abscisse, ordonnee, "bar");	
				}, 
				error: function(){
					console.log(data);
				}
			});
			break;
		case "byLevel":
			$.ajax({
				type:'POST', 
				url:'./controller/getStats.php',
				data: {get : 3},
				success: function(data){
					var toChart = JSON.parse(data);
					var abscisse = [];
					var ordonnee = [];

					toChart.forEach( function(record){
						abscisse.push(record.Nombre);
						ordonnee.push(record.Libelle);
					});
					
					buildGraph("#global3", abscisse, ordonnee, "bar");
						
				}, 
				error: function(){
					console.log(data);
				}
			});
			break;
		case "byType":
			$.ajax({
				type:'POST', 
				url:'./controller/getStats.php',
				data: {get : 2},
				success: function(data){
					var toChart = JSON.parse(data);
					var abscisse = [];
					var ordonnee = [];

					toChart.forEach( function(record){
						abscisse.push(record.Nombre);
						ordonnee.push(record.Libelle);
					});
					
					buildGraph("#global2", abscisse, ordonnee, "horizontalBar");
						
				}, 
				error: function(){
					console.log(data);
				}
			});
			break;
		default:
			break;
	}
}

/*Le bouton d'export doit avoir le même ID que le canvas +"Btn" ex: pour le graph Global1, l'ID du bouton doit etre Global1Btn */
function buildGraph(idGraph, abscisse, ordonnee, typeGraph){
	if($(idGraph).length != 0){
		var ctx = $(idGraph)[0].getContext("2d");
		var global1 = new Chart(ctx, {
			type: typeGraph,
			data: {
				labels: ordonnee,
				datasets: [{
					label: "Réalisations",
					data: abscisse,
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(255,99,132,1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}],
					xAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}, 
				animation:{
					onComplete :  function(animation){
						/*Définis le bouton d'export*/
						var url = this.toBase64Image();
						$(idGraph+"Btn").attr("href",url);
					}
				}
			}
		});
	}	
}
/*
function removeData(chart) {
	chart.data.labels.pop();
	chart.data.datasets.forEach((dataset) => {
		dataset.data.pop();
	});
	chart.update();
}*/

function reloadPersonnalCharts(nomMembre){	
	$("#personnal1").remove();
	$("#nav-perso1").append('<canvas id="personnal1" width="100" height="100"></canvas>');
	$("#personnal2").remove();
	$("#nav-perso2").append('<canvas id="personnal2" width="100" height="100"></canvas>');
	$("#personnal3").remove();
	$("#nav-perso3").append('<canvas id="personnal3" width="100" height="100"></canvas>');
	
	$("#nav-perso1").LoadingOverlay("show");
	$.ajax({
		type:'POST', 
		url:'./controller/getStats.php',
		data: {get : 4, member : nomMembre},
		success: function(data){
			var toChart = JSON.parse(data);
			var abscisse = [];
			var ordonnee = [];
			toChart.forEach( function(record){
				abscisse.push(record.Nombre);
				ordonnee.push(record.Mois);
			});
			buildGraph("#personnal1", abscisse, ordonnee, "bar");
			$("#nav-perso1").LoadingOverlay("hide");
		}, 
		error: function(){
			$("#nav-perso1").LoadingOverlay("hide");
			console.log(data);
		}
	});
	$("#nav-perso1").LoadingOverlay("hide");
	
	
	toChart = null;
	abscisse = null;
	ordonnee = null;
	
	$("#nav-perso2").LoadingOverlay("show");
	$.ajax({
		type:'POST', 
		url:'./controller/getStats.php',
		data: {get : 5, member : nomMembre},
		success: function(data){
			var toChart = JSON.parse(data);
			var abscisse = [];
			var ordonnee = [];
			toChart.forEach( function(record){
				abscisse.push(record.Nombre);
				ordonnee.push(record.Libelle);
			});
			buildGraph("#personnal2", abscisse, ordonnee, "horizontalBar");
			$("#nav-perso2").LoadingOverlay("hide");	
		}, 
		error: function(){
			$("#nav-perso2").LoadingOverlay("hide");
			console.log(data);
		}
	});
	$("#nav-perso2").LoadingOverlay("hide");

	
	toChart = null;
	abscisse = null;
	ordonnee = null;
	$("#nav-perso3").LoadingOverlay("show");
	$.ajax({
		type:'POST', 
		url:'./controller/getStats.php',
		data: {get : 6, member : nomMembre},
		success: function(data){
			var toChart = JSON.parse(data);
			var abscisse = [];
			var ordonnee = [];
			toChart.forEach( function(record){
				abscisse.push(record.Nombre);
				ordonnee.push(record.Libelle);
			});
			buildGraph("#personnal3", abscisse, ordonnee, "bar");
			$("#nav-perso3").LoadingOverlay("hide");	
		}, 
		error: function(){
			$("#nav-perso3").LoadingOverlay("hide");
			console.log(data);
		}
	});
	$("#nav-perso3").LoadingOverlay("hide");
	
	toChart = null;
	abscisse = null;
	ordonnee = null;
	
}


function exportData(){
	console.log("exported");
	$("#hiddenTable").table2excel({
		//exclude: ".excludeThisClass",
		name: "Detail des realisations",
		filename: "Realisations_export"+Date.now(), //do not include extension
		fileext: ".xls"
	});
}



/* |||||||||||||||||||||||||||||||||||          PAGE PARAMETRES         ||||||||||||||||||||||||||||||||||||*/

/*Fonction créée en one shot, pas adaptable aux autres composants similaires*/
function ResetInputTypeLibelle(){
	$("#idTypeLibelle").val("");
	$("#inputTypeLibelle").val("");
	$("#inputTypeLibelle").removeClass("border-warning ").addClass("border-success");
	$("#submitTypeLibelle").removeClass("btn-outline-warning fa fa-edit").addClass(" btn-outline-success fa fa-plus-square");
	$("#clearTypeLibelle").attr("hidden", true);
	$("#deleteTypeLibelle").attr("hidden", true);
	$("#paramTypeTable tbody tr").remove();
	$.ajax({
		type:'POST', 
		url:'./controller/controller.php',
		data: {get : "reloadTypes"},
		success: function(data){
			$("#paramTypeTable tbody").append(data);
		}, 
		error: function(){
			
		}
	});
}
/*Même fonction, adaptée pour fonctionner avec des classes : réutilisable*/
function resetParamsPageInputs(target){
	$(target).closest("form").find(".param_inputId").val("");
	$(target).closest("form").find(".param_inputLibelle").val("");
	$(target).closest("form").find(".param_inputLibelle").removeClass("border-warning").addClass("border-success");
	$(target).closest("form").find(".param[type='submit']").removeClass("btn-outline-warning fa fa-edit").addClass(" btn-outline-success fa fa-plus-square");
	$(target).closest("form").find(".param_clearBtn").attr("hidden", true);
	$(target).closest("form").find(".param_deleteBtn").attr("hidden", true);
	$(target).closest("form").find(".param_list tbody tr").remove();
	var nameForm = $(target).closest("form").attr("nom_formulaire");
	$.ajax({
		type:'POST', 
		url:'./controller/controller.php',
		data: {get : "reload", what : nameForm},
		success: function(data){
			if($(target).closest("div.d-inline-block").find(".param_list tbody tr").length > 0){
				$(target).closest("div.d-inline-block").find(".param_list tbody tr").remove();
				$(target).closest("div.d-inline-block").find(".param_list tbody").append(data);
			}else{
				$(target).closest("div.active").find(".param_list tbody tr").remove();
				$(target).closest("div.active").find(".param_list tbody").append(data);
			}	
		}, 
		error: function(){
			
		}
	});
}




/*On supprime le type*/
$(document).on("confirmed.bs.confirmation", ".param_deleteBtn", function(event){
	var target = event.target;
	var idToDelete = $(target).closest("div.d-inline-block").find(".param_inputId").val();
	var nomFormulaire = $(target).closest("div.d-inline-block").find("form").attr("nom_formulaire");
	var deleteWhat = "";
	switch(nomFormulaire){
		case "statuts":
			deleteWhat = "deleteStatut";
			break;
		case "types":
			deleteWhat = "deleteType";
			break;
		case "niveaux":
			deleteWhat = "deleteNiveau";
			break;
		case "membre":
			deleteWhat = "deleteMembre";
			break;
		default:
			break;
	}
	$.ajax({
		type:'POST', 
		url:'./controller/controller.php',
		data: {get : deleteWhat, id : idToDelete },
	success: function(data){
		showSomething(data, event.target);
		resetParamsPageInputs(event.target);
	},
	error: function(){
		 showSomething(data, event.target);
		 resetParamsPageInputs(event.target);
	 }
	});
});

$(document).on("submit", ".active form", function(event){
	var target = event.target;
	event.preventDefault();
	var nameForm = $(target).closest("form").attr("nom_formulaire");
	var idToUpdate;
	var libelleToUpdate;
	idToUpdate = $(target).closest("div.d-inline-block").find(".param_inputId").val();
	libelleToUpdate = $(target).closest("div.d-inline-block").find(".param_inputLibelle").val();
	switch(nameForm){
		case "types":
				if(idToUpdate != ""){
					$.ajax({
						type:'POST', 
						url:'./controller/controller.php',
						data: {get : "updateType", id : idToUpdate, libelle : libelleToUpdate},
						success: function(data){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						},
						error: function(){
							 showSomething(data, event.target);
							 resetParamsPageInputs(event.target);
						 }
					});
				}else{
					$.ajax({
						type:'POST', 
						url:'./controller/controller.php',
						data: {get : "insertType", libelle : libelleToUpdate},
						success: function(data){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						},
						error: function(){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						 }
					});
				}	
			break;
		case "statuts":
				if(idToUpdate != ""){
					$.ajax({
						type:'POST', 
						url:'./controller/controller.php',
						data: {get : "updateStatut", id : idToUpdate, libelle : libelleToUpdate},
						success: function(data){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						},
						error: function(){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						 }
					});
				}else{
					$.ajax({
						type:'POST', 
						url:'./controller/controller.php',
						data: {get : "insertStatut", libelle : libelleToUpdate},
						success: function(data){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						},
						error: function(){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						 }
					});
				}	
			break;
		case "niveaux":
				if(idToUpdate != ""){
					$.ajax({
						type:'POST', 
						url:'./controller/controller.php',
						data: {get : "updateNiveau", id : idToUpdate, libelle : libelleToUpdate},
						success: function(data){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						},
						error: function(){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						 }
					});
				}else{
					$.ajax({
						type:'POST', 
						url:'./controller/controller.php',
						data: {get : "insertNiveau", libelle : libelleToUpdate},
						success: function(data){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						},
						error: function(){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						 }
					});
				}	
			break;
		case "membre":
				if(idToUpdate != ""){
					$.ajax({
						type:'POST', 
						url:'./controller/controller.php',
						data: {get : "updateMembre", id : idToUpdate, libelle : libelleToUpdate},
						success: function(data){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						},
						error: function(){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						 }
					});
				}else{
					$.ajax({
						type:'POST', 
						url:'./controller/controller.php',
						data: {get : "insertMembre", libelle : libelleToUpdate},
						success: function(data){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						},
						error: function(){
							showSomething(data, event.target);
							resetParamsPageInputs(event.target);
						 }
					});
				}	
			break;
		default:
			break;
	}
});

/*Click sur suppression libellé type : REUSABLE*/
$(document).on("click", ".active .param_list td", function(event){
	var item = event.target;
	if($(item).closest("div").find(".param_inputId").length > 0){
		$(item).closest("div").find(".param_inputId").val( $(this).attr("value"));
		$(item).closest("div").find(".param_inputLibelle").val( $(this).text() );
		$(item).closest("div").find(".param_inputLibelle").removeClass("border-success").addClass("border-warning");
		$(item).closest("div").find(".param[type='submit']").removeClass("btn-outline-success fa fa-plus-square").addClass("btn-outline-warning fa fa-edit");
		$(item).closest("div").find(".param_clearBtn").attr("hidden", false);
		$(item).closest("div").find(".param_deleteBtn").attr("hidden", false);
	}else{
		$(item).closest("div#nav-tabContent .active").find(".param_inputId").val( $(this).attr("value"));
		$(item).closest("div#nav-tabContent .active").find(".param_inputLibelle").val( $(this).text() );
		$(item).closest("div#nav-tabContent .active").find(".param_inputLibelle").removeClass("border-success").addClass("border-warning");
		$(item).closest("div#nav-tabContent .active").find(".param[type='submit']").removeClass("btn-outline-success fa fa-plus-square").addClass("btn-outline-warning fa fa-edit");
		$(item).closest("div#nav-tabContent .active").find(".param_clearBtn").attr("hidden", false);
		$(item).closest("div#nav-tabContent .active").find(".param_deleteBtn").attr("hidden", false);
	}

});

/*REUSABLE*/
$(document).on("click", ".active .param_clearBtn", function(event){
	resetParamsPageInputs(event.target);
});

/*----------- PARAM MYACCOUNT -------------
//Click sur reset password(){
	this.remove()
	form.show()
	input[password].attr("hidden", true);
	appel fonction php : envoyer mail avec un code généré, avec une date/heure d'émission.
}
*/
$(document).on("confirmed.bs.confirmation", "#btnResetPass", function(event){
	$(event.target).attr("hidden", true);
	$.ajax({
		type:'POST', 
		url:'./controller/reset.php',
		data: {action : "sendEmail", login : $.cookie("SuiviActiviteLogin") },
		success: function(data){
			showSomething(data);
			console.log(data);
		},
		error: function(){
			showSomething(data, event.target);
			console.log(data);
		 }
	});	
});

$(document).on("submit", "#newNiveauStatutForm", function(event){
	var target = event.taget;
	$(target).find("input[name='code']").closest("div").attr("hidden", true).removeAttr("required");
	var code = $(target).find("input[name='code']").val();
	var login = $.cookie('connectedUser');
	$.ajax({
		type:'POST', 
		url:'./controller/reset.php',
		data: {action : "checkCode", login : login , code : code  },
		success: function(data){
			if(data == "success"){
				alert("Code correct");
			}else if(data == "failure"){
				alert("Code FAUX");
			}
		},
		error: function(){
			showSomething(data, event.target);
		 }
	});
	
	alert("Code correct");
});


