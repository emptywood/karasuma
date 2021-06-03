<?php
require_once('config.php');
$sql = 'INSERT INTO sales(s_date,c_id,g_id,num) VALUES(:s_date,:c_id,:g_id,:num)';
$stmt = $pdo->prepare($sql);
$s_date = "2021-03-15";
for($i=0; $i<100; $i++){
	$c_id = rand(1,4);
	$g_id = rand(1,4);
	$num = rand(1,10) * 5;
	$stmt->bindValue(":s_date",$s_date,PDO::PARAM_STR);
	$stmt->bindValue(":c_id",$c_id,PDO::PARAM_INT);
	$stmt->bindValue(":g_id",$g_id,PDO::PARAM_INT);
	$stmt->bindValue(":num",$num,PDO::PARAM_INT);
	$stmt->execute();
}
?>
