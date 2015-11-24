<?php
	switch($_GET['act'])
	{
		case 'lihat':
		include $engine->view('materi/lihat');
		break;
		case 'list':
		include $engine->view('materi/list');
		break;
		case 'baru' OR 'edit':
		include $engine->view('materi/manipulasi');
		break;
		default:
		echo $error->code('404');
		
	}