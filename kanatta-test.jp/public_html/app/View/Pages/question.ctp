<!-- よくある質問ページ -->
<div class="about_box clear">
	<h1>よくある質問</h1>
    <div class="guide-kanako">
		<a href="<?php echo $this->Html->url('/contact') ?>"><img src="img/guide_kanako.png" alt="guide"></a>
	</div>

	<div class="box">
    	<label for="inbox1">支援方法はなにがありますか?</label>
    	<input type="checkbox" id="inbox1" class="on-off">
    	<div>
    		クレジットカード、コンビニ、銀行振込、ビットコインがご利用いただけます。<br>
 			※振込等の手数料は支援者の負担となります。<br>
 			※利用料の支払いは、プロジェクト成立後確定した支援総額から差し引くことにより行われます。<br>
    		女性であれば個人、団体、年齢問わずお申込みすることができます。<br>
    	</div>
    	<label for="inbox2">購入状況を確認できますか?</label>
    	<input type="checkbox" id="inbox2" class="on-off">
    	<div>
    		トップページからログインしていただき、「マイページ」の「支援した」をクリックします。<br>
    		購入状況(支援したプロジェクト）を確認することができます。<br>
    	</div>
    	<label for="inbox3">支援の内容を変更したいです。</label>
    	<input type="checkbox" id="inbox3" class="on-off">
    	<div>
    		選択したリターンの変更・キャンセル・返金は一切受け付けておりません。<br>
			ご自身でよくご検討の上、支援頂くようお願いいたします。<br>
    	</div>
    	<label for="inbox4">支援予約をキャンセルできますか?</label>
    	<input type="checkbox" id="inbox4" class="on-off">
    	<div>
    		選択したリターンの変更・キャンセル・返金は一切受け付けておりません。<br>
			リターンの変更・キャンセル・返金は各起案者が個別に対応するものとし、<br>
			当社に支援者からリターンの変更・キャンセル・返金の要求などがあった場合も、<br>
			各起案者へ直接問い合わせるように案内するものとします。<br>
    	</div>
    	<label for="inbox5">支援したプロジェクトが成立しなかった場合、いつ返金されますか？支援金はどうなりますか？</label>
    	<input type="checkbox" id="inbox5" class="on-off">
    	<div>
    		・クレジットカード決済の場合<br>
            支援金の決済は行われません。<br><br>

            ・コンビニ決済や銀行振込の場合<br>
            口座に返金致します。<br>
    	</div>
    	<label for="inbox6">誰でも申し込むことはできますか?</label>
    	<input type="checkbox" id="inbox6" class="on-off">
    	<div>
    		女性のみ申し込むことができます。<br>
 			女性であれば個人、団体、年齢問わずお申込みすることができます。<br>
    	</div>
    	<label for="inbox7">手数料はかかりますか?</label>
    	<input type="checkbox" id="inbox7" class="on-off">
    	<div>
    		手数料は達成した支援金総額の12%です。<br><br>

            コンサルティングプランを導入したい場合は、<br>
             ・コンサルティング料 +3%<br>
             ・画像やPR動画などのコンテンツ料(以下、コンテンツ料) +5%<br>
             ・コンサルティング料とコンテンツ料の両方 +8%<br>
             が追加となります。<br>
    	</div>
    	<label for="inbox8">目標金額の設定に制限はありますか？</label>
    	<input type="checkbox" id="inbox8" class="on-off">
    	<div>
        	現状、1円～1000万円としています。<br>
			適切な金額をKanattaスタッフと相談しながら決めて頂けたらと思います。<br>
    	</div>
    	<label for="inbox9">掲載後に目標金額や募集期間の変更はできますか？</label>
    	<input type="checkbox" id="inbox9" class="on-off">
    	<div>
        	いずれもできません。<br>
 			目標金額を期間内に達成した場合等、さらに支援を伸ばしていきたい時は、<br>
 			担当のKanattaスタッフにお問い合わせください。<br>
    	</div>
    	<label for="inbox10">振込先の銀行口座情報を変更したいのですが。</label>
    	<input type="checkbox" id="inbox10" class="on-off">
    	<div>
        	契約書に記載されている口座を変更する必要があるため、<br>
        	担当Kanattaスタッフにご連絡ください。<br>
    	</div>
    	<label for="inbox11">プロジェクトが成立した後、いつ入金されるのでしょうか？</label>
    	<input type="checkbox" id="inbox11" class="on-off">
    	<div>
        	・支援募集終了月の15日までに達成した場合 <br>
            　→翌月の5日までにお支払いいたします。 <br><br>
            　
            ・支援募集終了月の15日以降に達成した場合<br>
            　→翌月20日までにお支払いいたします。<br>
    	</div>
    	<label for="inbox12">担当のKanattaスタッフの方に連絡を取りたいのですが、営業時間はいつでしょうか。</label>
    	<input type="checkbox" id="inbox12" class="on-off">
    	<div>
        	平日の9時～20時です。<br>
        	土日祝日は対応しかねますので、平日にご連絡いただければ幸いです。<br>
    	</div>
    	<label for="inbox13">対応しているブラウザは何ですか？</label>
    	<input type="checkbox" id="inbox13" class="on-off">
    	<div>
        	Chrome、Safari、IE、Firefoxは動作確認しています。<br>
    	</div>
    </div>
</div>
<style>
.about_box h1{
    font-size: 24px;
}
.about_box.clear{
    background: none;
}
.box label{
    background: #fff;
    display: block;
    padding: 10px;
    margin-bottom: 5px;
    cursor: pointer;
    width: 80%;
    margin: 30px auto 14px auto;
    font-size: 17px;
}

.box input[type="checkbox"].on-off,
.box input[type="checkbox"].on-off +div{
	display: none;
}

.box input[type="checkbox"].on-off:checked +div{
	display: block;
}

.box div{
	margin: 0 0 20px;
    width: 77%;
    margin: 20px auto;
    font-size: 14px;
}
.guide-kanako{
    position: fixed;
    right: 0px;
    bottom: 70px;
    z-index: 99;
}
.guide-kanako img{
    width: 180px;
}
@media only screen and (max-width : 749px) {
    .box label {
        padding: 8px;
        margin-bottom: 4px;
        margin: 25px auto 12px auto;
        font-size: 13px;
    }
    .guide-kanako img {
        width: 120px;
    }
    .box div {
        width: 77%;
        margin: 10px auto;
        font-size: 12px;
    }
}
</style>