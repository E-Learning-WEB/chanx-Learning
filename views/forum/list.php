<?php
include $engine->config('koneksi');
?>
  <div class="header">
    <?php
		if(!isset($_GET['act']))
		{
			//jika tidak buka laman materi
             echo sprintf('<p class="right"><a href="%s">Lihat Semua</a></p>',$go->to('forum','list'));
		}
		else
		{
			echo $template->tombol($tombolproperti = array(
										'label' => 'Baru',
										'aksi' => 'tambahforumdiskusi',
										'style' => 'float:right;'
										));
		}
		?>
    <h2 class="text_b">Forum Diskusi</h2>
  </div> <!-- header -->
  
  <div class="header2">
    <div class="input-field s6">
      <form action="<?php echo $go->to('forum','list'); ?>" method="POST">
        <?php 
	 		echo $input->label('filter','filter');
			echo $input->text('filter','filter','','max-width: 200px;');
			?>
        <input class="btn white-text"  name="daftar" type="submit" value="filter">
      </form>
        </div> <!-- input field-->
  </div> <!-- header2 -->
  
  
<div class="row">
<?php
if(!isset($_GET['act']))
{
	$limit = 'LIMIT 6';
}
else
{
	$limit = NULL;
}

if(isset($_POST['filter'])){
	$sql = sprintf('SELECT * FROM tb_diskusi %s WHERE tipe = 1 AND judul = "%s"',$limit,$_POST['filter']);	
}
else
{
$sql = sprintf('SELECT * FROM tb_diskusi WHERE tipe = 1 %s',$limit);
}
$kueri = $db2->query($sql);
while($forum = $kueri->fetch())
{	
	echo $template->forumdiskusidaftar($forum);
}
?>

 </div><!--row-->
