<?php
/*
 * 管理者かチェックする
 */
function is_admin() {
	return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

/*
 * ワンタイムトークンを生成する関数
 */
function get_token($key='') {
	$_SESSION['key'] = $key;
	return  sha1($key);
}

/*
 * ワンタイムトークンをチェックする関数 
 */
function check_token($token='') {
	return ($token === sha1($_SESSION['key']));
}

session_start();

// postだった場合は、指定された処理を実行
if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
	if (isset($_POST['op']) && $_POST['op'] === 'delete' && is_admin()) {
		if (!isset($_POST['token']) || !check_token($_POST['token'])) {
			echo 'csrfの攻撃を受けた可能性があります。';
		} else {
			echo '記事の削除を行いました。';
		}
	} else if (isset($_POST['op']) && $_POST['op'] === 'login') {
		$_SESSION['is_admin'] = true;
		echo '管理者としてログインしました。';
	} else {
		echo '権限がありません。';
	}
}

//  セッション内のワンタイムトークン用文字列を削除 
if (isset($_SESSION['key'])) {
	unset($_SESSION['key']);
}

// ワンタイムトークン取得
$token = get_token(session_id().'_'.microtime());

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
			<input type="hidden" name="token" value="$token" />
			<input type="submit" value="記事を削除" />
		</form>
	</div>
</html>
EOF;
