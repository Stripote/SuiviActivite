<br>
<div id="info"></div>

<div class="row">
	<div class="col-md-6">
		<div class="card text-center">
		  <h5 id="headerForm" class="card-header text-white bg-info">Statistiques générales</h5>
		  <div class="card-header">
			<div class="nav nav-tabs" id="nav-tab" role="tablist">
				<a class="nav-item nav-link active" id="nav-global-tab" data-toggle="tab" href="#nav-global" role="tab" aria-controls="nav-global" aria-selected="true">Global</a>
				<a class="nav-item nav-link" id="nav-level-tab" data-toggle="tab" href="#nav-level" role="tab" aria-controls="nav-level" aria-selected="false">Par types</a>
				<a class="nav-item nav-link" id="nav-type-tab" data-toggle="tab" href="#nav-type" role="tab" aria-controls="nav-type" aria-selected="false">Par niveau</a>
			</div>
		  </div>
		  <div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-global" role="tabpanel" aria-labelledby="nav-global-tab">
				<a title="Exporter comme image" id="global1Btn" download="export.png" class="fa fa-download float-right btn"></a>
				<canvas id="global1" width="100" height="100"></canvas>
			</div>
			
			<div class="tab-pane fade" id="nav-level" role="tabpanel" aria-labelledby="nav-level-tab">
				<a title="Exporter comme image" id="global2Btn" download="export.png" class="fa fa-download float-right btn"></a>
				<canvas id="global2" width="100" height="100"></canvas>
			</div>
			
			<div class="tab-pane fade" id="nav-type" role="tabpanel" aria-labelledby="nav-type-tab">
				<a title="Exporter comme image" id="global3Btn" download="export.png" class="fa fa-download float-right btn"></a>
				<canvas id="global3" width="100" height="100"></canvas>
			</div>
			
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card text-center">
		  <h5 id="headerForm" class="card-header text-white bg-info">Statistiques personnelles
			<?php
				if($_SESSION['connectedLogin'] == 'cmagloire'){
					echo '<span id="toggleChartsSuject" class="float-right"><select class="form-control"><option selected></option>';
					chargerMembres();
					echo '</select></span>';
				}
			?>
		  </h5>
		  <div class="card-header">
			<div class="nav nav-tabs" id="nav-tab" role="tablist">
				<a class="nav-item nav-link active" id="nav-perso1-tab" data-toggle="tab" href="#nav-perso1" role="tab" aria-controls="nav-perso1" aria-selected="true">Global</a>
				<a class="nav-item nav-link" id="nav-perso2-tab" data-toggle="tab" href="#nav-perso2" role="tab" aria-controls="nav-perso2" aria-selected="false">Par types</a>
				<a class="nav-item nav-link" id="nav-perso3-tab" data-toggle="tab" href="#nav-perso3" role="tab" aria-controls="nav-perso3" aria-selected="false">Par niveau</a>
			</div>
		  </div>
		  <div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-perso1" role="tabpanel" aria-labelledby="nav-perso1-tab">
				<a title="Exporter comme image" id="personnal1Btn" download="export.png" class="fa fa-download float-right btn"></a>
				<canvas id="personnal1" width="100" height="100"></canvas>
			</div>
			
			<div class="tab-pane fade" id="nav-perso2" role="tabpanel" aria-labelledby="nav-perso2-tab">
				<a title="Exporter comme image" id="personnal2Btn" download="export.png" class="fa fa-download float-right btn"></a>
				<canvas id="personnal2" width="100" height="100"></canvas>
			</div>
			
			<div class="tab-pane fade" id="nav-perso3" role="tabpanel" aria-labelledby="nav-perso3-tab">
				<a title="Exporter comme image" id="personnal3Btn" download="export.png" class="fa fa-download float-right btn"></a>
				<canvas id="personnal3" width="100" height="100"></canvas>
			</div>
			
		  </div>
		</div>
	</div>
</div>
