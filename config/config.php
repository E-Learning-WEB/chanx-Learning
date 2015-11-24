<?php
$subdir = 'learning-material';

$url = array (
    "url" => "http://" . $_SERVER['HTTP_HOST'] . '/' . $subdir,
    "sub" => "/". $subdir."/?",
    "request" => $_SERVER['REQUEST_URI']
);

$situs = array(
'judul' => 'English Course'
);

$akun = array(
'minpassword' => 6, 
'maxpassword' => 32
);

class engine{
	public function hashacak($jumlah = null,$hurufbesar = null)
	{		
		if(empty($jumlah)){$jumlah=4;}
		
		if(empty($hurufbesar))
		{$huruf = '2346789ABCDEFGHJKLMNPRTUVWXYZ';}
		else{$huruf = '12346789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';}
		$hashacak = NULL;
			for ($i = 0; $i < $jumlah; $i++) {
				$hashacak .= $huruf[rand(0, strlen($huruf) - 1)];
			}	
		return $hashacak;	
	}
	public function config($name){
		$function = sprintf('%s/config/%s.php',getcwd(),$name);
		return $function;
	}
	public function func($name){
		$function = sprintf('%s/functions/%s.php',getcwd(),$name);
		return $function;
	}
	
	public function view($name){
		$function = sprintf('%s/views/%s.php',getcwd(),$name);
		return $function;
	}
}

class error{
	public function code($code){
		switch ($code)
		{
			case '404':
			$e = 'Oops Something Went Wrong, 404';
			break;
			default:
			$e = NUll;
		}
		
		return $e;
	}
	
}

class go{

	public function to($sub = null,$act = null,$hash = null){
		if(!empty($sub) AND !empty($act) AND !empty($hash))
		{
			$to = sprintf('index.php?sub=%s&act=%s&hash=%s',$sub,$act,$hash);
		}
		elseif(!empty($sub) AND !empty($act))
		{
			$to = sprintf('index.php?sub=%s&act=%s',$sub,$act);
		}
		elseif(!empty($sub))
		{
			$to = sprintf('index.php?sub=%s',$sub);
		}
		else
		{
			$to = Null;
		}
		
		return $to;
	}
	
}

class input{
	public function text($name,$id,$class = Null,$style = null,$lain = null){
		$input = sprintf('<input type="text" name="%s" id="%s" class="%s" style="%s" %s>',$name,$id,$class,$style,$lain);
        return $input;
    } 
	public function text2($properti = null){
		$properti_name = array('name','id','class','style','lainnya');
		$i =0;
		while($i < 5)
		{
			if(empty($properti[$properti_name[$i]]))
			{
				$properti[$properti_name[$i]] = NULL;
			}
			$i ++;
		}
		
						
		$input = sprintf('<input type="text" name="%s" id="%s" class="%s" style="%s" %s >',
		$properti['name'],
		$properti['id'],
		$properti['class'],
		$properti['style'],
		$properti['lainnya']
		);
        return $input;
    } 
	
	public function email($name,$id,$class = Null){
		$input = sprintf('<input type="email" name="%s" id="%s" class="%s">',$name,$id,$class);
        return $input;
    } 
	public function password($name,$id,$class = Null){
		$input = sprintf('<input type="password" name="%s" id="%s" class="%s">',$name,$id,$class);
        return $input;
    } 
	public function label($for,$value,$class = Null){
		$input = sprintf('<label for="%s" class="%s">%s</label>',$for,$class,$value);
		return $input;
	}
	
	public function option($name,$option,$selected = null, $class = null)
	{
		$selectedhtml = "";
		$input = sprintf('<select class="input-field" name="%s" style="%s">\n',$name,$class);
		foreach ($option as $key => $val) {
			if($key == $selected) {$selectedhtml = "selected";}else{$selectedhtml= null;}
    			$input .= "<option value='$key' $selectedhtml>$val</option>\n";
		}
		$input .= "</select>\n";
		
		
		return $input;
	}
	
	public function button($label,$href,$label_class=null,$style=null)
	{
		$input =sprintf('<a class="btn btn-default"  style="%s" href="%s"><i class="fa fa-pencil-square-o"></i>%s</a>',
		$style,
		$href,
		$label);
		return $input;
	}
	
	public function link($link)
	{
		if(empty($link['style'])){$link['style'] = null;}
		$input = sprintf('<a href="%s" %s><i class="fa fa-pencil-square-o"></i> %s</a> ',
		$link['href'],
		$link['style'],
		$link['label']
		);
		return $input;
	}
}


$engine = new engine();
$error = new error();
$go = new go();
$input= new input();


include $engine->func('Parsedown');
$Parsedown = new Parsedown();
function random_gravatar( $size = 100, $email = "" ){
    	$random_image = array('mm'); 
	return "http://www.gravatar.com/avatar/". md5(strtolower(trim($email))) ."?r=g&s=" . $size . "&d=" . $random_image[array_rand($random_image)];}
