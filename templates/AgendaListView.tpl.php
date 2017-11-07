<?php
	$this->assign('title','DBEXAMES | Agendas');
	$this->assign('nav','agendas');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/agendas.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> Agendas
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="agendaCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Datahora">Datahora<% if (page.orderBy == 'Datahora') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Nome">Nome<% if (page.orderBy == 'Nome') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Idexame">Idexame<% if (page.orderBy == 'Idexame') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Idpaciente">Idpaciente<% if (page.orderBy == 'Idpaciente') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Obs">Obs<% if (page.orderBy == 'Obs') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Resultado">Resultado<% if (page.orderBy == 'Resultado') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('datahora')) %>">
				<td><%if (item.get('datahora')) { %><%= _date(app.parseDate(item.get('datahora'))).format('MMM D, YYYY h:mm A') %><% } else { %>NULL<% } %></td>
				<td><%= _.escape(item.get('nome') || '') %></td>
				<td><%= _.escape(item.get('idexame') || '') %></td>
				<td><%= _.escape(item.get('idpaciente') || '') %></td>
				<td><%= _.escape(item.get('obs') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('resultado') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="agendaModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="datahoraInputContainer" class="control-group">
					<label class="control-label" for="datahora">Datahora</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="datahora" type="text" value="<%= _date(app.parseDate(item.get('datahora'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="datahora-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('datahora'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="nomeInputContainer" class="control-group">
					<label class="control-label" for="nome">Nome</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="nome" placeholder="Nome" value="<%= _.escape(item.get('nome') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="idexameInputContainer" class="control-group">
					<label class="control-label" for="idexame">Idexame</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="idexame" placeholder="Idexame" value="<%= _.escape(item.get('idexame') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="idpacienteInputContainer" class="control-group">
					<label class="control-label" for="idpaciente">Idpaciente</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="idpaciente" placeholder="Idpaciente" value="<%= _.escape(item.get('idpaciente') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="obsInputContainer" class="control-group">
					<label class="control-label" for="obs">Obs</label>
					<div class="controls inline-inputs">
						<textarea class="input-xlarge" id="obs" rows="3"><%= _.escape(item.get('obs') || '') %></textarea>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="resultadoInputContainer" class="control-group">
					<label class="control-label" for="resultado">Resultado</label>
					<div class="controls inline-inputs">
						<textarea class="input-xlarge" id="resultado" rows="3"><%= _.escape(item.get('resultado') || '') %></textarea>
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteAgendaButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteAgendaButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Agenda</button>
						<span id="confirmDeleteAgendaContainer" class="hide">
							<button id="cancelDeleteAgendaButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteAgendaButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="agendaDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Agenda
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="agendaModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveAgendaButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="agendaCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newAgendaButton" class="btn btn-primary">Add Agenda</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
