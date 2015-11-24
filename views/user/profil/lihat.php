<?php
		if(isset($_GET['hash']))
		{
			$sql = sprintf('SELECT * FROM tb_pengguna WHERE username = "%s"',$_GET['hash']);
			$data = $db2->query($sql);
			$profil = $data->fetch();
//			var_dump ($profil);
		}
		else
		{
			echo $error->code(404);
			die;
		}
?>
<div class="container">
		<div class="row center" style="padding-top:10px;">
        <?php
						echo $template->tombol($tombolproperti = array(
										'label' => 'Ubah',
										'aksi' => 'ubahakun',
										'style' => 'float:right;',
										'hash' => $_GET['hash']
										));

		?>
        	<div class="col-md-12">
			 <img alt="" src="<?php echo random_gravatar('180', $profil['email']); ?>" class="circle" style="max-width:1800px; border:5px #edece5 solid;">
             </div>
             <div class="col-md-12">
             <h5 class="header"><?php echo $profil['displayname']; ?></h5>
             <p><b>@<?php echo $profil['username'];?></b></p>
             <p><i><?php echo $profil['tentang'];?></i></p>
             <p><i>Lokasi : <?php echo $profil['alamat'];?></i></p>
             <i class="glyphicon glyphicon-comment btn"></i>
             <i class="glyphicon glyphicon-heart btn merahhati"></i>
             </div>
		</div>
    
</div>