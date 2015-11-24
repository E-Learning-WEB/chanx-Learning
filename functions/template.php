<?php
include $engine->config('koneksi');
class template{
	public function tombol($tombolproperti)
	{
		if(empty($tombolproperti['label'])){$tombolproperti['label']=null;}
		if(empty($tombolproperti['label_class'])){$tombolproperti['label_class']=null;}
		if(empty($tombolproperti['class'])){$tombolproperti['class']=null;}
		if(empty($tombolproperti['style'])){$tombolproperti['style']=null;}
		global $izin,$input,$go;
		switch($tombolproperti['aksi'])
		{
			case 'tambahmateri':
			$href = $go->to('materi','baru'); break;
			case 'ubahmateri':
			$href = $go->to('materi','ubah',$tombolproperti['hash']); break;	
			case 'tambahforumdiskusi':
			$href = $go->to('forum','baru'); break;
			case 'ubahforumdiskusi':
			$href = $go->to('forum','ubah',$tombolproperti['hash']); break;
			case 'ubahakun':
			$href = $go->to('profil','ubah',$tombolproperti['hash']); break;
		}
		
		if(empty($tombolproperti['tipe'])){
			if($izin[$tombolproperti['aksi']] == 1)
			{
				$tombol = $input->button($tombolproperti['label'],$href,$tombolproperti['label_class'],$tombolproperti['style']);
			}
			else{
			$tombol = null;
			}
		}
		else
		{
			if($izin[$tombolproperti['aksi']] == 1)
			{
				$tombol = $input->link($link = array(
													'href' => $href,
													'label' => $tombolproperti['label'],
													'style' => $tombolproperti['style']
													));
			}
			else{
			$tombol = null;
			}
		}
		return $tombol;
	}



//MATERI 
public function materidaftar($materi){
	global $go,$template;
	if(strlen($materi['judul']) >= 9){
		$str = substr(strip_tags($materi['judul']), 0, 9) . ' ...';								
		}
		else{$str = $materi['judul'];
		}
	if(empty($materi['deskripsi']))
	{
		$materi['deskripsi'] = '<em>Tidak Ada Deskripsi Materi</em>';
	}
	$daftarmateri = sprintf('
	<div class="col s12 m3">
        <div class="card">
		
          <div class="card-image waves-effect waves-block waves-light" style="width:200px; margin:auto;"> 
		  	<img class="activator" src="img/materi.png"> 
		  </div>
		  
          <div class="card-content"> 
		  	<span class="card-title activator grey-text text-darken-4">
		  		%s<i class="mdi-navigation-more-vert right"></i>
			</span>
           <p>
		   <a href="%s">Lihat</a>
            </p>
          </div>
		  
          <div class="card-reveal">
            <p>%s<a href="%s">Lihat</a></p>
            <span class="card-title grey-text text-darken-4">%s<i class="mdi-navigation-close right"></i></span>
            <p>%s</p>
          </div>
		  
        </div> <!-- CARD-->
      </div>',
	  		//judul kartu depan
			$str,
			//link lihat materi depan
			$go->to('materi','lihat',$materi['hash']),
			//tombol edit belakang
			$template->tombol($tombolproperti = array(
												'label' => 'Ubah', 
												'style' => 'style="float:right"',
												'aksi' => 'ubahmateri', 
												'hash' => $materi['hash'],
												'tipe' => 'link'
												)),
			//tobol lihat belakang									
			$go->to('materi','lihat',$materi['hash']),
			//judul kartu depan
			$materi['judul'],
			//deskripsi kartu belakang
			$materi['deskripsi']);
	return $daftarmateri;
}
//akhir template materi

//template buat forum 
public function forumdiskusidaftar($forum){
	global $go,$template;
	if(strlen($forum['judul']) >= 16){
		$str = substr(strip_tags($forum['judul']), 0, 14) . ' ...';								
			}
		else{$str = $forum['judul'];}
						
	if(empty($materi['deskripsi']))
	{
		$materi['deskripsi'] = '<em>Tidak Ada Deskripsi Materi</em>';
	}
	$daftarforumdiskusi = sprintf('
	<div class="row">
        <div class="card">  
          <div class="card-content"> 
		  	<span class="card-title activator grey-text text-darken-4">
		  		%s<i class="mdi-navigation-more-vert right"></i>
			</span>
			
			<div>
			  <span style="font-size:small; display:block;">Dimulai Oleh: %s</span>
		      <time><i class="fa fa-clock-o"></i> %s</time>	   
			</div>
           <p>		   
		   <a href="%s">Lihat</a>
			%s
            </p>
          </div>
		  
          <div class="card-reveal">
            <p><a href="%s">Lihat</a></p>
            <span class="card-title grey-text text-darken-4">%s<i class="mdi-navigation-close right"></i></span>
            <p>%s</p>
          </div>
		  
        </div> <!-- CARD-->
      </div>',
			$str,
			$template->parseuser($forum['uid'],'displayname'),
			date('l jS @H:i ',$forum['timestamp']),
			$go->to('forum','lihat',$forum['fid']),
			$template->tombol($tombolproperti = array(
										'label' => 'Ubah',
										'aksi' => 'ubahforumdiskusi',
										'hash' => $forum['fid'],
										'style' => 'style="float:right;"',
										'tipe' => 1
										)),			
			$go->to('materi','lihat',$forum['fid']),
			$forum['judul'],
			$forum['konten']);
	return $daftarforumdiskusi;
}

	
	public function parseuser($uid,$datayangdiambil = null){
		global $db2;
		if(empty($datayangdiambil)){$ambil_field = '*';}
		else{$ambil_field = $datayangdiambil;}
		$sql = sprintf("SELECT %s FROM tb_pengguna WHERE uid = '%s'",$ambil_field,$uid);
		$data = $db2->query($sql);
		$parseuser = $data->fetch();
		
		if(!empty($datayangdiambil))
		{
			$parseuser = $parseuser[$datayangdiambil];
		}
		return $parseuser;
	}
	
	public function kotaklistpengguna($user)
	{
		global $go;
		$gravatar = random_gravatar('280', $user['email']);
		$kotaklistpengguna = sprintf('
			<div class="col s12 m3">
            <div class="card">
			  <div class="card-image waves-effect waves-block waves-light" >
                        <img class="activator" src="%s"" height="200px">
                    </div>
					
              <div class="card-content">
			  
                        <span class="card-title activator grey-text text-darken-4">
                        <i class="mdi-navigation-more-vert right"></i></span>		
								
                <p>%s (%s)</p>
				
					
				  <div class="card-footer">
					<a href="%s">Lihat Profil</a>	
					<a class="right" href="%s">Hapus</a>	
				  </div>
              </div>
			  
			   <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">Informasi Pengguna <i>(%s)</i><i class="mdi-navigation-close right"></i></span>
						<br>
                        <p>Nama : %s</p>
						<p>Username : %s</p>
						<p>Email : %s</p>
						<p>Alamat : %s</p>
						<p>Status : %s</p>												
                    </div>
            </div>
			</div>
		',$gravatar,
		$user['displayname'],
		$user['username'],
		$go->to('profil','lihat',$user['username']),
		$go->to('proses','hapususer',$user['uid']),
		$user['username'],
		$user['displayname'],
		$user['username'],
		$user['email'],
		$user['alamat'],
		$user['status']
		
		);
		
		return $kotaklistpengguna;
	}
	
	
	public function inputkomentar()
	{
	global $go,$izin,$db2,$template;
	
	
	$balasan_komentar_konten  = $msg = $disable = NULL;
	if($izin['kirimkomentarmateri'] == 0)
	{
	$disable = 'disabled="disable"';
	$msg = 'Anda Harus Login Untuk dapat memberi komentar';
	}
	
	
	if(!empty($_GET['balaskomentar']))
	{
		//ambil data balas komentar
		$sql = sprintf('SELECT * FROM tb_diskusi WHERE fid= "%s"',$_GET['balaskomentar']);
		$data = $db2->query($sql);
		$balasan_komentar = $data->fetch();
		$balasan_komentar_konten = sprintf('
		<blockquote> Membalas Komentar : %s
		
		%s
		</blockquote>
		',
		$template->parseuser($balasan_komentar['uid'],'username'),
		$balasan_komentar['konten']);
	}
	
	
	$inputkomentar = sprintf('          
	<h5 class="header" style="margin-top:-25px">Kirim Komentar</h5>
          <div class="row" style="padding-left:10%%;padding-right:10%%;">
            <form action="%s" method="post">
              <div class="form-group">
                <textarea class="form-control" %s
				 name="isikomentar"  rows="5"  data-provide="markdown" data-hidden-buttons="cmdHeading">%s</textarea>
                <div class="lainnya" style="display:block;">
                  <button class="btn btn-default lainnya" type="submit" name="kirimkomentar" %s>Kirim</button>
				  %s
                </div>
              </div>
            </form>
          </div>',
		  $go->to('proses'),
		  $disable,
		  $balasan_komentar_konten,
  		  $disable,
		  $msg
		  );
		  return $inputkomentar;
	}

	
	public function komentar($user,$komentar,$kutipan = null){
		global $Parsedown;
		global $go,$db2,$izin;
		if(!empty($kutipan['isi']))
		{
			$kutipan = sprintf('<pre class="kutipan"><p>Balasan dari <a href="%s">%s</a> > <a href="#komentar-%s">(lihat komentar asli)</a> <p> %s </pre>',
			$go->to('profil','lihat',$kutipan['uid']),
			$kutipan['username'],
			$komentar['parent'],
			$Parsedown->text($kutipan['isi']));
			$komentar['konten'] = $kutipan . $komentar['konten'];
		}
		$komentar = sprintf('
	<div class="row" id="komentar-%s">
        <div class="col-sm-2 full-10" style="width:60px; padding-top:20px;">
		    <div class="komentar_pengguna">
				<img src="%s" class="circle">
			</div>
		</div>

		<div class="col-sm-7 full-90">
            <div class="card">
				<h6 class="komenheader"><p class="namakomentar">
				<a href="%s">%s</a></p> mengomentari pada %s
				</h6>
              <div class="card-content komenkonten">
                <p>%s</p>
              </div>
			  <div class="komenfooter">
			  <a href="%s"><i class="fa fa-reply"> Balas</i></a>
			  </div>
            </div>
		</div>
	</div>	
		',
		$komentar['fid'],
		random_gravatar('50', $user['email']),		
		$go->to('profil','lihat',$user['username']),
		$user['username'],
		date('l jS  F Y h:i A',$komentar['timestamp']),
		$Parsedown->text($komentar['konten']),
		$go->to($_GET['sub'],'lihat',$_GET['hash'].'&balaskomentar='.$komentar['fid'].'#balas')
		//$go->to('diskusi&tid='.$_GET['hash'],'balas',$komentar['fid']).'#balas'
		);
		
		return $komentar;
	}
		
	//fungsi yang digunakan untuk mengambil data UID dari tid yang dibalas
	// dengan cara : ambil tid user yang dibalas -> ambil uid
	public function parent_to_uid($parent)
	{
		global $go,$db2;		
		$sql = sprintf('SELECT uid FROM tb_diskusi WHERE fid = "%s"',$parent);
		$data = $db2->query($sql);
		$diskusi_balasan_ambiluid = $data->fetch();
		return $diskusi_balasan_ambiluid['0'];
	}
	
	
	public function inputdiskusi($diskusi = null)
	{
	global $go,$izin,$input,$db2,$template;
	
	$konten_judul = $konten_isi = $msg = $disable = NULL;
	if($izin['kirimkomentardiskusi'] == 0)
	{
	$disable = 'disabled="disable"';
	$msg = 'Anda Harus Login Untuk dapat memberi komentar';
	}
	
	//deklarasi varibale input diskusi

	$input_judul  = $balasan_komentar_konten =$balasan_komentar = $thread_id = $input_name = null;
	if(!empty($diskusi))
	{
		if($diskusi['tipe'] == 'diskusibaru')
		{
			$input_judul = $input->label('judul','Judul Forum Diskusi','active'); 
			
			if($_GET['act'] == 'baru')
			{
				$input_judul .= "\n".$input->text('judul','judul','validate valid','','value="'.$konten_judul.'"');
			}
			$input_name = $diskusi['tipe'];
		}
		elseif($diskusi['tipe'] == 'diskusi_balas')
		{
			$input_name = $diskusi['tipe'];
			$thread_id = "<input type='hidden' value='$_GET[hash]' name='tid'>";
		}
	}
	
	//jika ubah diskusi
	if($_GET['act'] == 'ubah')
	{
		$sql = sprintf('SELECT * FROM tb_diskusi WHERE fid = "%s"',$_GET['hash']);
		$data = $db2->query($sql);
		$dataeditforumdiskusi = $data->fetch();
		$konten_judul = $dataeditforumdiskusi['judul'];
		$konten_isi = $dataeditforumdiskusi['konten'];
		$input_judul .= "\n".$input->text('judul','judul','validate valid','','value="'.$konten_judul.'"');
	}
	
	
	if(!empty($_GET['balaskomentar']))
	{
		//ambil data balas komentar
		$sql = sprintf('SELECT * FROM tb_diskusi WHERE fid= "%s"',$_GET['balaskomentar']);
		$data = $db2->query($sql);
		$balasan_komentar = $data->fetch();
		$balasan_komentar_konten = sprintf('
		<blockquote> Membalas Komentar : %s
		
		%s
		</blockquote>
		',
		$template->parseuser($balasan_komentar['uid'],'username'),
		$balasan_komentar['konten']);
		
		$konten_isi = $balasan_komentar_konten;
	}
	
	$inputdiskusi = sprintf('          
          <div id="balas" class="row" style="padding-left:10%%;padding-right:10%%;">
            <form action="%s" method="post">
              <div class="form-group">
			     %s
				 %s
                <textarea class="form-control" %s
				 name="isi"  rows="5"  data-provide="markdown" data-hidden-buttons="cmdHeading">%s</textarea>
                <div class="lainnya" style="display:block;">
                  <input class="btn btn-default lainnya" type="submit" name="%s" %s value="Kirim">
				  %s
                </div>
              </div>
            </form>
          </div>',
		  $go->to('proses'), //form action
		  $input_judul,
		  $thread_id,
		  $disable, //disable untuk textarea
		  $konten_isi,
		  $input_name, 
  		  $disable, //disable untuk input
		  $msg
		  );
		  return $inputdiskusi;
	}
	
	
	public function daftarhalaman($nilai,$style = null)
	{	
		global $go;
		
		$urloffset = $go->to('materi','lihat',$_GET['hash']).'&offset=';
		
		//untuk membuat aktif offset
		if(isset($_GET['offset']))
		{
			$offset_nilai = $_GET['offset'];
		}
		else
		{
			$offset_nilai = 0;
		}
		//mencari daftar halaaman agar dibagikan dengan offset
		$daftarhalaman_halaman = ceil($nilai['totaljumlah']/$nilai['limit']); //bulatkan
		$daftarhalaman = sprintf('<div %s>
								<ul class="pagination">
		',$style);	
		$i = 0;
		while($i < $daftarhalaman_halaman)
		{
			//membuat daftar offset aktif
			if($offset_nilai == $i)
			{
				$aktif = 'class="default_color"';
			}
			else
			{
				$aktif = null;
			}
			
			$daftarhalaman.= sprintf('<li><a %s href="%s">%s</a></li>',
			$aktif,
			$urloffset.$i,
			$i+1);
			$i++;
		}
		
		$daftarhalaman .= '</ul>
					</div>	';
		return $daftarhalaman;
	}
}


$template = new template();