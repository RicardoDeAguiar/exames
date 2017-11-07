<?php
if (!GlobalConfig::$APP_ROOT) GlobalConfig::$APP_ROOT = realpath("./");

if (ini_get('asp_tags')) 
	die('<h3>Server Configuration Problem: asp_tags is enabled, but is not compatible with Savant.</h3>'
	. '<p>You can disable asp_tags in .htaccess, php.ini or generate your app with another template engine such as Smarty.</p>');

set_include_path(
		GlobalConfig::$APP_ROOT . '/libs/' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/../phreeze/libs' . PATH_SEPARATOR .
		GlobalConfig::$APP_ROOT . '/vendor/phreeze/phreeze/libs/' . PATH_SEPARATOR .
		get_include_path()
);

// $loader = require 'vendor/autoload.php';
// $loader->setUseIncludePath(true);

require_once "App/ExampleUser.php";

require_once 'verysimple/Phreeze/SavantRenderEngine.php';
GlobalConfig::$TEMPLATE_ENGINE = 'SavantRenderEngine';
GlobalConfig::$TEMPLATE_PATH = GlobalConfig::$APP_ROOT . '/templates/';

GlobalConfig::$ROUTE_MAP = array(

	// default controller when no route specified
	'GET:' => array('route' => 'Default.Home'),
		
	// example authentication routes
	'GET:loginform' => array('route' => 'SecureExample.LoginForm'),
	'POST:login' => array('route' => 'SecureExample.Login'),
	'GET:secureuser' => array('route' => 'SecureExample.UserPage'),
	'GET:secureadmin' => array('route' => 'SecureExample.AdminPage'),
	'GET:logout' => array('route' => 'SecureExample.Logout'),
		
	// Agenda
	'GET:agendas' => array('route' => 'Agenda.ListView'),
	'GET:agenda/(:any)' => array('route' => 'Agenda.SingleView', 'params' => array('datahora' => 1)),
	'GET:api/agendas' => array('route' => 'Agenda.Query'),
	'POST:api/agenda' => array('route' => 'Agenda.Create'),
	'GET:api/agenda/(:any)' => array('route' => 'Agenda.Read', 'params' => array('datahora' => 2)),
	'PUT:api/agenda/(:any)' => array('route' => 'Agenda.Update', 'params' => array('datahora' => 2)),
	'DELETE:api/agenda/(:any)' => array('route' => 'Agenda.Delete', 'params' => array('datahora' => 2)),
		
	// Exame
	'GET:exames' => array('route' => 'Exame.ListView'),
	'GET:exame/(:num)' => array('route' => 'Exame.SingleView', 'params' => array('idexame' => 1)),
	'GET:api/exames' => array('route' => 'Exame.Query'),
	'POST:api/exame' => array('route' => 'Exame.Create'),
	'GET:api/exame/(:num)' => array('route' => 'Exame.Read', 'params' => array('idexame' => 2)),
	'PUT:api/exame/(:num)' => array('route' => 'Exame.Update', 'params' => array('idexame' => 2)),
	'DELETE:api/exame/(:num)' => array('route' => 'Exame.Delete', 'params' => array('idexame' => 2)),
		
	// Medico
	'GET:medicos' => array('route' => 'Medico.ListView'),
	'GET:medico/(:num)' => array('route' => 'Medico.SingleView', 'params' => array('idmedico' => 1)),
	'GET:api/medicos' => array('route' => 'Medico.Query'),
	'POST:api/medico' => array('route' => 'Medico.Create'),
	'GET:api/medico/(:num)' => array('route' => 'Medico.Read', 'params' => array('idmedico' => 2)),
	'PUT:api/medico/(:num)' => array('route' => 'Medico.Update', 'params' => array('idmedico' => 2)),
	'DELETE:api/medico/(:num)' => array('route' => 'Medico.Delete', 'params' => array('idmedico' => 2)),
		
	// Paciente
	'GET:pacientes' => array('route' => 'Paciente.ListView'),
	'GET:paciente/(:num)' => array('route' => 'Paciente.SingleView', 'params' => array('idpaciente' => 1)),
	'GET:api/pacientes' => array('route' => 'Paciente.Query'),
	'POST:api/paciente' => array('route' => 'Paciente.Create'),
	'GET:api/paciente/(:num)' => array('route' => 'Paciente.Read', 'params' => array('idpaciente' => 2)),
	'PUT:api/paciente/(:num)' => array('route' => 'Paciente.Update', 'params' => array('idpaciente' => 2)),
	'DELETE:api/paciente/(:num)' => array('route' => 'Paciente.Delete', 'params' => array('idpaciente' => 2)),
		
	// Usuario
	'GET:usuarios' => array('route' => 'Usuario.ListView'),
	'GET:usuario/(:any)' => array('route' => 'Usuario.SingleView', 'params' => array('nome' => 1)),
	'GET:api/usuarios' => array('route' => 'Usuario.Query'),
	'POST:api/usuario' => array('route' => 'Usuario.Create'),
	'GET:api/usuario/(:any)' => array('route' => 'Usuario.Read', 'params' => array('nome' => 2)),
	'PUT:api/usuario/(:any)' => array('route' => 'Usuario.Update', 'params' => array('nome' => 2)),
	'DELETE:api/usuario/(:any)' => array('route' => 'Usuario.Delete', 'params' => array('nome' => 2)),

	// catch any broken API urls
	'GET:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'PUT:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'POST:api/(:any)' => array('route' => 'Default.ErrorApi404'),
	'DELETE:api/(:any)' => array('route' => 'Default.ErrorApi404')
);

/**
 * If you paste into a controller method, replace $G_PHREEZER with $this->Phreezer
 */
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("Agenda","FK_EXAME_AGENDA",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("Agenda","FK_MEDICO_AGENDA",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
// $GlobalConfig->GetInstance()->GetPhreezer()->SetLoadType("Agenda","FK_PAC_AGENDA",KM_LOAD_EAGER); // KM_LOAD_INNER | KM_LOAD_EAGER | KM_LOAD_LAZY
?>