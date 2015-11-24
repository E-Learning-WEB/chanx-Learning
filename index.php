<?php
session_start();
define('CHANX',TRUE);
include 'config/config.php';
include 'functions/login.php';
include 'functions/perizinan.php';
include 'functions/template.php';
include 'views/common/head.php';

if(!isset($_GET['sub']))
{	
	include 'views/common/depan.php';
}
else
{
	switch($_GET['sub'])
	{
		case 'test':
		include $engine->view('common/test');
		break;
		case 'proses':
		include $engine->view('common/proses');
		break;
		case 'login':
		include $engine->view('user/login');
		break;
		case 'register':
		include $engine->view('user/register');
		break;
		case 'diskusi':
		include $engine->view('diskusi/index');
		break;		
		case 'materi':
		include $engine->view('materi/index');
		break;
		case 'forum':
		include $engine->view('forum/index');
		break;		
		case 'profil':
		include $engine->view('user/profil/index');
		break;				
	}
}

include 'views/common/footer.php';

	
?>