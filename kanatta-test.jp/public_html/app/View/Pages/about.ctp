<?php echo $this->Html->css('top', null, array('inline' => false)) ?>
<?php echo $this->Html->css('about', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid_report', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<?php if($smart_phone): ?>
    <?php echo $this->Html->css('sp/grid_sp', null, array('inline' => false)) ?>
<?php endif ?>

<?php echo $this -> Html -> script( 'jquery-2.1.0.min', array( 'inline' => false ) ); ?>
<?php echo $this -> Html -> script( 'jquery.mangaviewer', array( 'inline' => false ) ); ?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$(document).ready(function() {
        // 漫画ビュアープロパティ
        $('#viewer').mangaviewer({
            page: 7,   //ページ数
            path: 'img/manga', //ディレクトリパス
            ext: 'jpg', //拡張子
            page_ejection: 'right' //ページ送り
        });
    });
<?php $this->Html->scriptEnd(); ?>

<div class="aboutpage">
    <div class="about_box-pjt">
	    <div class="about_box">
        	<div class="pc-display">
            	<div class="imgholder">
            		<?php echo $this->Html->image('about/logo-bg.png') ?>
            		<p>とは？</p>
            	</div>
        	</div>
        </div>
    </div>

    <div class="about-start">
        <span class="about-kanako4"><?php echo $this->Html->image('common/kanako4.png') ?></span>
    	<p><span style="color:#dc5d78;">Kanatta</span>は、女性のためのクラウドファンディングです。</p>
    </div>

    <div class="about_content" name="0">
		<h3>Kanattaでどうなるの？</h3>
		<?php if(!$smart_phone): ?>
    		<div id="viewer-area">
    			<div id="viewer"></div>
    		</div>
    	<?php else: ?>
    		<div id="viewer-area-sp">
    			<div id="viewer-sp">
    				<ul>
    					<li><?php echo $this->Html->image('manga/1.jpg') ?></li>
    					<li><?php echo $this->Html->image('manga/2.jpg') ?></li>
    					<li><?php echo $this->Html->image('manga/3.jpg') ?></li>
    					<li><?php echo $this->Html->image('manga/4.jpg') ?></li>
    					<li><?php echo $this->Html->image('manga/5.jpg') ?></li>
    					<li><?php echo $this->Html->image('manga/6.jpg') ?></li>
    					<li><?php echo $this->Html->image('manga/7.jpg') ?></li>
    				</ul>
    				<span class="guide">右へスライド→</span>
    			</div>
    		</div>
    	<?php endif ?>
    </div>

    <div class="lets-start">
        <div class="wrap-s">
        	<p>わたしもやってみる！</p>
        	<a href="<?php echo $this->Html->url('/select') ?>"><span class="lets-try">プロジェクトを始める</span></a><a href="<?php echo $this->Html->url('/projects') ?>" class="a-about"><span class="lets-about">プロジェクトを見てみる</span></a>
        	<span class="lets-kanako1"><?php echo $this->Html->image('common/kanako1.png') ?></span>
		</div>
    </div>

    <div class="about-content about_content1" name="0">
		<h3>Kanattaの想い</h3>
		<div class="left col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?php echo $this->Html->image('common/kanako3r.png') ?>
		</div>
		<div class="right col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<p class="yume-kanatta">夢が叶った　×　理想に適った</p>
			<p class="kanatta-logo"><?php echo $this->Html->image('common/kanatta_logo_txt.png') ?></p>
			<div class="text">
				Kanattaは女性の社会進出を応援していくために、女性エンジニアチームを結成し、立ち上げたサービスです。<br>
				<br>
                大きな夢への挑戦や日常のささいなことを解決したいことまで幅広く使ってたくさんの
                <span style="font-size: 2.3vw; color:#dc5d78;">「かなった」</span>を実現していただけたら幸いです。
			</div>
		</div>
    </div>
    <div class="wrap-fff">
        <div class="about-content about_content2 about-cfd">
        	<h3>クラウドファンディングってなに？</h3>
    		<?php echo $this->Html->image('about/cfd-exp.png') ?>

        	<div class="right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    	    	<div class="text">
    				クラウドファンディング(CrowdFunding)<br>
    				＝群衆（crowd) × 資金調達(funding)<br>
    				<br>
    				「女性の自立や働き方についての講演」というイベントを開催したい、「ネイルのお店を出したい」など、<br>
    				叶えたい想いを実現するために、たくさんの人からお金を集める仕組みです。<br>
    				アイデアやプロジェクトを持つ人（起案者）が、インターネットを通じて呼びかけて、共感した人が出資し支援をしていく（支援者）ことで、実現していきます。
    			</div>

        	</div>
            <div class="left col-lg-4 col-md-4 col-sm-4 col-xs-4">
        		<?php echo $this->Html->image('common/kanako5.png') ?>
        	</div>
        </div>
    </div>

    <div class="about_content about_content1 about_content3">
		<h3>アイデアやプロジェクトを持つ起案者</h3>
		<div class="left col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?php echo $this->Html->image('common/ladys.png') ?>
		</div>
		<div class="right col-lg-8 col-md-8 col-sm-8 col-xs-8">
			アイデアやプロジェクトを立ち上げて実現していく人＝起案者<br>
			アイデアやプロジェクトは何でもok/プロジェクトの立ち上げ自体は無料です。<br>
			プロジェクト達成したときは、達成金額の12～20%をKanattaに支払う必要ありますが、<br>
			達成した場合のみなので、ノーリスク・ハイリターンでチャレンジできます<br>
		</div>
	</div>

    <div class="wrap-fff">
    	<div class="about_content about_content2 about_content4">
        	<div class="right col-lg-8 col-md-8 col-sm-8 col-xs-8">
    	    	<div class="text">
    				活動をアピールする中で、活動を応援してくれる人が現れます。<br>
    				プロジェクトの内容によっては、メディアに注目されたり、大手出版社の取材を受けることなどもありえるかもしれません。<br>
    				プロジェクトを通して何を得たいのか、どういった事を実現していきたいのかをイメージしながら、<br>
    				『立ち上げ（プロジェクト作成の流れ）』の流れに沿って実行してください。<br>
    			</div>

        	</div>
            <div class="left col-lg-4 col-md-4 col-sm-4 col-xs-4">
        		<?php echo $this->Html->image('common/kanako6.png') ?>
        	</div>
    	</div>
	</div>

	<div class="about_content about_content1 pjt-flow about_content5">
    	<h3>プロジェクト作成の流れ</h3>
    	<p>プロジェクトの起案者は、以下の流れで実行します。</p>
    	<ul class="flow-img">
    		<li><?php echo $this->Html->image('about/create1.png') ?><p>企画</p></li>
    		<li><?php echo $this->Html->image('about/create2.png') ?><p>作成</p></li>
    		<li><?php echo $this->Html->image('about/create3.png') ?><p>審査</p></li>
    		<li><?php echo $this->Html->image('about/create4.png') ?><p>公開</p></li>
    		<li><?php echo $this->Html->image('about/create5.png') ?><p>報告</p></li>
    		<li><?php echo $this->Html->image('about/create6.png') ?><p>達成</p></li>
    		<li><?php echo $this->Html->image('about/create7.png') ?><p>実行</p></li>
    	</ul>
    	<ul class="flow-txt">
    		<li><span>企画</span>コンセプト、タイトル、目標金額、開催期間、リターンの内容を決定</li>
    		<li><span>作成</span>考えたプロジェクトをKanattaに投稿、作成</li>
    		<li><span>審査</span>Kanattaに適している内容か、企画の信憑性や実効性などを審査</li>
	   		<li><span>公開</span>作成したプロジェクトが公開</li>
    		<li><span>報告</span>掲載期間中、こまめに活動の報告、支援者のフォローアップ</li>
    		<li><span>達成</span>達成した金額から手数料を引いた分を受領</li>
    		<li><span>実行</span>プロジェクトの実行と支援者の方へリターンを送付</li>
       	</ul>
    </div>

    <div class="lets-start">
    	<div class="wrap-s">
        	<p>わたしもやってみる！</p>
        	<a href="<?php echo $this->Html->url('/select') ?>"><span class="lets-try">プロジェクトを始める</span></a><a href="<?php echo $this->Html->url('/projects') ?>" class="a-about"><span class="lets-about">プロジェクトを見てみる</span></a>
        	<span class="lets-kanako1"><?php echo $this->Html->image('common/kanako1.png') ?></span>
        </div>
    </div>

    <div class="about_content about_content1 about_content6">
		<h3>プロジェクトを支援するサポーター</h3>
    	<p>起案者が立ち上げたプロジェクトに対して出資支援する人を支援者（サポーター）と言います。</p>
    	<div class="con-supporter">
    		<img src="../img/about/supporter.png">
    		<p>サポーター</p>
    		<div class="s1">いいね！</div>
	   		<div class="s2">おもしろそう♪</div>
	   		<div class="s3">ぜひやってほしい！</div>
	   		<div class="img-supporter"><img src="../img/common/kanako2.png"></div>
    	</div>
    	<p>興味がある、応援したいプロジェクトがあれば、少額からでも支援してみましょう</p>
	</div>

    <div class="wrap-fff">
        <div class="about_content about_content2 about_content7">
    		<h3>Kanattaの魅力</h3>
    		<div class="point">
    			<div class="point123">女性のための<br>クラウドファンディング</div>
    			<p>女性専用だからこそ<br>共感が得やすい</p>
    		</div>
    		<div class="point">
        		<div class="point123">相談役の存在</div>
        		<p>まったくわからなくても安心<br>0からアシストがある</p>
        	</div>
        	<div class="point">
        		<div class="point123">リアルクラウドファンディング</div>
        		<p>リアルの場で<br>直接想いをプレゼンできる</p>
        	</div>
    		<div>
    			<?php echo $this->Html->image('common/ladys.png') ?>
    		</div>
    	</div>
    </div>

    <div class="about_content about_content1 about_content8">
		<h3>よくある質問</h3>
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
				相談役と具体的にどうすればいいか相談しながら進めていきましょう。
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
        		相談役をつけると+3%、画像などのコンテンツも含めると+8%です。
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

    <div class="lets-start">
        <div class="wrap-s">
        	<p>まずやってみる！</p>
        	<a href="<?php echo $this->Html->url('/select') ?>"><span class="lets-try">プロジェクトを始める</span></a><a href="<?php echo $this->Html->url('/projects') ?>" class="a-about"><span class="lets-about">プロジェクトを見てみる</span></a>
        	<span class="lets-kanako1"><?php echo $this->Html->image('common/kanako1.png') ?></span>
		</div>
    </div>
</div>

<style>
.wrap-fff{
    background: #fff;
}
.aboutpage{
    margin-top: -38px;
}
.aboutpage .about_box {
    position: relative;
    margin: 0 auto;
    width: 100%;
    max-width: 1500px;
    height: 58vw;
    background-size: contain;
    background-image: url(../img/top/top-img.png);
    background-position-x: center;
    background-position-y: initial;
    background-attachment: initial;
    background-repeat: no-repeat;
    background-color: rgba(255,255,255,0);
}

.aboutpage .about_box:before {
    content: "";
    position: absolute;
    width: 100%;
    left: 0;
    top: 0;
    z-index: 0;
}
span.about-kanako4{
    position: absolute;
    bottom: 80%;
    right: 10%;
}
.aboutpage .about_box-pjt{
	height: 100%;
    overflow: hidden;
}
.aboutpage .about-start{
    height: 170px;
    background-color: #fff;
    text-align: center;
    padding: 50px;
    position: relative;
}
.aboutpage h3{
    font-size: 3vw;
    padding-bottom: 30px;
}
.aboutpage .about_content1{
    margin-top: 0px;
    padding-bottom: 30px;
    padding: 50px;
    height: 55vw;
}
.about_content1.about_content8{
    height: auto;
}
.aboutpage .about_content2{
    height: 65vw;
    background-color: #fff;
    text-align: center;
    padding-top: 35px;
    position: relative;
}
.about_content1.about_content3,
.about_content2.about_content4{
    height: 43vw;
}
.about_content2.about_content7{
    height: 48vw;
}
.about_content2.about-cfd img{
    width: 45vw;
}

.aboutpage .about_content ul li{
    display: inline-block;
    list-style: none;
}
.aboutpage .about_content ul li img{
    width: 9vw;
}
.about_content.about_content1 .con-supporter .s1,
.about_content.about_content1 .con-supporter .s2,
.about_content.about_content1 .con-supporter .s3{
    background-color: #fff;
    display: inline-block;
    position: absolute;
    padding: 15px;
    border-radius: 15px;
    font-size: 1.5vw;
}
.about_content.about_content1 .con-supporter{
    position: relative;
}
.about_content.about_content1 .con-supporter .s1{
    top: 10%;
    left: 20%;
}
.about_content.about_content1 .con-supporter .s2{
    top: 33%;
    left: 40%;
}
.about_content.about_content1 .con-supporter .s3{
    top: 60%;
    left: 30%;
}
.about_content.about_content1 .con-supporter img{
    width: 225px;
    margin-left: 10%;
    margin-top: 10%;

}
.about_content.about_content1 .con-supporter p{
    text-align: left;
    display: block;
    margin-left: 14%;
}
.about_content.about_content1 .con-supporter .img-supporter{
    position: absolute;
    display: inline-block;
    top: 0;
    right: 10%;
}
.about_content.about_content1 .con-supporter .img-supporter img{
    width: 90%;
}
.about_content.about_content2 .point{
    display: inline-table;
    width: 30%;
}
.about_content.about_content2 .point123{
    height: 90px;
    text-align: left;
    border: solid 4px #dc5d78;
    border-radius: 20px;
    padding: 10px;
    margin: 20px;
    vertical-align: middle;
}
.about_content .point p{
    text-align: left;
}

.pc-display{
	position: absolute;
    width: 100%;
    left: 4.8%;
    margin-top: 6%;
    height: 56%;
    max-height: 500px;
}
.pc-display .imgholder img{
    width: 25vw;
    margin-left: 25%;
    margin-top: 6%;
    display: block;
    max-width: 100%;
    height: auto;
    padding-top: 50px;
}
.pc-display .imgholder{
    margin-top: -3%;
}
.pc-display .imgholder p{
    font-size: 4vw;
    text-align: center;
    margin-top: 27px;
}

.aboutpage .left img{
    width: 18vw;
}
.aboutpage .text{
    font-size: 1.7vw;
    margin-top: 26px;
    text-align: left;
}
.aboutpage .right{
    background-color: #fff;
    border-radius: 25px;
    padding: 40px;
    font-size: 1.7vw;
}
.aboutpage .right:before{
    content: "";
    position: absolute;
    top: 50%;
    left: -95px;
    margin-top: -15px;
    border: 50px solid transparent;
    border-right: 50px solid #fff;
}
.aboutpage .right p.kanatta-logo img{
    width: 22vw;
}
.aboutpage .about_content1 p{
    text-align: center;
}
.aboutpage .about_content1.pjt-flow ul.flow-img{
    padding: 0;
    text-align: center;
    background-color: #fff;
    position: relative;
}
.aboutpage .about_content1.pjt-flow ul.flow-img:after{
    content: "";
    position: absolute;
    top: -8vw;
    right: -18vw;
    border: 13vw solid transparent;
    border-left: 13vw solid #fff;
}
.about_content.about_content1.pjt-flow ul.flow-img li p{
    color: #dc5d78;
    font-size: 2vw;
}
.about_content.about_content1.pjt-flow ul.flow-txt{
    width: 68%;
    margin: 25px auto;
    padding-left: 0;
}
.about_content.about_content1.pjt-flow ul.flow-txt li{
    font-size: 1.5vw;
    width: 83%;
}
.about_content.about_content1.pjt-flow ul.flow-txt li span{
    color: #dc5d78;
    margin: 0 10px;
}
.aboutpage .about_content1.pjt-flow{
    height: 47vw;
}

/* mangaviewer css */
#viewer-area{
    width: 100%;
    margin: auto;
}
#viewer .sheet{
    width: 100%;
    text-align: center;
    height: 55vw;
}
#viewer img{
    width: 40%;
    cursor:pointer;
}

#viewer #page-link{
    clear:both;
    text-align:center;
}
#viewer #page-link .btn.active{
    border: inset 2px #ffe6f9;
    background-color: #dc5d78;
}
#viewer .btn-toolbar .btn-group{
    float: none;
    margin-bottom: 14px;
}
#viewer-sp ul{
    overflow-x: auto;
    overflow-y: hidden;
    width: 96%;
    white-space: nowrap;
    margin-top: 0;
    padding-left: 0;
}
#viewer-sp ul li{
    display: inline-block;
    list-style: none;
    margin-right: 1%;
    vertical-align: top;
    white-space: normal;
}
#viewer-sp ul li img{
    width: 100%;
}
#viewer-sp span.guide{
    position: absolute;
    background-color: rgba(220, 93, 120, 0.59);
    color: #fff;
    right: 10%;
}
/* mangaviewer css */

.about_content1 .left{
    text-align: center;
}
.about_content1 p.kanatta-logo{
    text-align: center;
}
.about_content1 .yume-kanatta{
    color: #dc5d78;
    text-align: center;
}

.pc-display .imgholder{
    width: 49.5%;
    background-color: #fff;
    height: 100%;
}
.pc-display {
    animation: fadeIn 2s ease 0s 1 normal;
    -webkit-animation: fadeIn 2s ease 0s 1 normal;
}

@keyframes fadeIn {
    0% {opacity: 0}
    100% {opacity: 1}
}

@-webkit-keyframes fadeIn {
    0% {opacity: 0}
    100% {opacity: 1}
}

/* よくある質問 */
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


@media screen and (max-width: 767px) {
    .aboutpage h3{
        font-size: 5vw;
        padding-bottom: 30px;
        white-space: nowrap;
    }
	.aboutpage .about_box{
		max-width: 750px;
        height: 100vw;
		background-image: url(../img/top/top-img-sp.png);
        margin-top: 27px;
	}
	.aboutpage .about_box .top_box-pjt{
	    padding-top: 8%;
	}
	.pc-display{
	    left: 8%;
        margin-top: 6%;
        height: 53vw;
	}
	.pc-display .imgholder{
	    width: 84.5vw;
	}
	.pc-display .imgholder img{
	    width: 40vw;
        margin-left: 25%;
        margin-top: 6%;
        display: block;
        max-width: 100%;
        height: auto;
        padding-top: 10%;
	}
	span.about-kanako4{
	    bottom: 62%;
        right: 5%;
	}
	span.about-kanako4 img{
        width: 25vw;
    }
    .aboutpage .about-start{
        font-size: 3vw;
        padding: 50px 0px;
    }
    .aboutpage .about-start p{
        font-size: 3.5vw;
        white-space: nowrap;
        padding-top: 20px;
    }
    .aboutpage .right{
        background-color: #fff;
        border-radius: 20px;
        padding: 10px;
        font-size: 1.7vw;
    }
    .aboutpage .right:before{
        content: "";
        position: absolute;
        top: 25%;
        left: -55px;
        margin-top: -27px;
        border: 30px solid transparent;
        border-right: 30px solid #fff;
    }
    .aboutpage .about_content1{
        padding: 15px;
        height: 70vw;
    }
    .aboutpage .about_content2{
        padding: 30px;
        height: 90vw;
    }
    .aboutpage .about_content2.about_content4{
        height: 58vw;
    }
    .about_content.about_content1.pjt-flow{
        height: 80vw;
    }
    .about_content.about_content1.pjt-flow ul.flow-txt{
        width: 98%;
    }
    .aboutpage .about_content1.about_content6{
        padding: 12px;
        height: 110vw;
    }
    .about_content.about_content1 .con-supporter img{
        width: 20vw;
    }
    .about_content.about_content1 .con-supporter .img-supporter img{
        width: 18vw;
    }
    .about_content.about_content1.about_content6{
        margin-top: 30px;
        height: 90vw;
    }
    .about_content.about_content2 .point123{
        height: 60px;
        text-align: left;
        border: solid 4px #dc5d78;
        border-radius: 20px;
        font-size: 1.6vw;
        padding: 7px;
        margin: 4px;
    }
    .aboutpage .about_content2.about_content7{
        height: 100vw;
    }
    .aboutpage .about_content2.about_content7 img{
        width: 45vw;
    }
    .aboutpage .about_content1.about_content8{
        height: 140vw;
    }
    .aboutpage .about_content1.about_content8 .box label{
        padding: 5px;
        margin-bottom: 5px;
        cursor: pointer;
        width: 95%;
    }
}

@media screen and (max-width: 450px) {
    .aboutpage .about_content1 {
        height: 87vw;
    }
    .aboutpage .about_content2{
        padding: 5px;
        height: 107vw;
    }
    .aboutpage .about_content2 .right{
        padding: 5px;
    }
    .aboutpage .about_content2.about_content4{
        height: 65vw;
    }
    .aboutpage .about_content2.about_content4 .left{
        margin-top: 12%;
    }
    .about_content.about_content1.pjt-flow ul.flow-txt{
        width: 100%;
        margin: 15px auto;
    }
    .aboutpage .about_content1.about_content5{
        padding: 10px;
    }
    .about_content.about_content1.pjt-flow{
        height: 100vw;
    }
    .about_content.about_content1.pjt-flow ul.flow-txt li{
        width: 98%;
    }
}


/* Lサイズ、ワイドスクリーン : Large Devices, Wide Screens */
@media only screen and (min-width : 993px) {
	.aboutpage .lets-start p,
	.about-start p {font-size: 34px;}
	.lets-start span{font-size: 28px;}
	.point p{font-size: 20px; margin-left: 10px;}
	.about_content .point123{font-size: 22px;}
}

/* Mサイズ、デスクトップ : Medium Devices, Desktops */
@media only screen and (min-width : 769px) and (max-width : 992px) {
	.aboutpage .lets-start p,
	.about-start p {font-size: 28px;}
    .lets-start span{font-size: 24px;}
    .point p{font-size: 16px; margin-left: 10px;}
	.about_content .point123{font-size: 18px;}
}

/* Sサイズ、タブレット : Small Devices, Tablets */
@media only screen and (min-width : 481px) and (max-width : 768px) {
	.aboutpage .lets-start p,
	.about-start p {font-size: 22px;}
    .lets-start span{font-size: 20px;}
    .point p{font-size: 12px; margin-left: 10px;}
	.about_content .point123{font-size: 16px;}
}

/* XSサイズ : Extra Small Devices, Phones */
@media only screen and (max-width : 480px) {
	.aboutpage .lets-start p,
	.about-start p {font-size: 14px;}
    .lets-start span{font-size: 14px;}
    .point p{font-size: 10px; margin-left: 10px;}
	.about_content .point123{font-size: 14px;}
}

</style>


<!--
<div class="about_box_wrap">
    <div class="about_box">
        <h1><?php echo h($setting['site_name']) ?> ?</h1>
        <div>

        </div>
    </div>
</div>
 -->
