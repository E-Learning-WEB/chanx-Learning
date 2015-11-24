<!--Navigation-->
<div class="navbar-fixed">
<nav id="nav_f" class="default_color" role="navigation">
<div class="container">
<div class="nav-wrapper">
<a href="#" id="logo-container" class="brand-logo">English Course</a>
<ul class="right hide-on-med-and-down">
<li><a href="index.php?">Beranda</a></li>
<li><a href="<?php echo $go->to('materi','list'); ?>">Materi</a></li>
<li><a href="?sub=forum&act=list">Forum</a></li>
<?php
					if(isset($_SESSION['login']))
					{
						echo sprintf('
						<li>
						<div class="dropdown">
    <a href="#" class="dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">ProfilKu
    <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
	  <li class="dropdown-header">Hi, %s</li> 
      <li><a role="menuitem" tabindex="-1" href="%s">Profil</a></li>
      <li class="divider"></li>
      <li "><a role="menuitem" tabindex="-1" href="?sub=login&act=logout">Logout</a></li>
    </ul>
  </div>
						</li>',
						$_SESSION['username'],
						$go->to('profil','lihat',$_SESSION['username']));
					}
					else
					{
						echo '<li><a href="?sub=login">Masuk / Daftar</a></li>';
					}
					?>
<?php
					if($user['status'] == 'Admin')
					{
					?>
					<li>
					<div class="dropdown"> 
                    	<a href="#" class="dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">						Admin <span class="caret"></span></a>
    					<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        	  <li class="dropdown-header">Anggota</li> 
                              <li><a role="menuitem" tabindex="-1" href="<?php echo $go->to('profil','list');?>">Anggota</a></li>
                        </ul>
                     </div>
                     </li>
      <?php	
					}
					?>
    </ul>
    <ul id="nav-mobile" class="side-nav">
      <li><a href="index.php?">Beranda</a></li>
      <li><a href="<?php echo $go->to('materi','list'); ?>">Materi</a></li>
      <li><a href="?sub=forum&act=list">Forum</a></li>
      <li><a href="?sub=login">Masuk / Daftar</a></li>
    </ul>
    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a> </div>
</div>
</nav>
</div>
<div class="laman" style="min-height:500px;;">
