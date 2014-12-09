<?php
// this function can print out 
function printInfo($obj)
{
	$type = gettype($obj);

	switch($type)
	{
		case "object":
			echo "\nThis is an object;\n";
			break;

		case "array":
			echo "\n";
			print_r($obj);
			echo "\n";
			break;

		case "NULL":
			echo "\nThis object is NULL\n";
			break;

		case "unknown type":
			echo "\nThis object is of unknown type\n";
			break;

		case "boolean":
		case "integer":
		case "double":
			echo "\nThis object has value = ".$obj;
			break;

		case "string":
			echo "\nString: $obj\n";
			break;

		default:
			echo "\nNot printing the obj value!\n";
			break;
	}
}

// $content is an array of strings; other features will be  implemented in the future if necessary:
function createWordFile($path, $name, $content)
{
	$word = new COM("word.application");

	// Hide MS Word application window
	$word->Visible = 0;

	//Create new document
	$word->Documents->Add();

	// Define page margins
	$word->Selection->PageSetup->LeftMargin = '2';
	$word->Selection->PageSetup->RightMargin = '2';

	// Define font settings
	$word->Selection->Font->Name = 'Arial';
	$word->Selection->Font->Size = 10;

	// Add text
	foreach ($content as $key => $text) {
		$word->Selection->TypeText($text);		
	}
	
	// Save document
	$filename = tempnam($path, $name);
	$word->Documents[1]->SaveAs($filename);

	// Close and quit
	$word->quit();
	unset($word);

	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=".$name.".doc");

	// Send file to browser
	//readfile($filename);
	unlink($filename);
}

/*
	This function transforms the html speical characters:
		For example: '<' will become '&lt;'
*/
function htmlspecialcharsUtil($obj)
{
	$type = gettype($obj);
	switch($type)
	{
		case "boolean":
		case "interger":
		case "double":
		case "object":
		case "resource":
		case "NULL":
		case "unknown type":
			return $obj;
			break;
		case "string":
			return htmlspecialchars($obj);
			break;
		case "array":
			foreach ($obj as $key => $value) {
				$obj[$key] = htmlspecialcharsUtil($value);
			}
			return $obj;
			break;
		default:
			echo "\nThe execution of htmlspecialcharsUtil is wrong! Program stopping...\n";
			exit();				
			break;
	}
}

/*
	This function removes the html tags in text:
		For example: '<I>' will be removed in the text
*/
function stripTagsUtil($obj)
{
	$type = gettype($obj);
	switch($type)
	{
		case "boolean":
		case "interger":
		case "double":
		case "object":
		case "resource":
		case "NULL":
		case "unknown type":
			return $obj;
			break;

		case "string":
			return strip_tags($obj);
			break;

		case "array":
			foreach ($obj as $key => $value) {
				$obj[$key] = strip_tags($value);
			}
			return $obj;
			break;
			
		default:
			echo "\nThe execution of stripTagsUtil is wrong! Program stopping...\n";
			exit();				
			break;
	}
}