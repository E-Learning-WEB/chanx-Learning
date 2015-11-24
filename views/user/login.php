<?php
include $engine->func('login');
?>

<div class="container">
<div class="row">         
<div class="kotak-login card">

<?php 
if(!isset($_GET['act']))
{
?>
<h5 class="center" style="margin:-10px; padding:20px;">Login</h5>
  <form id="form-signin" class="form-signin" action="?sub=login" method="post">
    <?php 
              	if(isset($_GET['psn_login']))
	{
		
		echo '<div class="alert bg-danger">
			<strong>Oh NO!</strong>  Ada Kesalahan.
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
	  echo $input->label('password','Kata Sandi','active');
	?>
    </div>
    
    <input name="login" class="btn right white-text" type="submit" value="login">
  </form>
  <p>
  <a href="?sub=login&act=lupapassword">Lupa Password?</a>
  <p>
  
  
  <hr />
  
  <p class="center" style="padding:10px; margin:auto; border:solid 1px #ccc">
  Belum ada akun?  <a href="?sub=register">Daftar</a>
  <p>
  </div>
<?php
}
elseif($_GET['act'] == 'lupapassword')
{
?>
  <form id="form-signin" class="form-signin" action="?sub=login" method="post">
<h5 class="center" style="margin:-10px; padding:20px;">Lupa Password</h5>
    <div class="input-field s6"> <i class="mdi-action-account-circle prefix active"></i>
    <?php 
	echo $input->text('username','username','validate valid');
	echo $input->label('username','Nama Pengguna','active');
	?>
    </div>
        <input name="lupapassword1" class="btn right white-text red darken-1" type="submit" value="selanjutnya >">
    </form>
<?php		
}
else
{
	header("location:?sub=login");
}
?> 
 

 
 
 
  </div>

</div>
