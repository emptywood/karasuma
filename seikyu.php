<?php
require_once('config.php');
// 請求金額の取得
$c_name = "";
$total = "";
if(!empty($_POST["c_id"]) && !empty($_POST["start"]) && !empty($_POST["end"])) {
	$sql4seikyu = "SELECT c_name,SUM(price*num) AS total";
	$sql4seikyu .= " FROM sales,clients,goods";
	$sql4seikyu .= " WHERE sales.c_id=clients.c_id";
	$sql4seikyu .= " AND sales.g_id=goods.g_id";
	$sql4seikyu .= " AND sales.c_id=:c_id";
	$sql4seikyu .= " AND s_date BETWEEN :start AND :end";
	$stmt = $pdo->prepare($sql4seikyu);
	$stmt->bindValue(":c_id", $_POST["c_id"], PDO::PARAM_INT);
	$stmt->bindValue(":start", $_POST["start"], PDO::PARAM_STR);
	$stmt->bindValue(":end", $_POST["end"], PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$c_name = htmlspecialchars($row["c_name"], ENT_QUOTES);
	$total = number_format($row["total"]);
}

// 顧客リストの取得
$c_sql = "SELECT * FROM clients";
$c_res = $pdo->query($c_sql);
// 売上データの取得
$sql = "SELECT s_date,c_name,g_name,num,num*price AS st";
$sql .= " FROM sales,goods,clients";
$sql .= " WHERE sales.c_id=clients.c_id";
$sql .= " AND sales.g_id=goods.g_id";

// 絞り込み条件の対応
if(!empty($_POST["c_id"])) {
	$sql .= " AND sales.c_id=:c_id";
}
if(!empty($_POST["start"]) && !empty($_POST["end"])) {
	$sql .= " AND s_date BETWEEN :start AND :end";
}

$sql .= " ORDER BY s_date DESC";
$stmt = $pdo->prepare($sql);

if(!empty($_POST["c_id"])){
	$stmt->bindValue(":c_id",$_POST["c_id"],PDO::PARAM_INT);
}
if(!empty($_POST["start"]) && !empty($_POST["end"])) {
	$stmt->bindValue(":start", $_POST["start"], PDO::PARAM_STR);
	$stmt->bindValue(":end", $_POST["end"], PDO::PARAM_STR);
}
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>烏丸文具店業務システム</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="/mk/jquery-3.5.1.min.js"></script>
</head>
<body>
	<div id="container">
		<header>
			<nav>
				<ul>
					<li><a href="index.php">売上入力</a></li>
					<li><a href="list.php">売上一覧</a></li>
					<li><a href="seikyu.php">請求印刷</a></li>
				</ul>
			</nav>
			<form action="" method="post">
				<label for="c_id">顧客の絞り込み</label>
				<select name="c_id" id="c_id">
					<option value="">ここから選択</option>
						<?php while($row = $c_res->fetch(PDO::FETCH_ASSOC)) : ?>
					<option value="<?php echo $row["c_id"]; ?>">
						<?php echo htmlspecialchars($row["c_name"], ENT_QUOTES); ?>
					</option>
					<?php endwhile; ?>
				</select>
				<label for="start">開始日</label>
				<input type="date" name="start" id="start">
				<label for="end">終了日</label>
				<input type="date" name="end" id="end">
				<button type="submit">絞り込み</button>
			</form>
		</header>
		<h1>請求書</h1>
		<p><?php echo $c_name; ?>御中</p>
		<p>ご請求金額: <?php echo $total; ?>円</p>
			<table>
				<tr>
					<th>販売日</th>
					<th>商品名</th>
					<th>個数</th>
					<th>小計</th>
				</tr>
				<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
				<tr>
					<td><?php echo $row["s_date"]; ?></td>
					<td><?php echo htmlspecialchars($row["g_name"], ENT_QUOTES); ?></td>
					<td class="num"><?php echo $row["num"]; ?></td>
					<td class="num"><?php echo number_format($row["st"]); ?>円</td>
				</tr>
				<?php endwhile; ?>
			</table>
	</div>
  <script src="js/app.js"></script>
</body>
</html>
