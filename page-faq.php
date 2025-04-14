<?php
/* Template Name: よくある質問 */
get_header();
?>
<div class="pagefaq-section">  
  <h1>よくある質問</h1>
  <div class="faq-list">

    <h2 class="pagefaq-category">出張買取について</h2>
    <?php
    $faqs_pickup = [
      ["出張費や査定、運び出しに費用はかかりますか？", "出張費、査定、運び出しに費用はかかりません。"],
      ["急ぎなのですが、当日でも出張買取をお願いできますでしょうか？", "スケジュールによりますが、可能な限り対応いたします。"],
      ["エアコンの取り外しも可能でしょうか？", "エアコンの取り外しも対応しております。"],
      ["運び出しのお手伝いは必要ですか？", "運び出しはスタッフが行うのでご安心ください。"],
      ["当日の流れはどうなりますか？", "ご予約 → 訪問 → 査定 → 現金お支払い、の流れになります。"]
    ];
    foreach ($faqs_pickup as $index => $faq) :
    ?>
    <div class="faq-item">
      <button class="faq-question" data-index="pickup-<?php echo $index; ?>">
        Q. <?php echo esc_html($faq[0]); ?>
        <span class="toggle-icon">＋</span>
      </button>
      <div class="faq-answer"><?php echo esc_html($faq[1]); ?></div>
    </div>
    <?php endforeach; ?>

    <h2 class="faq-category">買取対象について</h2>
    <?php
    $faqs_items = [
      ["どんなものでも引き取りできますか？", "液体・生もの以外は基本的に引き取り可能です。買取、無料回収、有料回収の３つからご案内いたします。"],
      ["買取できないものはありますか？", "一部対象外もありますが、まずはお気軽にご相談ください。"],
      ["壊れていても買取できますか？", "動作状況によりますが、買取または無料回収で対応可能な場合があります。"],
      ["古い家電でも買取してもらえますか？", "古い家電でもモデルや状態により買取可能なことがあります。ご相談ください。"]
    ];
    foreach ($faqs_items as $index => $faq) :
    ?>
    <div class="faq-item">
      <button class="faq-question" data-index="item-<?php echo $index; ?>">
        Q. <?php echo esc_html($faq[0]); ?>
        <span class="toggle-icon">＋</span>
      </button>
      <div class="faq-answer"><?php echo esc_html($faq[1]); ?></div>
    </div>
    <?php endforeach; ?>

    <h2 class="faq-category">市区町村・エリアについて</h2>
    <?php
    $faqs_area = [
      ["どの地域まで出張買取してくれますか？", "埼玉県・東京都を中心に、近隣エリアまで対応しています。詳細は対応エリアページをご覧ください。"],
      ["地方でも対応してもらえますか？", "一部対応できない地域もございますが、まずはお問い合わせください。"]
    ];
    foreach ($faqs_area as $index => $faq) :
    ?>
    <div class="faq-item">
      <button class="faq-question" data-index="area-<?php echo $index; ?>">
        Q. <?php echo esc_html($faq[0]); ?>
        <span class="toggle-icon">＋</span>
      </button>
      <div class="faq-answer"><?php echo esc_html($faq[1]); ?></div>
    </div>
    <?php endforeach; ?>

    <h2 class="faq-category">その他</h2>
    <?php
    $faqs_other = [
      ["土日や祝日も対応していますか？", "基本的に年中無休で対応しております。"],
      ["出張買取に必要なものはありますか？", "ご本人確認書類（免許証など）をご準備ください。"],
      ["支払いは現金ですか？", "その場で現金でお支払いします。"]
    ];
    foreach ($faqs_other as $index => $faq) :
    ?>
    <div class="faq-item">
      <button class="faq-question" data-index="other-<?php echo $index; ?>">
        Q. <?php echo esc_html($faq[0]); ?>
        <span class="toggle-icon">＋</span>
      </button>
      <div class="faq-answer"><?php echo esc_html($faq[1]); ?></div>
    </div>
    <?php endforeach; ?>

  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    $(".faq-question").click(function(){
        var parent = $(this).closest(".faq-item");
        var answer = parent.find(".faq-answer");
        var icon = $(this).find(".toggle-icon");

        if(parent.hasClass("active")) {
            answer.slideUp(300);
            icon.removeClass("open");
            parent.removeClass("active");
        } else {
            $(".faq-answer").slideUp(300);
            $(".faq-item").removeClass("active");
            $(".toggle-icon").removeClass("open");

            answer.slideDown(300);
            icon.addClass("open");
            parent.addClass("active");
        }
    });
});
</script>

<?php get_footer(); ?>