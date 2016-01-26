<?php
/*
 * 管理者かチェックする
 */
function is_admin() {
	return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

session_start();

//postだった場合は、指定された処理を実行
if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
	if (isset($_POST['op']) && $_POST['op'] === 'delete' && is_admin()) {
		echo '記事の削除を行いました。';
	} else if (isset($_POST['op']) && $_POST['op'] === 'login') {
		$_SESSION['is_admin'] = true;
		echo '管理者としてログインしました。';
	} else {
		echo '権限がありません。';
	}
}

echo <<<EOF
<html>
	<head>
		<title>記事削除画面</title>
	</had>
	<div>
		<h1>管理者ログイン</h1>
		<form action="./csrf_01.php" method="post">
			<input type="hidden" name="op" value="login" />
			<input type="submit" value="管理者としてログインする" />
		</form>
	</div>
	<div>
		<h1>記事削除フォーム</h1>
		<form action="./csrf_01.php" method="post">
			<input type="hidden" name="op" value="delete" />
			<input type="submit" value="記事を削除" />
		</form>
	</div>
</html>
EOF;
