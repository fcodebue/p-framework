<div id="formapp_cdl" ng-app="generalApp">  
<div id="user-spinner" class="spinner"></div>
<div class="page-header">
  <h2><i class="fa fa-gear"></i> Impostazioni Generali</h2>
</div>
<ul id="calTab" class="nav nav-tabs">
	<li class="active" ><a href="#utenti" data-toggle="tab">Gestione Utenti</a></li>
	<li><a href="#clienti" data-toggle="tab">Gestione Clienti</a></li>
	<!-- <li><a href="#crudAziende" data-toggle="tab">Crud Aziende</a></li> -->
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="utenti" ng-controller="gUser">
    <?php include('w_utenti.php'); ?>
  </div>
  <div class="tab-pane" id="clienti" ng-controller="cUser">
    <?php include('w_clienti.php'); ?>
  </div>
</div>