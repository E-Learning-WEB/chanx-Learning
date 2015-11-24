<?php
//if(!defined('CHANX')){
//	readfile('common/error.php');
//	die;	}
include ('config/config.php');
include $engine->config('koneksi');
$sql = sprintf("SELECT * FROM tb_materi WHERE hash = '%s'",$_GET['hash']);
$data = $db->query($sql);
$jumlah_materi = $data->num_rows;
$row = $data->fetch_assoc();

header('Content-Type: application/pdf');
header('Content-Disposition: inline; ');
echo readfile($row['konten']);

?>