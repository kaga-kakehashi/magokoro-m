<?php
/* Template Name: よくある質問 */
get_header();
?>

<h1>よくある質問</h1>

<div class="faq-section">
    <div class="faq-list">
        <?php
        // 質問データ（ここに全部書いてOK）
        $faqs = [
            ["question" => "出張費や査定、運び出しに費用はかかりますか？", "answer" => "出張費、査定、運び出しに費用はかかりません。"],
            ["question" => "どんなものでも引き取りできますか？", "answer" => "液体・生もの以外は基本的に引き取り可能です。買取、無料回収、有料回収の３つからご案内いたします。"],
            ["question" => "急ぎなのですが、当日でも出張買取をお願いできますでしょうか？", "answer" => "スケジュールによりますが、可能な限り対応いたします。"],
            ["question" => "エアコンの取り外しも可能でしょうか？", "answer" => "エアコンの取り外しも対応しております。"],
            ["question" => "運び出しのお手伝いは必要ですか？", "answer" => "運び出しはスタッフが行うのでご安心ください。"],
            ["question" => "買取できないものはありますか？", "answer" => "一部対象外もありますが、まずはお気軽にご相談ください。"],
            ["question" => "当日の流れはどうなりますか？", "answer" => "ご予約 → 訪問 → 査定 → 現金お支払い、の流れになります。"],
        ];

        foreach ($faqs as $index => $faq) :
        ?>
        <div class="faq-item">
            <button class="faq-question" data-index="<?php echo $index; ?>">
                Q. <?php echo esc_html($faq["question"]); ?>
                <span class="toggle-icon">＋</span>
            </button>
            <div class="faq-answer"><?php echo esc_html($faq["answer"]); ?></div>
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
