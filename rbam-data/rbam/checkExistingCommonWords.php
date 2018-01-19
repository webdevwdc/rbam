<?php
ob_start ();
session_start();
include("conn.php");


if(isset($_POST['STATUS']) && $_POST['STATUS']=='INS')
{
    $WORD_NAME = trim($_POST['WORD_NAME']);


    $sql="select * from cxs_common_words where WORD_NAME = '".$WORD_NAME."'";

    $result = mysql_query($sql);
    $TotalRecords = mysql_num_rows($result);

    echo $TotalRecords;
}

if(isset($_POST['STATUS']) && $_POST['STATUS']=='UPD')
{
    $WORD_NAME = trim($_POST['WORD_NAME']);
    $COMMON_WORD_ID = $_POST['COMMON_WORD_ID'];


    $sql="select * from cxs_common_words where WORD_NAME = '".$WORD_NAME."' and COMMON_WORD_ID!='".$COMMON_WORD_ID."'";

    $result = mysql_query($sql);
    $TotalRecords = mysql_num_rows($result);

    echo $TotalRecords;
}
?>