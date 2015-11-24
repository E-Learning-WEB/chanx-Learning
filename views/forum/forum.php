<div class="row">
<?php

if(isset($_POST['balastopik']))
{
	$konten = $db->real_escape_string($_POST['konten']);
			$sql = sprintf("INSERT INTO tb_diskusi (fid,uid,tid,tipe,judul,konten,timestamp,publi) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",$engine->hashacak(16),$user['uid'] ,$_GET['hash'] , 0, $_POST['judul'], $konten, time(),1);
			$db->query($sql);
			echo "data disimpan: " . $db->affected_rows;
}

?>
<?php
	$sql = sprintf("SELECT * FROM tb_diskusi WHERE fid = '%s'",$_GET['hash']);
	$data = $db->query($sql);
	$topik = $data->fetch_assoc();
	$urutanpost = 1;
	
	
	$sql = sprintf("SELECT * FROM tb_pengguna WHERE uid = '%s'",$topik['uid']);
	$data = $db->query($sql);
	$pengguna = $data->fetch_assoc();
?>

    <header class="panel-heading sm bg-purple-gradient">
      <h2>
      <a href="?sub=forum&act=list"><i class="glyphicon glyphicon-arrow-left"></i></a>
       <?php echo $topik['judul'];?> </h2> 
      </header>
  
  <?php
  		//menampilkan topik	
  		echo $template->komentar(
		$template->parseuser($topik['uid']),
		$topik); 
  ?>
  

<?php
	$sql = sprintf("SELECT * FROM tb_diskusi WHERE tid = '%s' ORDER BY timestamp ASC",$_GET['hash']);
	$data = $db->query($sql);
	while($balasantopik = $data->fetch_assoc())
	{
	$urutanpost++;
	$sql = sprintf("SELECT * FROM tb_pengguna WHERE uid = '%s'",$balasantopik['uid']);
	$datapengguna = $db->query($sql);
	$pengguna = $datapengguna->fetch_assoc();
?>  
  <!-- reply -->
    <?php
  		//menampilkan balasan	
  		echo $template->komentar(
		$template->parseuser($balasantopik['uid']),
		$balasantopik); 
		
	}
	//end balasantopik
 ?> 
  
  
		<?php
	 	echo $template->inputdiskusi($diskusi=array(
										'tipe' => 'diskusi_balas'
								 ));

		?>
  
  
</div> <!-- row -->
