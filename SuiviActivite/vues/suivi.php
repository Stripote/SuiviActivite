<br>
		<div class="info"></div>
		<div class="card">
			<h5 id="headerForm" class="card-header text-white bg-info">
				<span id="formTitle">Ajouter</span> une réalisation
				
				<span title="Supprimer la réalisation" id="btnDelete" class="" data-toggle="confirmation-delete"
						data-btn-ok-label="Oui" data-btn-ok-icon="glyphicon glyphicon-share-alt"
						data-btn-ok-class="btn-success"
						data-btn-cancel-label="Non" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
						data-btn-cancel-class="btn-danger"
						data-title="Voulez-vous vraiment supprimer la réalisation ?" data-content="Cette action est définitive.">
				  
				</span>
				<span title="Vider le formulaire" id="btnClear" onclick="clearForm()" class="fa fa-eraser btn btn-sm btn-light float-right"></span>
			</h5>
			<div id="bodyForm" class="card-body bg-light text-black">
				<form method="post" id="newRealisation" accept-charset="ISO 8859-1">
					
					<div class="form-group row">
						
						<label for="inputEmail3" class="col-xl-1 col-lg-2 col-sm-0 label-align col-form-label">Auteur</label>
						<input name="Auteur" type="text" class="col-xl-3 col-lg-3 col-sm-12 form-control " id="inputEmail3" list="auteurs" placeholder="">
						<datalist id="auteurs">
						  <?php chargerAuteurs(); ?>
						</datalist>
						
						<label for="inputSite" class="col-xl-2 col-lg-1 col-sm-0 label-align col-form-label">Site</label>
						<input name="Site" type="text" class="col-xl-2 col-lg-2 col-sm-12 form-control" id="inputSite" placeholder="">

						<label for="inputDate1" class="col-xl-2 col-lg-2 col-sm-0 label-align col-form-label ">Date de réception</label>
						<input name="DateReception" type="date" class="col-xl-2 col-lg-2 col-sm-12 form-control" id="inputDate1" >
					</div> 
					
					 <div class="form-group row"> 
						<label for="inputType1" class="col-xl-1 col-lg-1 label-align col-sm-0 col-form-label">Type</label>
					    <select name="Type" class="col-xl-3 col-lg-3 col-sm-12 form-control" id="inputType1">
						  <?php chargerTypes(); ?>
					    </select>
						<label for="inputActivite" class="col-xl-2 col-lg-2 col-sm-0 label-align col-form-label">Activité</label>
						<input name="Activite" type="text" class="col-xl-2 col-lg-2 col-sm-12 form-control" id="inputActivite" placeholder="">
						
						<label for="inputDate2" class="col-xl-2 col-lg-2 col-sm-0 label-align col-form-label ">Date de traitement</label>
						<input name="DateTraitement" type="date" class="col-xl-2 col-lg-2 col-sm-12 form-control" id="inputDate2" >
					 </div>
					<div class="form-group row"> 
						<div class="col-xl-6 col-lg-6 col-sm-12 form-group">
							<label class="col-form-label" for="descript">Description</label>
							<textarea name="Description" class="summernote form-control col-12" rows="3" id="descript"></textarea>
						</div>
						<div class="col-xl-6 col-lg-6 col-sm-12 form-group">
							<label class="col-form-label" for="comment">Commentaire</label>
							<textarea name="Commentaire" class="summernote form-control col-12" rows="3" id="comment"></textarea>	
						</div>
					 </div> 
					 <div class="form-group row"> 
						<label for="inputNiveau1" class="col-xl-1 col-lg-2 label-align col-sm-0 col-form-label">Niveau</label>
						<select name="Niveau" class="col-xl-3 col-lg-3 col-sm-12 form-control" id="inputNiveau1">
							<?php chargerNiveaux(); ?>
						</select>

						
						<label for="inputStatut1" class="col-xl-1 col-lg-2 label-align col-sm-0 col-form-label">Statut</label>
						<select name="Statut" class="col-xl-3 col-lg-3 col-sm-12 form-control" id="inputStatut1">
							<?php chargerStatuts(); ?>
						</select>

						<div class="offset-xl-2 col-xl-2 col-lg-2 col-sm-12 col-sm-pt-1 text-right ">
							<button type="submit" id="btnFormRealisation"class="btn btn-primary">Enregistrer</button>
						</div>
					</div> 
				</form>
			</div>
		</div>
		
		<br><br>
		<div class="card">
			
			<h5 class="text-white bg-info card-header"><span id="nbItemInTable"></span>
			 Réalisations 
			<span class="float-right">
				<form id="trierRealisations" method="post" action="#">
					<select class="form-control" id="selectCritere" name="critere">
						<option name="critereValue">Toutes</option>
						<option selected name="critereValue">Restantes</option>
						<optgroup name="critereCat" value="statut" label="Statut">
							<?php chargerStatuts(1); ?>
						</optgroup>
						<optgroup name="critereCat" value="dateReception" label="Date de réception">
							<option name="critereValue" value="DESC">Du + récent au + ancien</option>
							<option name="critereValue" value="ASC">Du + ancien au + récent</option>
						</optgroup>
						<optgroup name="critereCat" value="dateTraitement" label="Date de traitement">
							<option name="critereValue" value="DESC">Du + récent au + ancien</option>
							<option name="critereValue" value="ASC">Du + ancien au + récent</option>
						</optgroup>
						<optgroup name="critereCat" value="auteur" label="Auteur">
							<?php chargerAuteurs(1); ?>
						</optgroup>
						<optgroup name="critereCat" value="membre" label="Membre">
							<?php chargerMembres(); ?>
						</optgroup>
					</select>
				</form>
			</span>
			<span title="Exporter au format excel" data-toggle="tooltip" onclick="exportData()" class="float-right btn fa fa-file-excel-o"></span>
			</h5>
			<div class="starter-template">
				<table id="realisationTable" class="table">
					<thead class="thead-inverse">
						<tr>
							<th><a title="Personne qui à émise la demande">Auteur</a></th>
							<th><a title="Site géographique du demandeur">Site</a></th>
							<th><a title="Activtié du demandeur">Activité</a></th>
							<th><a title="Statut de la demande">Statut</a></th>
							<th class="text-center"><a title="Type de réalisation">Type</a></th>
							<th><a title="Membre du support ayant pris en charge la demande">Prise en charge par</a></th>
							<th class="text-center"><a title="Niveau de priorité">Priorité</a></th>
							<th><a title="Date de réception de la demande">Date de réception</a></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<!--- Appel ajax au chargement de la page -->
					</tbody>
				</table>
				<div hidden id="hiddenTable">
					<table>
						<tr>
							<th>Num</th>
							<th>Auteur</th>
							<th>Site</th>
							<th>Activité</th>
							<th>Statut</th>
							<th>Type</th>
							<th>Prise en charge par</th>
							<th>Priorité</th>
							<th>Date de réception</th>
							<th>Description</th>
							<th>Commentaire</th>
						</tr>
					</table>
				</div>
			</div>
