<?php
/*
' or 1=1; drop table users; -- 
*/

define('DB_USER', 'root');
define('DB_PASS', '*******');
define('DB_NAME', 'security');
define('PASSWD_HASH', 'dipshinsotsukensyu0314');

/*
 * 入力されたユーザ名とパスワードを元に、ユーザが存在するか確認する
 */
function check_user($user_id, $pass) {
	//パスワードをハッシュ化
	$pass = crypt($pass, PASSWD_HASH);

	$db = new PDO('mysql:host=localhost;dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
	$stmt = $db->query("SELECT * FROM users where user_id = '$user_id' and pass = '$pass';");
	return (boolean)$stmt->fetch();
}

// POSTの場合はログインチェック
if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
	$conn = mysql_connect('localhost', DB_USER, DB_PASS);
	mysql_select_db('security');
	$result = check_user($_POST['user_id'], $_POST['pass']);
	if ($result === true) {
		echo '<span style="color: #0000ff">ログインに成功しました</span>';
	} else {
		echo '<span style="color: #ff0000">ログインに失敗しました</span>';
	}
	mysql_close($conn);
	exit();
}

// ログインフォームを表示
header('Content-type: text/html; charset=utf-8');
echo <<<EOF
<html>
	<head>
		<title>ログイン画面</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>ログインフォーム</h1>
		<form action="./sql_01.php" method="post">
			ユーザid<input type="text" name="user_id" value="" /><br />
			パスワード<input type="text" name="pass" value="" /><br />
			<input type="submit" value="ログインする" />
		</form>
	</body>
</html>
EOF;
