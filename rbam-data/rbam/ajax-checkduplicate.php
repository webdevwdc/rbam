<?php
include('conn.php');
?>

<?php
if($_REQUEST['REQUEST'] == "CheckDuplicate") //every page
{
	$TableName = $_REQUEST['TableName'];
	$FieldName = $_REQUEST['FieldName'];	
	$FieldValue = $_REQUEST['FieldValue'];	
	$FieldId = $_REQUEST['FieldId'];
	$SelectedId = $_REQUEST['SelectedId'];
	
	if($SelectedId != '')
	{
		$Query = "SELECT * FROM $TableName WHERE $FieldName ='$FieldValue' and FieldId <> $FieldId ";				
	}
	else
	{
		$Query = "SELECT * FROM $TableName WHERE $FieldName ='$FieldValue' ";				
	}	
	if($Query != '')	
	{
		$Result = mysql_query($Query);
		$result_row = mysql_num_rows($Result);
		if($result_row != 0)
		{
			//echo 'Period Name Already Exists. Enter Different Name.';
			echo 'Do not allow duplicate entry.';
		}
		else
		{
			echo '';
		}
	}
}
?>