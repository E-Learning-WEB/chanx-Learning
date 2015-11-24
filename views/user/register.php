<div class="container">
<div class="row">         
<div class="kotak-login card">
<h5 class="center default_color white-text" style="margin:-10px; padding:20px;">Daftarkan Akun</h5>
  <form id="form-signin" class="form-signin" action="<?php echo $go->to('proses'); ?>" method="post">
    <?php 
              	if(isset($_GET['psn_login']))
	{
		
		echo '<div class="alert bg-danger">
			<strong>Oh Shit!</strong>  Ada Kesalahan.
			</div>';
	}
    ?>
    <div class="input-field s6"> <i class="mdi-action-account-circle prefix active"></i>
      <?php 
	  	echo $input->text('username','username','validate valid');
		echo $input->label('username','Nama Pengguna','active');
	  ?>
    </div>
    
    <div class="input-field s6"> <i class="fa fa-key prefix active"></i>
      <?php 
	  	echo $input->password('password','password','validate valid');
		echo $input->label('password','Password','active');
	  ?>    
    </div>
    <div class="input-field s6"> <i class="fa fa-key prefix active"></i>
      <?php 
	  	echo $input->password('password2','password2','validate valid');
		echo $input->label('password2','Konfirmasi Sandi','active');
	  ?>    
    </div>
    
    <hr />
   <div class="input-field s6"> <i class="fa fa-email prefix active"></i>
      <?php 
	  	echo $input->email('email','email','validate valid');
		echo $input->label('email','Surel / E-mail','active');
	  ?>    
    </div>
   <div class="input-field s6"> <i class="fa fa-email prefix active"></i>
      <?php 
	  	echo $input->text('display_name','display_name','validate valid');
		echo $input->label('display_name','Nama Lengkap','active');
	  ?>    
    </div>    
    <input class="btn right white-text"  name="daftar" type="submit" value="daftar">
  </form>
  <p>
  Sudah punya akun?
  <a href="?sub=login">masuk</a>
  <p>
  </div>
  </div>

</div>
