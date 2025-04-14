<?php
/* Template Name: サンクスページ */
get_header();
?>

<div class="thanks-container">
  <h1>お問い合わせありがとうございます</h1>
  <p>送信が完了しました。内容を確認のうえ、担当者よりご連絡差し上げます。</p>
  <p>ご連絡までしばらくお待ちください。</p>
  <div class="thanks-link">
    <a href="<?php echo home_url(); ?>">トップページに戻る</a>
  </div>
</div>

<style>
.thanks-container {
  text-align: center;
  padding: 60px 20px;
}

.thanks-container h1 {
  font-size: 2rem;
  color: #333;
  margin-bottom: 20px;
}

.thanks-container p {
  font-size: 1.1rem;
  color: #666;
  margin-bottom: 10px;
}

.thanks-link a {
  display: inline-block;
  margin-top: 30px;
  background-color: #ffa64d;
  color: white;
  padding: 12px 24px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.thanks-link a:hover {
  background-color: #ff8c00;
}
</style>

<?php get_footer(); ?>
