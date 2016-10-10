<?php

	require_once('convert-ascii.php');
	error_reporting(0);
	
	if(count($argv)!=4)
	{
		echo "Exactly 3 arguments needed. Format is php main.php path_to_image scale output_file_path";
		exit(1);
	}
		
	$path = $argv[1];
	$scale = $argv[2];
	$output_file = $argv[3];
    
    $output = convertImageAscii($path, $scale);
    file_put_contents($output_file, $output);

    echo "Done";

?>
