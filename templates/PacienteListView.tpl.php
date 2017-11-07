<?php
	$this->assign('title','DBEXAMES | Pacientes');
	$this->assign('nav','pacientes');

	$this->display('_Header.tpl.php');
?>


<script type="text/javascript">

	$LAB.script("scripts/app/pacientes.js").wait(function(){
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
	<i class="icon-th-list"></i> Pacientes
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Procurar..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="pacienteCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Idpaciente">Idpaciente<% if (page.orderBy == 'Idpaciente') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Nome">Nome<% if (page.orderBy == 'Nome') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Datanasc">Data nascimento<% if (page.orderBy == 'Data nascimento') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Logradouro">Endereço<% if (page.orderBy == 'Endereço') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Numero">Numero<% if (page.orderBy == 'Numero') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_Bairro">Bairro<% if (page.orderBy == 'Bairro') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Cidade">Cidade<% if (page.orderBy == 'Cidade') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Uf">Uf<% if (page.orderBy == 'Uf') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('idpaciente')) %>">
				<td><%= _.escape(item.get('idpaciente') || '') %></td>
				<td><%= _.escape(item.get('nome') || '') %></td>
				<td><%if (item.get('datanasc')) { %><%= _date(app.parseDate(item.get('datanasc'))).format('MMM D, YYYY') %><% } else { %>NULL<% } %></td>
				<td><%= _.escape(item.get('logradouro') || '') %></td>
				<td><%= _.escape(item.get('numero') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('bairro') || '') %></td>
				<td><%= _.escape(item.get('cidade') || '') %></td>
				<td><%= _.escape(item.get('uf') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="pacienteModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idpacienteInputContainer" class="control-group">
					<label class="control-label" for="idpaciente">Idpaciente</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="idpaciente"><%= _.escape(item.get('idpaciente') || '') %></span>
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
				<div id="datanascInputContainer" class="control-group">
					<label class="control-label" for="datanasc">Data nascimento</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="datanasc" type="text" value="<%= _date(app.parseDate(item.get('datanasc'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="logradouroInputContainer" class="control-group">
					<label class="control-label" for="logradouro">Endereço</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="logradouro" placeholder="Endereço" value="<%= _.escape(item.get('logradouro') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="numeroInputContainer" class="control-group">
					<label class="control-label" for="numero">Numero</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="numero" placeholder="Numero" value="<%= _.escape(item.get('numero') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="bairroInputContainer" class="control-group">
					<label class="control-label" for="bairro">Bairro</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="bairro" placeholder="Bairro" value="<%= _.escape(item.get('bairro') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="cidadeInputContainer" class="control-group">
					<label class="control-label" for="cidade">Cidade</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="cidade" placeholder="Cidade" value="<%= _.escape(item.get('cidade') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="ufInputContainer" class="control-group">
					<label class="control-label" for="uf">Uf</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="uf" placeholder="Uf" value="<%= _.escape(item.get('uf') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deletePacienteButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deletePacienteButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Paciente</button>
						<span id="confirmDeletePacienteContainer" class="hide">
							<button id="cancelDeletePacienteButton" class="btn btn-mini">Cancelar</button>
							<button id="confirmDeletePacienteButton" class="btn btn-mini btn-danger">Confirmar</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="pacienteDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Editar Paciente
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="pacienteModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancelar</button>
			<button id="savePacienteButton" class="btn btn-primary">Salvar Alterações</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="pacienteCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newPacienteButton" class="btn btn-primary">Adicionar Paciente</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
