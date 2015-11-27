<?php
$tombol_menu_tool = $menu_tool = null;
if(isset($_GET['sub']))
{
	switch($_GET['sub'])
	{
		case 'materi':
		$menu_tool['tambahmateri'] = 1;
		break;
	}
}
?>
<?php
if(isset($menu_tool))
{
	if($menu_tool['tambahmateri'] == 1)
	{
		$tombol_menu_tool .= sprintf('<li><a href="%s" class="btn-floating blue"><i class="material-icons">mode_edit</i></a></li>',$go->to('materi','new'));
	}
}

echo $tombol_menu_tool;
?>


