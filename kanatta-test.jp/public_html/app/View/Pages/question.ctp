<!-- よくある質問ページ -->
<div class="about_box clear">
	<h1>よくある質問</h1>
	<div class="box">
    	<label for="inbox1">誰でも申し込むことができますか？</label>
    	<input type="checkbox" id="inbox1" class="on-off">
    	<div>
    		女性のみ申し込むことができます。<br>
    		女性であれば個人、団体、年齢問わずお申込みすることができます。
    	</div>
    	<label for="inbox2">アイデアしかありません。クラウドファンディングは初めてですが、挑戦可能でしょうか。</label>
    	<input type="checkbox" id="inbox2" class="on-off">
    	<div>
    		まずはアイデアがあればご相談ください。<br>
            アシスタントをつけることが可能ですので、必要な情報を確認しながら一緒にアイデアを形にしていきましょう。<br>
            アシスタントの費用はプロジェクトが成功しない限り費用は1円も発生しません。経費の心配なく挑戦できます。<br>
            アイデアやプロジェクトが明確な方は、そのままプロジェクトの申請にお進みください。<br>
    	</div>
    	<label for="inbox3">プロジェクトを公開するためにどのくら費用がかかりますか？</label>
    	<input type="checkbox" id="inbox3" class="on-off">
    	<div>
    		プロジェクトの公開は無料で行なえます。プロジェクトが不成立の場合は手数料等かかりませんので、安心して始めてください。<br>
    	</div>
    	<label for="inbox4">それほど知り合いが多くないため、支援者が集まるか不安です。</label>
    	<input type="checkbox" id="inbox4" class="on-off">
    	<div>
    		おっしゃる通り、起案者の知り合いの多さはプロジェクトを成功させる上でとても重要です。<br>
			コンサルタントと具体的にどうすればいいか相談しながら進めていきましょう。
    	</div>
    	<label for="inbox5">目標金額の設定に制限はありますか。</label>
    	<input type="checkbox" id="inbox5" class="on-off">
    	<div>
    		制限はございません。
			基本的には『All or Nothing型』のため必要最低限かつ達成可能な金額を設定されることを推奨します。
    	</div>
    	<label for="inbox6">手数料はかかりますか？</label>
    	<input type="checkbox" id="inbox6" class="on-off">
    	<div>
    		システム利用料は、達成金額の12%です。
    		コンサルタントをつけると+3%、画像などのコンテンツも含めると+8%です。
    	</div>
    	<label for="inbox7">プロジェクトが成立しなかった場合は、支援金やリターンはどうなりますか？</label>
    	<input type="checkbox" id="inbox7" class="on-off">
    	<div>
    		「All or Nothing型」の場合は、支援金額が目標金額に集まらなければ、全額支援者様に返金されます。<br>
			「All-In型」の場合は、目標金額にかかわらず、期日前に集まった全額が起案者様に支払われます。支援者様には返金されません。<br>
			ただし、All-In型の場合は、イベント等の実施が決まっていたり、リターンが約束されていなければ審査が通りません。<br>
    	</div>
    	<label for="inbox8">支援したいプロジェクトがありますが、成功するかどうかわかりません。<br>
							仮に失敗した場合は、お金は戻ってくるのでしょうか。</label>
    	<input type="checkbox" id="inbox8" class="on-off">
    	<div>
        	「All or Nothing型」もしくは「All-In型」とあります。<br>
            「All or Nothing型」の場合は、支援金額が目標金額に集まらなければ、全額支援者様に返金されます。<br>
            「All-In型」の場合は、目標金額にかかわらず、期日前に集まった全額が起案者様に支払われます。支援者様には返金されません。<br>
            ただし、All-In型の場合は、イベント等の実施は決まっている上での募集のため、基本的にリターンは受けられます。
    	</div>
    </div>
</div>
<style>
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
    margin: 25px auto;
    font-size: 1.5vw;
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
    font-size: 1.4vw;
}
</style>