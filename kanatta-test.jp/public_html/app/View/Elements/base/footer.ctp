</div>
<div id="back_top" onclick="back_top();">
    <?php echo $this->Html->image('back_top.png') ?>
</div>
<div class="footer-area">
	<?php echo $this->Html->image('common/footer-logo.png') ?>
	<p class="foot_p01">
		<span class="foot_p01_s1">～ 女性エンジニアが作った<br>&nbsp;&nbsp;&nbsp;女性のためのクラウドファンディング ～</span><br>
		日々頑張っている女性の夢や理想をかなえるサービス
	</p>
</div>
<div id="footer">

    <div class="footer footer_pc hidden-xs footer-content">
   		<div class="foot_box clearfix">
    		<div id="fb-root"></div>
    		<script>(function(d, s, id) {
    		  var js, fjs = d.getElementsByTagName(s)[0];
    		  if (d.getElementById(id)) return;
    		  js = d.createElement(s); js.id = id;
    		  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=205032459604050";
    		  fjs.parentNode.insertBefore(js, fjs);
    		}(document, 'script', 'facebook-jssdk'));</script>

    		<div class="ftr_nav">
    			<div class="container clearfix">
    				<div class="ftr_nav_1">
    					<p class="tit"><img src="/img/common/jewelry.png" alt="">プロジェクトを探す</p>
    					<ul class="txt10 footer-category">
    						<li><a href="<?php echo $this->Html->url('/categories/12')?>">フード</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/13')?>">コミュニティ</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/19')?>">エンタメ</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/21')?>">テクノロジー</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/16')?>">ファッション</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/4')?>">ビューティー</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/20')?>">アニメ</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/7')?>">ビジネス</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/17')?>">プロダクト</a></li>
    					</ul>
    					<ul class="txt10 footer-category">
    						<li><a href="<?php echo $this->Html->url('/categories/18')?>">パフォーマンス</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/15')?>">アート</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/14')?>">スポーツ</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/9')?>">写真・映像</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/10')?>">本・出版</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/11')?>">音楽</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/6')?>">教育・福祉</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/8')?>">旅</a></li>
    						<li><a href="<?php echo $this->Html->url('/categories/5')?>">社会貢献</a></li>
    					</ul>
    				</div>
    				<div class="ftr_nav_1">
    					<p class="tit"><img src="/img/common/jewelry.png">プロジェクトを始める</p>
    					<ul class="txt10">
    						<li><a href="<?php echo $this->Html->url('/make') ?>">自分でつくる</a></li>
    						<li><a href="<?php echo $this->Html->url('/consult') ?>">Kanattaスタッフに相談する</a></li>
    						<li><a href="<?php echo $this->Html->url('/guideline') ?>">ガイドライン</a></li>
    					</ul>
    					<p class="tit"><img src="/img/common/jewelry.png">Kanattaの応援団</p>
    					<ul class="txt10">
    						<li><a href="<?php echo $this->Html->url('/ambassador') ?>">アンバサダー</a></li>
    						<li><a href="<?php echo $this->Html->url('/consultant') ?>">コンサルタント</a></li>
    					</ul>
    				</div>
    				<div class="ftr_nav_1">
    					<p class="tit"><img src="/img/common/jewelry.png">Kanattaについて</p>
    					<ul class="txt10">
    						<li><a href="<?php echo $this->Html->url('/about') ?>">Kanattaとは？</a></li>
    						<li><a href="<?php echo $this->Html->url('/question') ?>">よくある質問</a></li>
    						<li><a href="<?php echo $this->Html->url('/rule') ?>">利用規約</a></li>
    						<li><a href="<?php echo $this->Html->url('/policy') ?>">プライバシーポリシー</a></li>
    						<li><a href="<?php echo $this->Html->url('/tokutei') ?>">特定商取引法</a></li>
    						<li><a href="<?php echo $this->Html->url('http://air-works.jp/') ?>">会社情報</a></li>
    						<li><a href="<?php echo $this->Html->url('/contact') ?>">お問い合わせ</a></li>
    					</ul>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
	<div class="footer-bottom">
        <div>
            © 2017 <?php echo h($setting['copy_right']) ?>
        </div>
	</div>
</div>

<div id="loader" style="display: none;">
    <div id="loader_content">
        <?php echo $this->Html->image('loader.gif') ?>
    </div>
</div>

<?php echo $this->Html->script('jquery-2.1.0.min') ?>
<?php echo $this->Html->script('/bootstrap/js/bootstrap.min') ?>
<?php echo $this->Html->script('anime') ?>
<?php echo $this->element('js/default_js') ?>
<?php echo $this->Html->script('default') ?>
<?php echo $this->fetch('script') ?>

</body>
</html>