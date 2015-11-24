<div class="materi_list section scrollspy" id="materi">
<div class="container">
  <div class="header">
    <?php
		if(!isset($_GET['act']))
		{
			//jika tidak buka laman materi
             echo sprintf('<p class="right"><a href="%s">Lihat Semua</a></p>',$go->to('materi','list'));
		}
		else
		{
				echo $template->tombol($tombolproperti = array(
										'label' => 'Baru',
										'aksi' => 'tambahmateri',
										'style' => 'float:right;'
										));
		}
		?>
    <h2 class="text_b">Materi</h2>
  </div> <!-- header -->
  
  <div class="header2">
    <div class="input-field s6">
      <form action="<?php echo $go->to('materi','list'); ?>" method="POST">
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
include 'config/koneksi.php';
if(!isset($_GET['act']))
{
	$limit = 'LIMIT 4';
}
else
{
	$limit = NULL;
}

if(isset($_POST['filter'])){
	$sql = sprintf('SELECT * FROM tb_materi %s WHERE judul = "%s"',$limit,$_POST['filter']);	
}
else
{
$sql = sprintf('SELECT * FROM tb_materi %s',$limit);
}
$kueri = $db2->query($sql);
while($materi = $kueri->fetch())
{	
echo $template->materidaftar($materi);
?>
    <?php
}
?>
  </div><!--row-->
</div>
</div>