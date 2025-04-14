<?php
// WordPress環境を読み込む
require_once(dirname(__FILE__) . '/wp-load.php');

// ★↓↓↓ここにテストメールを受信するあなたの個人メールを設定↓↓↓★
$test_email = 't.kaga@kakehashi-m.com';

// メール送信設定
$subject = '【テストメール】カケハシ 本番環境送信テスト';
$body = 'このメールは、カケハシの本番環境からのメール送信テストです。';
$headers = [
  'From: カケハシテスト <info@kakehashi-m.com>',
  'Reply-To: info@kakehashi-m.com'
];

// メール送信実行
$sent = wp_mail($test_email, $subject, $body, $headers);

// 結果を表示
if ($sent) {
  echo '本番環境からのテストメール送信に成功しました。送信先を確認してください。';
} else {
  echo '本番環境からのテストメール送信に失敗しました。';
}
