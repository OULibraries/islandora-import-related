
<?php
	// *** suppose the xsl files are at the same directory as the PHP script *** //

	if(!isset($argv[1]) || $argv[1] == ''){
		echo "\nThe source directory path for Dublin Core XML file is not specified in the command line!\n";	
		die;
	}
	else{
		$xml_dc = new DOMDocument;
		$xml_dc->load($argv[1]);
	}

	$file = "MODS.xml";
	//$current = file_get_contents($file);

	// *** DC to MARCXML *** //
	$xsl = new DOMDocument;
	$xsl->load('DC2MARC.xsl');

	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl);

	$current = $proc->transformToXML($xml_dc);
	if($current != "false"){
		file_put_contents($file, $current);
	}
	else{
		echo "Transforming DC to MARCXML failed!\n";
		exit();
	}

	// *** MARCXML to MODS *** //
	$xml_marc = new DOMDocument;
	$xml_marc->load($file);

	$xsl->load('MARC2MODS-5.xsl');

	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl);

	$current = $proc->transformToXML($xml_marc);
	if($current != "false"){
		file_put_contents($file, $current);
	}
	else{
		echo "Transforming MARCXML to MODS failed!\n";
		exit();
	}

	//echo $proc->transformToXML($xml);

?>
