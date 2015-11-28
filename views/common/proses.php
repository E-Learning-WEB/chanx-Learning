
<div class="container" style="padding:20px;">
  <?php
 $pesan  = null; 
  
if(isset($_POST['daftar']))
{
	include $engine->config('koneksi');
	
	//validasi
		//username
		if(empty($_POST['username']) AND 
			empty($_POST['password']) AND
			empty($_POST['password']) AND
			empty($_POST['password2']) AND			
			empty($_POST['display_name']))
			{
				echo 'Mohon Isi semua form';
				die;
			}
		else
		{
			$registrasi = array(
			'username' => $_POST['username'],
			'password' => md5($_POST['password']),
			'password2' => md5($_POST['password2']),
			'jumlahpassword' => strlen($_POST['password']),
			'email' => $_POST['email'],
			'display_name' => $_POST['display_name']
			);
			
			//validasi
			//username
			$sql = sprintf('SELECT username FROM tb_pengguna WHERE username = "%s"',$registrasi['username']);			
			$data = $db2->query($sql);				
			if($data->rowCount() == 1)
			{
				echo 'username sudah ada';
				die;
			}
			
			//sandi
			if($registrasi['password'] === $registrasi['password2'])
			{
				//cek jumlah password
				if($registrasi['jumlahpassword'] < $akun['minpassword'])
				{
					echo sprintf('kata sandi minimal 6 karakter ',$akun['minpassword']);	
					die;
				}
			}
			else
			{				
				echo 'kata sandi tidak sama';
				die;
			}
		}//End VALIDASI
		
			
			$sql = sprintf('INSERT INTO tb_pengguna (username,password,email,displayname) values("%s","%s","%s","%s")',
				$registrasi['username'],$registrasi['password'],$registrasi['email'],$registrasi['display_name']
			);
			$data = $db->query($sql);
			if($data->rowCount()==1)
			{
				$pesan ='sukses';
			}

		
}//END DAFTAR PROSES


//MULAI PROSES MANIPULASI MATERI
if(isset($_POST['materibaru']))
{
	$id_materi = $engine->hashacak();
	$folderupload = 'uploads/'; 
	$waktuupload = time();
	//contoh nama file yang diupload '87-171-1-SM.pdf'
	// nama file (asli) = 87-171-1-SM.pdf yang diupload
	$originalfile =  basename($_FILES["fileToUpload"]["name"]); 
	
	$simpanfile = $waktuupload.'_'.md5($originalfile); //nama filedienkripsi 1448173768_9d43b5edbe14f5371c8d1edb6672cc31
	$original = 'uploads/'.$originalfile; 
	
	//target file yg akan disimpan keserver 'uploads/9d43b5edbe14f5371c8d1edb6672cc31'
	$target = 'uploads/'.$simpanfile; 
	
	$nama_input = 'fileToUpload'; //nama form 
	
	//lokasi+nama file yg diupload sementara (mentah)
	$tmp_name = $_FILES[$nama_input]["tmp_name"]; 
	
	//mengambil extensi file
	$extensi_belakang = pathinfo($original,PATHINFO_EXTENSION); 	
	
	//mulai validasi
	$pesan = $error = null;
	
	//mulai validasi filetype
	if(!(strtoupper($extensi_belakang) == 'PDF' ||
		strtoupper($extensi_belakang) == 'DOCX' ||
		strtoupper($extensi_belakang) == 'MP4'))
	{
		$error .= '- Tipe File tidak diperbolehkan';
	}
	
	//mulai validasi ukuran
	if($_FILES[$nama_input]['size'] == 0 )
	{
		$error .= '- Ukuran File tidak diperbolehkan';	
	}
	
	//akhir validasi
	
	if(empty($error))
	{
		$hash = $db2->quote($id_materi);
		$judul = $db2->quote($_POST['judul']);
		$deskripsi = $db2->quote($_POST['deksripsi']);
		$kelas = $db2->quote($_POST['kelas']);
		$urutan = $db2->quote($_POST['urutan']);		
		$konten = $db2->quote($target);
		$checksum = $db2->quote(md5_file($tmp_name));
		$ukuran = $_FILES[$nama_input]['size'];
		$sql = "INSERT INTO tb_materi
					(hash,judul,deskripsi,kelas,urutan,konten,checksum,waktuupload,ukuranfile,diskusi) 
					values($hash,$judul,$deskripsi,$kelas,$urutan,$konten,$checksum,$waktuupload,$ukuran,1)";
		$data = $db2->query($sql);
		$data->execute();
		if($data->rowCount = 1)
		{
			move_uploaded_file($tmp_name, $target);	
			$pesan .= 'Materi Telah ditambahkan';
		}
		else
		{
			$pesan .= 'Terjadi Kesalahan Fatal, File tidak tersimpan didatabase';
		}
	}
	else
	{
		$pesan .= $error;
	}
	
}


if(isset($_GET['aksi']))
{
	//mengambil data record yang telah ada didatabase
	$datamateri = $db2->prepare('SELECT * FROM tb_materi WHERE hash = (:hash)');
	$datamateri->bindValue(':hash', $_GET['hash']);
	$datamateri->execute();
	
	//periksa jika data ada
	if($datamateri->rowCount() == 1)
	{	
		foreach($datamateri as $recordmateri);		
		//mulai hapus file
		if (!unlink($recordmateri['konten']))
		  {
			  $pesan .= "FIle Gagal dihapus";
			  $error = 1;
		  }
		else
		  {
			  $pesan .=  "File Dihapus";
		  }
		
		//mulai hapus dari database
		if(isset($error))
		{
			$datamateri = $db2->prepare('DELETE FROM tb_materi WHERE hash = (:hash)');
			$datamateri->bindValue(':hash', $_GET['hash']);
			$datamateri->execute();
			if($datamateri->rowCount() == 1)
			{
				$pesan .= 'Berhasil dihapus dari database';
			}
			else
			{
				$pesan .= 'gagal dihapus dari database';
			}
		}//hapus dari databse
	}//periksa data
	else
	{
		$pesan .= 'ERROR, terjadi kesalahan, kemungkinan data telah terhapus dari database';
	}
	
} //akhir hapus materi



//akhir materimanipulasi

if(isset($_POST['kirimkomentar']))
{
	include $engine->config('koneksi');
	$isikomentar = $db2->quote($_POST['isikomentar']);
	$sql = sprintf('INSERT INTO 
					tb_diskusi (fid,uid,tid,tipe,konten,timestamp,publikasi) 
					values("%s","%s","%s",2,%s,"%s",2)',
					$engine->hashacak(16,1),$_SESSION['uid'],$_SESSION['materi_hash'],$isikomentar,time()
					);			
	echo $sql;				
	$data = $db2->query($sql);
	if($data->rowCount() == 1)
	{
		$pesan = 'Komentar telah diterima';
		//$redirect = header("refresh:5;url=".$go->to('materi','lihat',$_SESSION['materi_hash']));
	}
	$_SESSION['materi_hash'] = NULL;
}

//proses pada diskusi (forum)
if(isset($_POST['diskusibaru']))
{
	include $engine->config('koneksi');
	$judul = $db2->quote($_POST['judul']);
	$isi = $db2->quote($_POST['isi']);
	$id_diskusi = $engine->hashacak(16,1);
	$sql = sprintf('INSERT INTO 
					tb_diskusi (fid,uid,tid,tipe,judul,konten,timestamp,publikasi) 
					values("%s","%s","%s",1,%s,"%s","%s",2)',
					$id_diskusi,$_SESSION['uid'],null,$judul,$isi,time()
					);			
	$data = $db2->query($sql);
	if($data->rowCount() == 1)
	{
		$pesan = 'Forum telah dikirim';
		$redirect = header("refresh:5;url=".$go->to('forum','lihat',$id_diskusi));
	}
} //diskusi baru

if(isset($_POST['diskusi_balas']))
{
	include $engine->config('koneksi');
	$isi = $db2->quote($_POST['isi']);
	$id_diskusi = $engine->hashacak(16,1);
	$tid = $_POST['tid'];
	$sql = sprintf('INSERT INTO 
					tb_diskusi (fid,uid,tid,tipe,judul,konten,timestamp,publikasi) 
					values("%s","%s","%s",0,"%s","%s","%s",2)',
					$id_diskusi,$_SESSION['uid'],$tid,null,$isi,time()
					);			
	$data = $db2->query($sql);
	echo '<br>';
	echo $sql;
	if($data->rowCount() == 1)
	{
		$pesan = 'Balasan Telah Dikirim';
		$redirect = header("refresh:5;url=".$go->to('forum','lihat',$tid));
	}
} //diskusi baru


if(isset($_POST['balasdiskusi']))
{
	include $engine->config('koneksi');
	$id_diskusi = $engine->hashacak(16,1);
	$isikomentar = $db2->quote($_POST['isikomentar']);
	$kutipan = $db2->quote($_SESSION['kutipan']);
	$tid = $_SESSION['tid'];
	
	//mendeteksi tipe dari balasan
	$sql =  sprintf('SELECT tipe FROM tb_diskusi WHERE fid = "%s"',$_SESSION['diskusi_hash']);
	$data = $db2->query($sql);
	$tipe = $data->fetch();
	$tipe = $tipe['tipe'];
	echo $sql;
	echo 'hola = '.$tipe . '<br>';
	if($tipe = 0)
	{
		$tipebalasan = 0; //tipe reply forum
	}
	else
	{
		$tipe = 2;
	}
	
	
	$sql = sprintf('INSERT INTO 
					tb_diskusi (fid,uid,tid,parent,tipe,konten,timestamp,publikasi,kutipan) 
					values("%s","%s","%s","%s",%s,%s,"%s",0,"%s")',
					$id_diskusi,$_SESSION['uid'],$tid,$_SESSION['diskusi_hash'],$tipebalasan,$isikomentar,time(),$kutipan
					);			
	$data = $db2->query($sql);
	echo $sql;
	if($data->rowCount() == 1)
	{
		$pesan = 'Komentar telah diterima';
		$sql = sprintf('SELECT * FROM tb_diskusi WHERE fid = "%s"',$id_diskusi);
		$data = $db2->query($sql);
		$diskusi = $data->fetch();
		if($diskusi['tipe'] == 0){$sub = 'forum';}else{$sub='materi';}
			//$redirect = header("refresh:5;url=".$go->to($sub,'lihat',$diskusi['tid']));
		echo '<br>'.$diskusi['tid'];
	}
	$_SESSION['diskusi_hash'] = NULL;
}




//user
if(!empty($_GET['act']) AND !empty($_GET['hash']))
{
	if($_GET['act'] == 'hapususer')
	{
		$sql = sprintf('DELETE FROM tb_pengguna WHERE uid= "%s"',$_GET['hash']);
		$data = $db2->query($sql);
		echo $sql;
			$pesan = 'User Berhasil dihapus';

	}
}

if(isset($_POST['ubahprofil']))
{
	$password = md5($_POST['password']);
	$sql = "SELECT * FROM tb_pengguna WHERE username='$_POST[username]' AND password='$password'";
	$data = $db2->query($sql);
	if($data->rowCount() == 1)
	{
		$sql = "UPDATE tb_pengguna SET displayname = '$_POST[displayname]',
										alamat = '$_POST[alamat]',
										email = '$_POST[email]',
										jeniskelamin = '$_POST[jeniskelamin]'
										WHERE username = '$_POST[username]'
										";
		$db2->query($sql);
	}
	$redirect = header("refresh:5;url=".$go->to('profil','lihat',$_POST['username']));
	$pesan = 'mengubah profil';
}




if(!empty($pesan))
{
echo $pesan;
}
if(!empty($redirect))
{
	//echo $redirect;
	echo 'xxx';
}
?>


<div class="pesan_proses" style="margin:auto; width:100%;">
  <div class="preloader-wrapper big active" style="margin:2% 12%;">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>
</div>
</div>
