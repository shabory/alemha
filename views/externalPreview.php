<?php //var_dump($_POST['dataObj']);
//echo "aa";
$params = json_decode(file_get_contents('php://input'));
//echo $params->data;
var_dump($params);?> 
