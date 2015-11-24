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
		$tombol_menu_tool .= '<li><a class="btn-floating blue"><i class="material-icons">mode_edit</i></a></li>';
	}
}

echo $tombol_menu_tool;
?>


