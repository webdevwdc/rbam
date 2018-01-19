<?php
include('../conn.php');

$password = $_POST['psword'];
    

$sql = "SELECT count(*) as cnt FROM cxs_common_words WHERE WORD_NAME like '%".substr($password,0,5)."%' and ACTIVE_FLAG='1'";
$res=mysql_query($sql);
$numRows = mysql_fetch_array($res);
echo $numRows['cnt'];
?>