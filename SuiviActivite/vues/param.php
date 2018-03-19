<br>
		<h2 class="text-default"><span class="text-warning fa fa-cogs"></span> Paramètres</h2>
		<br>
		<div class="card text-center">
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
					<div class="col-lg-6 col-md-5 col-sm-4 col-xs-2 pt-3 d-inline-block float-left">
						<table id="paramTypeTable" class="param_list table table-sm table-bordered table-hover">
							<thead class="thead-inverse thead-light">
								<tr>
									<th><a>Libellés</a></th>
								</tr>
							</thead>
							<tbody>
								<?php chargerTypes(1); ?>
							</tbody>
						</table>
					</div>
					<div class="col-lg-6 col-md-7 col-sm-8 col-xs-10 pt-3 d-inline-block">
						<form nom_formulaire="types" class="form-inline" id="newTypeForm" method="post" action="#">							
							<div class="col-12 input-group mb-3">
								<input hidden class="param_inputId" id="idTypeLibelle" name="idType"/>
								<input type="text" class="param_inputLibelle form-control form-control-lg border border-success" id="inputTypeLibelle" name="Type_name" placeholder="Nouveau type" aria-label="Nouveau type" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button id="submitTypeLibelle" type="submit" class="param btn btn-outline-success fa fa-plus-square" type="button"></button>
									<button hidden id="clearTypeLibelle" class="param_clearBtn btn btn-sm btn-outline-info fa fa-eraser" type="button"></button>									
									<span hidden title="Supprimer la réalisation" class=" btn btn-sm btn-outline-danger fa fa-trash" data-toggle="confirmation-delete"
											data-btn-ok-label="Oui" data-btn-ok-icon="glyphicon glyphicon-share-alt"
											data-btn-ok-class="btn-success"
											data-btn-cancel-label="Non" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
											data-btn-cancel-class="btn-danger"
											data-title="Voulez-vous vraiment supprimer ce type de libellé ?">
									  
									</span>
								</div>
							</div>
							<div class="info"></div>
						</form>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-nivstat" role="tabpanel" aria-labelledby="nav-nivstat-tab">
					<div class="col-lg-6 col-md-5 col-sm-4 col-xs-2 pt-3 d-inline-block float-left">
						<table class="param_list table table-sm table-bordered table-hover">
							<thead class="thead-inverse thead-light">
								<tr>
									<th><a>Libellés</a></th>
								</tr>
							</thead>
							<tbody>
								<?php reload("statuts&niveaux"); ?>
							</tbody>
						</table>
					</div>
					<div class="col-lg-6 col-md-7 col-sm-8 col-xs-10 pt-3 d-inline-block">
						<form nom_formulaire="statuts&niveaux" class="form-inline" id="newNiveauStatutForm" method="post" action="#">							
							<div class="col-12 input-group mb-3">
								<input hidden  class="param_inputId" name="idType"/>
								<input type="text" class="param_inputLibelle form-control form-control-lg border border-success" name="Type_name" placeholder="Nouveau type" aria-label="Nouveau type" aria-describedby="basic-addon2">
								<div class="input-group-append">
									<button  type="submit" class="param btn btn-outline-success fa fa-plus-square" type="button"></button>
									<button hidden class="param_clearBtn btn btn-sm btn-outline-info fa fa-eraser" type="button"></button>									
									<span hidden title="Supprimer la réalisation"  class="param_deleteBtn btn btn-sm btn-outline-danger fa fa-trash" data-toggle="confirmation-delete"
											data-btn-ok-label="Oui" data-btn-ok-icon="glyphicon glyphicon-share-alt"
											data-btn-ok-class="btn-success"
											data-btn-cancel-label="Non" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"
											data-btn-cancel-class="btn-danger"
											data-title="Voulez-vous vraiment supprimer ce type de libellé ?">
									  
									</span>
								</div>
							</div>
							<div class="info"></div>
						</form>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-author" role="tabpanel" aria-labelledby="nav-author-tab">
					titi
				</div>
			</div>
		</div>
		<br>
		<div class="card">
			<h5 id="headerForm" class="card-header text-white bg-success">
				Gérer son compte : changer son mot de passe, paramétrer des favoris, paramétrer ses listes prédéfinis, ...
			</h5>
			Ajouter / Supprimer / Modifier 
		</div>
