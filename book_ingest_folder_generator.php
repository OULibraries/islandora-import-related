<?php

include_once("/Users/zhao0677/Projects/util-lib/commonFunc.php");

$pageCount = 1;

if(!isset($argv[1]) || $argv[1] == ''){
	echo "\nThe source directory path is not specified in the command line!\n";	
	die;
}
else{
	$source = $argv[1];
}

if(!isset($argv[2]) || $argv[2] == ''){
	echo "\nThe target directory path is not specified in the command line!\n";	
	die;
}
else{
	$target = $argv[2];
}

if(!file_exists($target))
	mkdir($target);

if($handle = opendir($source))
{
    while (false !== ($entry = readdir($handle))) {

    	$name = $entry;
    	$name = explode(".", $name);

    	if($name[1] == "" || ($name[1] != "tif" && $name[1] != "TIF"))
    		continue;

        $pageFolder = $target."/".$pageCount;
        mkdir($pageFolder);
        copy($source."/".$entry,$pageFolder."/".$entry);
        rename( $pageFolder."/".$entry, $pageFolder."/"."OBJ.tif");
        $pageCount++;

    }


    closedir($handle);
}


