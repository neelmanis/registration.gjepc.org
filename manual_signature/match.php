<?php

//$strings = "1009.00";
$strings = "1009";
$search = '.';
if (stripos($strings,$search)) {
    echo 'Contains word decimal';
}else{
    echo "does NOT contain word decimal";
}
?>