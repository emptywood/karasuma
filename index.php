<?php
require_once('config.php');
$sql = 'SELECT c_id,c_name FROM clients';
$res = $pdo->query($sql);// 顧客リストの結果セットの取得

$sql2 = 'SELECT g_id,g_name FROM goods';
$res2 = $pdo->query($sql2);// 商品リストの結果セットの取得

// 初期値
$s_date = "";
$c_id = "";
$g_id = "";
$num = "";
// 編集の場合
if(!empty($_GET["s_id"])) {
	$sql3 = "SELECT * FROM sales WHERE s_id=:s_id";
	$stmt = $pdo->prepare($sql3);
	$stmt->bindValue(":s_id", $_GET["s_id"], PDO::PARAM_INT);
	$stmt->execute();
	$row3 = $stmt->fetch(PDO::FETCH_ASSOC);
	$s_date = $row3["s_date"];
	$c_id = $row3["c_id"];
	$g_id = $row3["g_id"];
	$num = $row3["num"];
}
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
		</header>
		<h1>売上入力</h1>
		<form action="insert.php" method="post" id="f1">
			<table>
				<tr>
					<th><label for="s_date">販売日</label></th>
					<th><label for="c_id">顧客名</label></th>
					<th><label for="g_id">商品</label></th>
					<th><label for="num">個数</label></th>
					<th>小計</th>
				</tr>
				<tr>
					<td><input type="date" name="s_date" id="s_date" value="<?php echo $s_date; ?>"></td>
					<td>
						<select name="c_id" id="c_id">
							<option value="">ここから選択</option>
							<?php while($row = $res->fetch(PDO::FETCH_ASSOC)) : ?>
								<?php if($row["c_id"] == $c_id) : ?>
								<option value="<?php echo $row["c_id"]; ?>" selected>
								<?php else : ?>
								<option value="<?php echo $row["c_id"]; ?>">
								<?php endif; ?>
									<?php echo htmlspecialchars($row["c_name"], ENT_QUOTES); ?>
							</option>
							<?php endwhile; ?>
						</select>
					</td>
					<td>
						<select name="g_id" id="g_id">
							<option value="">ここから選択</option>
							<?php while($row2 = $res2->fetch(PDO::FETCH_ASSOC)) : ?>
								<?php if($row2["g_id"] == $g_id) : ?>
								<option value="<?php echo $row2["g_id"]; ?>" selected>
								<?php else : ?>
								<option value="<?php echo $row2["g_id"]; ?>">
								<?php endif; ?>
									<?php echo htmlspecialchars($row2["g_name"], ENT_QUOTES); ?>
							</option>
							<?php endwhile; ?>
						</select>
					</td>
					<td><input type="number" name="num" id="num" min="1" value="<?php echo $num; ?>"></td>
					<td id="subtotal"></td>
				</tr>
			</table>
			<?php if(empty($_GET["s_id"])) : ?>
			<p><input type="submit" name="sub" value="登録"></p>
			<?php else : ?>
			<p>
				<input type="submit" name="sub" value="編集">
				<input type="submit" name="sub" value="削除">
				<input type="hidden" name="s_id" value="<?php echo intval($_GET["s_id"]); ?>">
			</p>
			<?php endif; ?>
			<p id="msg">
			<?php if(!empty($_GET["err"])) : ?>
			<?php echo "未入力項目があります"; ?>
			<?php endif; ?>
			</p>
		</form>
	</div>
  <script src="js/app.js"></script>
</body>
</html>
