<?php
if($_GET['act'] == 'baru')
{
	$manipulasi['judul'] = 'Menambah Materi Baru';
}
else
{
	$manipulasi['judul'] = 'Mengedit Materi';
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
            value="<?php if(isset($edit)){echo $materi['judul'];}; ?>">
          </div>
        </div>
        <!-- //form-group-->
        
        <div class="form-group">
          <label class="control-label col-md-2"><span class="color">Kelas</span></label>
          <div class="col-md-10">
            <input type="text" name="kelas" class="form-control" maxlength="25" data-always-show="true" 
            value="<?php if(isset($edit)){echo $materi['kelas'];}; ?>">
          </div>
        </div>
        <!-- //form-group-->
        
        <div class="form-group">
          <label class="control-label col-md-2"><span class="color">Urutan/BAB</span></label>
          <div class="col-md-10">
            <input type="text" name="urutan" 
            value="<?php if(isset($edit)){echo $materi['urutan'];}; ?>"/>
          </div>
        </div>
        <!-- //form-group-->
        

        <div class="form-group">
          <label class="control-label col-md-2"><span class="color">Deksripsi</span></label>
          <div class="col-md-10">
			<textarea class="form-control md-input" name="deksripsi" rows="5" data-provide="markdown" data-hidden-buttons="cmdHeading" style="resize: none;" ><?php if(isset($edit)){echo $materi['deskripsi'];}; ?></textarea>
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
          <button class="btn btn-default lainnya" type="submit" name="materibaru">Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>