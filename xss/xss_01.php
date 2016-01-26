<?php
/**
 * おみくじの結果をランダムに取得する
 * http://security.funayoseyoshito.com/xss/xss_01.php?username=%3Cscript%3Ewindow.document.location.href=%22http://security.funayoseyoshito.com/xss/fishing.html%22;%3C/script%3E

 */
$fortune = array(
	0 => '大吉',
	1 => '中吉',
	2 => '小吉',
	3 => '末吉',
	4 => '凶',
	5 => '大凶',
);

$key = rand(0,5);
if (isset($_GET['username'])) {
	echo $_GET['username'].'さんの運勢は'.$fortune[$key].'です。';
}

// おみくじ用フォームの出力
echo '<html>';
echo '<head><meta charset="UTF-8"></head>';
echo '<form>';
echo 'お名前<input type="text" name="username" />';
echo '<input type="submit" value="占ってみる" />';
echo '</form>';
echo '</html>';
