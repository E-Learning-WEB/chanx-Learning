<div class="section scrollspy" id="work">
    <div class="container">
<?php 
//artikel.php
if(isset($_GET['act']))
{
	switch($_GET['act'])
	{
		case 'list':
		include 'list.php'; break;
		case 'lihat':
		include 'forum.php'; break;
		case 'baru' OR 'edit':	
		include 'manipulasi.php'; break;
	}	
}
else{
		include 'common/error.php';
	}
?>
</div>
</div>