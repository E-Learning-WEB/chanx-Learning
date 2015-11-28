<?php
if($_GET['act'] == 'baru')
{
	$manipulasi['judul'] = 'Menambah Materi Baru';
	$manipulasi['tombolkirim'] = 'materibaru';
	$manipulasi['tombolhapus'] = null;
	$nilai['judul'] =	$nilai['kelas'] =	$nilai['urutan'] =	$nilai['deskripsi'] = NULL;
}
else
{
	$manipulasi['judul'] = 'Mengedit Materi';
	$manipulasi['tombolkirim'] = 'materiedit';	
	$manipulasi['tombolhapus'] = $input->button('hapus',$go->to('proses&aksi=hapusmateri&hash='.$_GET['hash']));	
	
	//mengambil data record yang telah ada didatabase
	$datamateri = $db2->prepare('SELECT * FROM tb_materi WHERE hash = (:hash)');
	$datamateri->bindValue(':hash', $_GET['hash']);
	$datamateri->execute();
	foreach($datamateri as $recordmateri);
	
	$nilai['judul'] = $recordmateri['judul'];
	$nilai['kelas'] =	$recordmateri['kelas'];
	$nilai['urutan'] =	$recordmateri['urutan'];
	$nilai['deskripsi'] = $recordmateri['deskripsi'];
}

?>
<div class="container">
  <div class="card">
    <header class="panel-heading bg-theme-gradient">
      <h2><?php echo $manipulasi['judul']; ?></h2>
    </header>
    <div id='editor' class="panel-body">
      <form class="form-horizontal labelcustomize" data-collabel="2" data-label="color" action="<?php echo $go->to('proses');?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label class="control-label col-md-2"><span class="color">judul</span></label>
          <div class="col-md-10">
            <input type="text" name="judul" class="form-control" maxlength="25" data-always-show="true" 
            value="<?php echo $nilai['judul']; ?>">
          </div>
        </div>
        <!-- //form-group-->
        
        <div class="form-group">
          <label class="control-label col-md-2"><span class="color">Kelas</span></label>
          <div class="col-md-10">
            <input type="text" name="kelas" class="form-control" maxlength="25" data-always-show="true" 
            value="<?php echo $nilai['kelas']; ?>">
          </div>
        </div>
        <!-- //form-group-->
        
        <div class="form-group">
          <label class="control-label col-md-2"><span class="color">Urutan/BAB</span></label>
          <div class="col-md-10">
            <input type="text" name="urutan" 
            value="<?php echo $nilai['urutan']; ?>"/>
          </div>
        </div>
        <!-- //form-group-->
        

        <div class="form-group">
          <label class="control-label col-md-2"><span class="color">Deksripsi</span></label>
          <div class="col-md-10">
			<textarea class="form-control md-input" name="deksripsi" rows="5" data-provide="markdown" data-hidden-buttons="cmdHeading" style="resize: none;" ><?php echo $nilai['deskripsi'];?></textarea>
          </div>
        </div>
        <!-- //form-group-->
        
        
        
                <div class="form-group">
          <label class="control-label col-md-4"><span class="color">Dokument</span></label>
          <div class="col-md-8">
            <div class="fileinput fileinput-new" data-provides="fileinput">
              <input type="file" name="fileToUpload">
            </div>
            <!-- //fileinput--> 
          </div>
        </div>
        
        
        <div class="lainnya">
          <button class="btn btn-default lainnya" type="submit" name="<?php echo $manipulasi['tombolkirim']; ?>">Kirim</button>
          <?php echo $manipulasi['tombolhapus']; ?>
        </div>
      </form>
    </div>
  </div>
</div>