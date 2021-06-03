<?php
// データのチェック
if(empty($_POST["s_date"]) || empty($_POST["c_id"]) || empty($_POST["g_id"]) || empty($_POST["num"])){
	header("Location: index.php?err=1");
	exit();
}
require_once("config.php");
switch($_POST["sub"]){
	case "登録":
		$sql = "INSERT INTO sales(s_date,c_id,g_id,num) VALUES(:s_date,:c_id,:g_id,:num)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(":s_date", $_POST["s_date"], PDO::PARAM_STR);
		$stmt->bindValue(":c_id", $_POST["c_id"], PDO::PARAM_INT);
		$stmt->bindValue(":g_id", $_POST["g_id"], PDO::PARAM_INT);
		$stmt->bindValue(":num", $_POST["num"], PDO::PARAM_INT);
		$stmt->execute();
	break;
	
	case "編集":
		$sql = "UPDATE sales SET s_date=:s_date,c_id=:c_id,g_id=:g_id,num=:num WHERE s_id=:s_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(":s_date", $_POST["s_date"], PDO::PARAM_STR);
		$stmt->bindValue(":c_id", $_POST["c_id"], PDO::PARAM_INT);
		$stmt->bindValue(":g_id", $_POST["g_id"], PDO::PARAM_INT);
		$stmt->bindValue(":num", $_POST["num"], PDO::PARAM_INT);
		$stmt->bindValue(":s_id", $_POST["s_id"], PDO::PARAM_INT);
		$stmt->execute();
		break;
		
	case "削除":
		$sql = "DELETE FROM sales WHERE s_id=:s_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(":s_id", $_POST["s_id"], PDO::PARAM_INT);
		$stmt->execute();
}
header("Location: list.php");
?>
