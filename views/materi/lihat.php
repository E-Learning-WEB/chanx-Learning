<div id="work">

  <?php
	if(empty($_GET['hash']))
	{
		echo $error->code('e404');
		die;
	}
	include $engine->config('koneksi');
	
	
	if(!isset($_SESSION['username']))
	{
		$username = 'guest';
	}
	else
	{
		$username = $_SESSION['username'];
	}
	$sql = sprintf("SELECT kuota FROM tb_pengguna WHERE username = '%s'",$username);
	$data = $db->query($sql);
	$pengguna = $data->fetch_assoc();
	if($pengguna['kuota'] == NULL)
		{$kuotapengguna = 'unlimited';}
		else{$kuotapengguna = $pengguna['kuota'];}


	$sql = sprintf("SELECT * FROM tb_materi WHERE hash = '%s'",$_GET['hash']);
	$data = $db->query($sql);
	$jumlah_materi = $data->num_rows;	
	$materi = $data->fetch_assoc();
	$ukuran = number_format($materi['ukuranfile']/1000,2). ' KB';
	
    //mengambil extensi file
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$fileextensi = finfo_file($finfo, $materi['konten']); //berdasarkan MIME
//    $fileextensi = pathinfo($materi['konten'],PATHINFO_EXTENSION);     

	if(empty($materi['deskripsi']))
	{
		$materi['deskripsi'] = '<i>Tidak Ada Deskripsi Materi</i>';
	}
	
	//buat kunci untuk donlut
	$hashkunci = $engine->hashacak(16);
	$sql = sprintf("UPDATE `tb_pengguna` SET `kunci`= '%s' WHERE `username` = '%s'" ,$hashkunci.$materi['hash'],$username);
	$db->query($sql);
?>
  <div class="container">
    <div class="row">
      <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
        
        <?php
		if(!$fileextensi == 'video/mp4')
		{
		?>	
          <object data="materirender.php<?php echo sprintf('?hash=%s',$_GET['hash'])?>" width="100%" height="380px" style="display:block">
          </object>
         <?php
		 }
		 else
		 {
		 ?> 
          <video width="100%" height="380px" controls>
          <source src="<?php echo $materi['konten']?>" type="video/mp4">
	        Your browser does not support the video tag.
        </video>
          <?php
		 }
		 ?>
        </div>
        <div class="card-content" style="padding-bottom:0px;">
          <div class="header">
            <h2 style="display:inline"> <?php echo $materi['judul'];?></h2>
            <h2 class="right" style="margin:0">
              <?php 
				echo $template->tombol($tombolproperti = array(
										'label' => 'Edit',
										'aksi' => 'ubahmateri',
										'hash' => $materi['hash']));
		  	?>
              <a class="btn btn-default white-text tbl-download" data-toggle="modal" data-target="#md-donlot" href="">Download<br>
              (<?php echo $ukuran;?>)</a></h2>
          </div>
          <p><?php echo $materi['deskripsi']; ?></p>
        </div>
              </div>
        <hr />
        
        
        <section id="kirimkomentar" style="min-height:100px;">
		<?php
		$_SESSION['materi_hash'] = NULL;
		$_SESSION['materi_hash'] = $materi['hash'];
		echo $template->inputkomentar();
		?>
        </section>
		
        
        
		<section id="komentar" style="min-height:100px;">
         <?php
		 	$sql = sprintf("SELECT * FROM tb_diskusi WHERE tid = '%s' AND tipe = 2 ORDER BY timestamp DESC",$materi['hash']);
			$data = $db2->query($sql);
			$totaljumlahkomentar = $data->rowCount();
			
			$limit = 5;
			if(isset($_GET['offset'])){$offset = 'OFFSET '.$_GET['offset']*$limit;}
			else{$offset = 'OFFSET 0';}
		 	$sql = sprintf("SELECT * FROM tb_diskusi WHERE tid = '%s' ORDER BY timestamp DESC LIMIT %s %s",$materi['hash'],$limit,$offset);
			$data = $db2->query($sql);
			$jumlahkomentar = $data->rowCount();
				
			echo sprintf('
                   <h5 class="header" style="font-size:18px;">Komentar (%s dari %s)</h5>',$jumlahkomentar, $totaljumlahkomentar);
			echo '<div class="row" style="width:100%; margin:auto">';
			while($komentar = $data->fetch())
			{
				
				//komentar 
				$kutipan_pengguna = $template->parseuser($template->parent_to_uid($komentar['parent']));			
				$kutipan = array(
							'isi' => $komentar['kutipan'],
							'uid' => $kutipan_pengguna['uid'],
							'username' => $kutipan_pengguna['username']
				);
				 echo $template->komentar(
				 $template->parseuser($komentar['uid']),
				 $komentar,
				 $kutipan); 
			}
            ?>
           <?php
		   $daftarhalaman = array(
		   'totaljumlah' => $totaljumlahkomentar,
		   'offset' => $offset,
		   'limit' => $limit
		   );
		   echo $template->daftarhalaman($daftarhalaman,'style=padding-left:10%;');
		   ?>
           </div>
        </section>
    </div>
  </div>
</div>
