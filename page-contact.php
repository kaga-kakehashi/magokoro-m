<?php
/* Template Name: お問い合わせ */
get_header();
?>

<!DOCTYPE html>
<html lang="ja">
<!-- reCAPTCHA v3 スクリプト -->
<script src="https://www.google.com/recaptcha/api.js?render=6Ley3AwrAAAAAOHFJ2PG6OlfNJlx8ed8t3Y670Hc"></script>
<script>
  grecaptcha.ready(function () {
    grecaptcha.execute('6Ley3AwrAAAAAOHFJ2PG6OlfNJlx8ed8t3Y670Hc', { action: 'submit' }).then(function (token) {
      document.getElementById('recaptcha_token').value = token;
    });
  });
</script>

<body>
  <div class="contact-container">
    <h1>お問い合わせ</h1>
    <form action="/secure-mail-endpoint.php" method="post" enctype="multipart/form-data" class="contact-form">

      <!-- ハニーポット hidden項目 -->
      <input type="text" name="nickname" style="display:none" autocomplete="off">

      <!-- お問い合わせ種別 -->
      <div class="form-group">
        <label>お問い合わせ種別 <span>*</span></label>
        <div class="radio-group">
          <label class="radio-option">
            <input type="radio" name="contact_type" value="個人" checked> 個人買取
          </label>
          <label class="radio-option">
            <input type="radio" name="contact_type" value="法人"> 法人
          </label>
        </div>
      </div>

      <!-- ▼ 個人フォーム -->
      <div class="individual-fields">
        <div class="form-group">
          <label for="name">お名前 <span>*</span></label>
          <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
          <label for="kana">フリガナ <span>*</span></label>
          <input type="text" name="kana" id="kana" required pattern="^[ァ-ヶー　]+$" title="全角カタカナで入力してください">
        </div>
        <div class="form-group">
          <label>都道府県</label>
          <input type="text" name="prefecture">
        </div>
        <div class="form-group">
          <label>市区町村</label>
          <input type="text" name="city">
        </div>
        <div class="form-group">
          <label>番地・建物名</label>
          <input type="text" name="address_detail">
        </div>
        <div class="form-group">
          <label for="phone">電話番号 <span>*</span></label>
          <input type="tel" name="phone" id="phone" required pattern="^\d{10,11}$" title="ハイフンなしで入力してください">
        </div>
        <div class="form-group">
          <label for="email">メールアドレス <span>*</span></label>
          <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
          <label for="email_confirm">メールアドレス（確認） <span>*</span></label>
          <input type="email" name="email_confirm" id="email_confirm" required>
        </div>
        <div class="form-group">
          <label>画像添付（最大4枚）</label>
          <input type="file" name="images[]" multiple accept="image/*">
        </div>
      </div>

      <!-- ▼ 法人フォーム -->
      <div class="corporate-fields" style="display: none;">
        <div class="form-group">
          <label for="company">会社名 <span>*</span></label>
          <input type="text" name="company" id="company">
        </div>
        <div class="form-group">
          <label for="corp_person">担当者名 <span>*</span></label>
          <input type="text" name="corp_person" id="corp_person">
        </div>
        <div class="form-group">
          <label for="corp_kana">フリガナ <span>*</span></label>
          <input type="text" name="corp_kana" id="corp_kana" pattern="^[ァ-ヶー　]+$" title="全角カタカナで入力してください">
        </div>
        <div class="form-group">
          <label for="corp_phone">電話番号 <span>*</span></label>
          <input type="tel" name="corp_phone" id="corp_phone" pattern="^\d{10,11}$" title="ハイフンなしで入力してください">
        </div>
        <div class="form-group">
          <label for="corp_email">メールアドレス <span>*</span></label>
          <input type="email" name="corp_email" id="corp_email">
        </div>
        <div class="form-group">
          <label for="corp_email_confirm">メールアドレス（確認） <span>*</span></label>
          <input type="email" name="corp_email_confirm" id="corp_email_confirm">
        </div>
      </div>

      <input type="hidden" name="recaptcha_token" id="recaptcha_token">

      <div class="form-group">
        <label for="message">お問い合わせ内容</label>
        <textarea name="message" id="message" rows="5"></textarea>
      </div>

      <div class="form-submit">
        <button type="submit">送信する</button>
      </div>
    </form>
  </div>

  <script>
    const typeRadios = document.querySelectorAll('input[name="contact_type"]');
    const individualFields = document.querySelector('.individual-fields');
    const corporateFields = document.querySelector('.corporate-fields');

    function toggleFields() {
      const contactType = document.querySelector('input[name="contact_type"]:checked').value;
      const isCorp = contactType === '法人';

      individualFields.style.display = isCorp ? 'none' : 'block';
      corporateFields.style.display = isCorp ? 'block' : 'none';

      // 個人：required切替
      document.querySelectorAll('.individual-fields input, .individual-fields select, .individual-fields textarea').forEach(el => {
        el.required = !isCorp;
      });

      // 法人：required切替
      document.querySelectorAll('.corporate-fields input, .corporate-fields select, .corporate-fields textarea').forEach(el => {
        el.required = isCorp;
      });
    }

    typeRadios.forEach(radio => {
      radio.addEventListener('change', toggleFields);
    });

    // 初期状態を反映（ページロード時）
    document.addEventListener('DOMContentLoaded', toggleFields);

    // フロント側バリデーション
    document.querySelector("form").addEventListener("submit", function (e) {
      const contactType = document.querySelector('input[name="contact_type"]:checked').value;
      let email = '', confirm = '', kana = '', phone = '';

      if (contactType === '個人') {
        email = document.getElementById('email').value;
        confirm = document.getElementById('email_confirm').value;
        kana = document.getElementById('kana').value;
        phone = document.getElementById('phone').value;
      } else {
        email = document.getElementById('corp_email').value;
        confirm = document.getElementById('corp_email_confirm').value;
        kana = document.getElementById('corp_kana').value;
        phone = document.getElementById('corp_phone').value;
      }

      let hasError = false;
      let errorMsg = '';

      if (email !== confirm) {
        errorMsg += "メールアドレスが一致しません。\n";
        hasError = true;
      }
      if (!kana.match(/^[ァ-ヶー　]+$/)) {
        errorMsg += "フリガナは全角カタカナで入力してください。\n";
        hasError = true;
      }
      if (!phone.match(/^\d{10,11}$/)) {
        errorMsg += "電話番号はハイフンなしの10〜11桁の数字で入力してください。\n";
        hasError = true;
      }
      if (!email.match(/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/)) {
        errorMsg += "有効なメールアドレス形式で入力してください。\n";
        hasError = true;
      }

      if (hasError) {
        alert(errorMsg);
        e.preventDefault();
      }
    });
  </script>
</body>
</html>

<?php get_footer(); ?>
