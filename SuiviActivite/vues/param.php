<br>
		<h2 class="text-default"><span class="text-warning fa fa-cogs"></span> Paramètres</h2>
		<br>
		<div id="div_formParam" class="card text-center">
			<h5 id="headerForm" class="card-header text-white bg-info">
				<span class="text-left float-left fa fa-wrench"></span> Gérer les composants de formulaire
			</h5>
			<div class="card-header">
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" id="nav-type-tab" data-toggle="tab" href="#nav-type" role="tab" aria-controls="nav-type" aria-selected="true">Types de réalisations</a>
					<a class="nav-item nav-link" id="nav-nivstat-tab" data-toggle="tab" href="#nav-nivstat" role="tab" aria-controls="nav-nivstat" aria-selected="false">Niveaux & Statuts</a>
					<a class="nav-item nav-link" id="nav-author-tab" data-toggle="tab" href="#nav-author" role="tab" aria-controls="nav-author" aria-selected="false">Auteurs</a>
				</div>
			</div>
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active row" id="nav-type" role="tabpanel" aria-labelledby="nav-type-tab">
					<div class="col-lg-6 col-md-5 col-sm-4 col-xs-2 pt-3 ml-3 d-inline-block float-left">
						<table id="param_TypeForm" class="param_list table table-sm table-bordered table-hover">
							<thead class="thead-inverse thead-light">
								<tr>
									<th><a>Types</a></th>
								</tr>
							</thead>
							<tbody class="bg-light">
								<?php chargerTypes(1); ?>
							</tbody>
						</table>
					</div>
					<div class="col-lg-5 col-md-6 col-sm-7 col-xs-9 pt-3 d-inline-block">
						<form nom_formulaire="types" class="form-inline" id="newTypeForm" method="post" action="#">							
							<div class="col-12 input-group mb-3">
								<input hidden class="param_inputId" id="idTypeLibelle" name="idType"/>
								<input required type="text" class="param_inputLibelle form-control form-control-lg border border-success" id="inputTypeLibelle" name="Type_name" placeholder="Nouveau type" aria-label="Nouveau type" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button id="submitTypeLibelle" type="submit" class="param btn btn-outline-success fa fa-plus-square" type="button"></button>
									<button hidden id="clearTypeLibelle" class="param_clearBtn btn btn-sm btn-outline-info fa fa-eraser" type="button"></button>									
									<span hidden title="Supprimer la réalisation" class="param_deleteBtn btn btn-sm btn-outline-danger fa fa-trash" data-toggle="confirmation-delete"
											data-btn-ok-label="Oui" data-btn-ok-icon="glyphicon glyphicon-share-alt"
											data-btn-ok-class="btn-success"
											data-btn-cancel-label="Non" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
											data-btn-cancel-class="btn-danger"
											data-title="Voulez-vous vraiment supprimer cet élément ?">
									  
									</span>
								</div>
							</div>
							<div class="info"></div>
						</form>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-nivstat" role="tabpanel" aria-labelledby="nav-nivstat-tab">
					<div class="col-lg-6 col-md-5 col-sm-4 col-xs-2 pt-3 d-inline-block float-left">
						<table id="param_StatForm" class="param_list table table-sm table-bordered table-hover">
							<thead class="thead-inverse thead-light">
								<tr>
									<th><a>Statuts</a></th>
								</tr>
							</thead>
							<tbody class="bg-light">
								<?php reload("statuts"); ?>
							</tbody>
						</table>
						<form nom_formulaire="statuts" class="form-inline" id="newNiveauStatutForm" method="post" action="#">							
							<div class="col-12 input-group mb-3">
								<input hidden  class="param_inputId" name="idType"/>
								<input required type="text" class="param_inputLibelle form-control form-control-lg border border-success" name="Type_name" placeholder="Nouveau statut" aria-label="Nouveau statut" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button  type="submit" class="param btn btn-outline-success fa fa-plus-square" type="button"></button>
									<button hidden class="param_clearBtn btn btn-sm btn-outline-info fa fa-eraser" type="button"></button>									
									<span hidden title="Supprimer la réalisation"  class="param_deleteBtn btn btn-sm btn-outline-danger fa fa-trash" data-toggle="confirmation-delete"
											data-btn-ok-label="Oui" data-btn-ok-icon="glyphicon glyphicon-share-alt"
											data-btn-ok-class="btn-success"
											data-btn-cancel-label="Non" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
											data-btn-cancel-class="btn-danger"
											data-title="Voulez-vous vraiment supprimer cet élément ?">
									  
									</span>
								</div>
							</div>
							<div class="info"></div>
						</form>
					</div>
					<div class="col-lg-6 col-md-7 col-sm-8 col-xs-10 pt-3 d-inline-block">
						<table id="param_NivForm" class="param_list table table-sm table-bordered table-hover">
							<thead class="thead-inverse thead-light">
								<tr>
									<th><a>Niveaux</a></th>
								</tr>
							</thead>
							<tbody class="bg-light">
								<?php reload("niveaux"); ?>
							</tbody>
						</table>
						<form nom_formulaire="niveaux" class="form-inline" id="newNiveauStatutForm" method="post" action="#">							
							<div class="col-12 input-group mb-3">
								<input hidden  class="param_inputId" name="idType"/>
								<input required type="text" class="param_inputLibelle form-control form-control-lg border border-success" name="Type_name" placeholder="Nouveau niveau" aria-label="Nouveau niveau" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button  type="submit" class="param btn btn-outline-success fa fa-plus-square" type="button"></button>
									<button hidden class="param_clearBtn btn btn-sm btn-outline-info fa fa-eraser" type="button"></button>									
									<span hidden title="Supprimer la réalisation"  class="param_deleteBtn btn btn-sm btn-outline-danger fa fa-trash" data-toggle="confirmation-delete"
											data-btn-ok-label="Oui" data-btn-ok-icon="glyphicon glyphicon-share-alt"
											data-btn-ok-class="btn-success"
											data-btn-cancel-label="Non" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
											data-btn-cancel-class="btn-danger"
											data-title="Voulez-vous vraiment supprimer cet élément ?">
									  
									</span>
								</div>
							</div>
							<div class="info"></div>
						</form>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-author" role="tabpanel" aria-labelledby="nav-author-tab">
					<div class="tab-pane fade show active row" id="nav-type" role="tabpanel" aria-labelledby="nav-type-tab">
					<div class="col-lg-6 col-md-5 col-sm-4 col-xs-2 pt-3 ml-3 d-inline-block float-left">
						<table id="param_MemberForm" class="param_list table table-sm table-bordered table-hover">
							<thead class="thead-inverse thead-light">
								<tr>
									<th><a>Auteurs & Membres</a></th>
								</tr>
							</thead>
							<tbody class="bg-light">
								<?php chargerMembres(1); ?>
							</tbody>
						</table>
					</div>
					<div class="col-lg-5 col-md-6 col-sm-7 col-xs-9 pt-3 d-inline-block">
						<form nom_formulaire="membre" class="form-inline" id="newTypeForm" method="post" action="#">							
							<div class="col-12 input-group mb-3">
								<input hidden class="param_inputId" name="idType"/>
								<input required type="text" class="param_inputLibelle form-control form-control-lg border border-success" id="inputTypeLibelle" placeholder="Nouveau membre" aria-label="Nouveau membre" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button id="submitTypeLibelle" type="submit" class="param btn btn-outline-success fa fa-plus-square" type="button"></button>
									<button hidden id="clearTypeLibelle" class="param_clearBtn btn btn-sm btn-outline-info fa fa-eraser" type="button"></button>									
									<span hidden title="Supprimer la réalisation" class="param_deleteBtn btn btn-sm btn-outline-danger fa fa-trash" data-toggle="confirmation-delete"
											data-btn-ok-label="Oui" data-btn-ok-icon="glyphicon glyphicon-share-alt"
											data-btn-ok-class="btn-success"
											data-btn-cancel-label="Non" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
											data-btn-cancel-class="btn-danger"
											data-title="Voulez-vous vraiment supprimer cet élément ?">
									  
									</span>
								</div>
							</div>
							<div class="info"></div>
						</form>
					</div>
				</div>
				</div>
			</div>
		</div>
		<br>
		<div class="card">
			<h5 id="headerForm" class="card-header text-white text-center bg-warning">
					<span class="text-left float-left fa fa-id-card"></span> Mon compte
			</h5>
			<div class="row" id="div_myAccount">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 container">
					<div class="card bg-light">
						<form nom_formulaire="myaccountLogin" class="form-inline mt-2" id="newNiveauStatutForm" method="post" action="#">							
							<div class="col-12 input-group mb-3">
								<label class="col-sm-3 col-xs-12">Utilisateur</label>
								<input required type="text" class="param_inputLibelle form-control form-control-sm border border-default col-sm-9 col-xs-12" name="Type_name" aria-label="Utilisateur" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button  type="submit" class="param btn btn-outline-default fa fa-edit" type="button"></button>
								</div>
							</div>
							<div class="info"></div>
						</form>
						
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 container">
					<div class="card bg-light"> 
						<span title="Êtes-vous sûr ?" class="param_deleteBtn m-2 p-2 btn btn-outline-primary btn-sm" data-toggle="confirmation-delete"
								data-btn-ok-label="Oui" data-btn-ok-icon="glyphicon glyphicon-share-alt"
								data-btn-ok-class="btn-success"
								data-btn-cancel-label="Non" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
								data-btn-cancel-class="btn-danger"
								data-title="Êtes-vous sûr ?">Réinitialiser votre mot de passe
						  
						</span>
						<form nom_formulaire="myaccountPassword" class="form-inline mt-2" id="newNiveauStatutForm" method="post" action="#">							
							<div class="col-12 input-group mb-1">
								<label class="secretLabel col-sm-5 label-info col-xs-12">Code secret</label>
								<input required type="text" class="param_inputLibelle form-control form-control-sm border border-info col-sm-5 col-xs-12" name="Type_name" aria-label="Utilisateur" aria-describedby="basic-addon2">	
								<div class="input-group-append">
									<button title="Envoyer" type="submit" class="param btn btn-info fa fa-paper-plane" type="button"></button>
								</div>
							</div>
							<div class="col-12 input-group mb-1">
								<label class="secretLabel col-sm-5 col-xs-12">Ancien mot de passe</label>
								<input required type="password" class="param_inputLibelle form-control form-control-sm border border-default col-sm-5 col-xs-12" name="Type_name" aria-label="Utilisateur" aria-describedby="basic-addon2">
							</div>
							<div class="col-12 input-group mb-1">
								<label class="secretLabel col-sm-5 col-xs-12">Nouveau mot de passe</label>
								<input required type="password" class="param_inputLibelle form-control form-control-sm border border-default col-sm-5 col-xs-12" name="Type_name" aria-label="Utilisateur" aria-describedby="basic-addon2">	
							</div>
							<div class="col-12 input-group mb-1">
								<label class="secretLabel col-sm-5 col-xs-12">Répétez le nouveau mot de passe</label>
								<input required type="password" class="param_inputLibelle form-control form-control-sm border border-default col-sm-5 col-xs-12" name="Type_name" aria-label="Utilisateur" aria-describedby="basic-addon2">
							</div>
							<div class="info"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
