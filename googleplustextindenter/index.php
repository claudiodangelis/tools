<form action="/projects/googleplustextindenter" method="post">
<h2>Paste your code into textarea...</h2>

<?php
if(!function_exists('hex2bin'))
{
    function hex2bin($data)
    {
        $bin="";
        $i=0;
        do {
            $bin.= chr(hexdec($data{$i}.$data{($i + 1)}));
            $i+= 2;
        } while ($i < strlen($data));
        return $bin;
    }
}

if(isset($_POST['indent'])){
	$input_code=$_POST['input_code'];
	$input_code_hex=bin2hex($input_code);
	$check_e28082=strpos($input_code_hex,"e28082");

	if($check_e28082!==False){
		$output_code=str_replace("e28082","20",$input_code_hex);
		$output_code=hex2bin($output_code);
	}else{
		$input_code=explode("\n",$input_code);
		for($i=0;$i<count($input_code);$i++){
			$output_code=$output_code."\n".str_pad($input_code_trimmed=ltrim($input_code[$i]), strlen($input_code_trimmed) + 6*((strlen($input_code[$i]) - strlen($input_code_trimmed))), "&#8194", STR_PAD_LEFT);
		}
	}
}else{
	$output_code="";
}
?>

<textarea name="input_code" cols="50" rows="35" style="width:100%"><?php echo "$output_code"; ?></textarea>
<input type="submit" name="indent"/>
</form>

