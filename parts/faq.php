<html>
    <div class="faq-section">
        <h2>よくある質問</h2>
        <div class="faq-list">
            <?php
            $faqs = [
                ["question" => "出張費や査定、運び出しに費用はかかりますか？", "answer" => "出張費、査定、運び出しに費用はかかりません。"],
                ["question" => "どんなものでも引き取りできますか？", "answer" => "液体・生もの以外は基本的に引き取り可能です。買取、無料回収、有料回収の３つからご案内いたします。"],
                ["question" => "急ぎなのですが、当日でも出張買取をお願いできますでしょうか？", "answer" => "スケジュールによりますが、可能な限り対応いたします。"],
                ["question" => "エアコンの取り外しも可能でしょうか？", "answer" => "エアコンの取り外しも対応しております。エアコンの商品情報、取付状態によっては工賃が無料になります。"],
                ["question" => "運び出しのお手伝いは必要ですか？", "answer" => "運び出しは当店のスタッフが行いますのでお手伝いはご不要です。"]
            ];
            foreach ($faqs as $index => $faq) : 
            ?>
                <div class="faq-item">
                    <button class="faq-question" data-index="<?php echo $index; ?>">
                        Q. <?php echo $faq["question"]; ?>
                        <span class="toggle-icon">+</span>
                    </button>
                    <div class="faq-answer"><?php echo $faq["answer"]; ?></div>
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
                answer.slideUp(300); // 300msで閉じる
                icon.removeClass("open");
                parent.removeClass("active");
            } else {
                $(".faq-answer").slideUp(300); // 他の回答を閉じる
                $(".faq-item").removeClass("active");
                $(".toggle-icon").removeClass("open");

                answer.slideDown(300); // 300msで開く
                icon.addClass("open");
                parent.addClass("active");
            }
        });
    });
    </script>
</html>