<?php $tosya = ($setting['company_type'] == 1) ? '当社' : '当方' ?>
<div class="about_box_wrap amb">
	<h1 class="amb_top">
		<img class="amb_top_img" src="/img/ambassador/amb_top.png" alt="アンバサダーページ">
	</h1>
	<div class="amb_top_description">
		<p>Kanattaを応援してくださっているアンバサダーの紹介ページです。</p>
	</div>
		<div class="amb_box">
            <div class="author">
            	<img src="/img/ambassador/am1.png">
            	<p>叶 かなこ</p>
            </div>
            <div class="detail">
            	○○会社 代表取締役<br>
            	女性の社会進出を応援しています。
            </div>
        </div>
		<div class="amb_box">
            <div class="author">
            	<img src="/img/ambassador/am2.png">
            	<p>鈴木 佳菜子</p>
            </div>
            <div class="detail">
            	○○会社 代表取締役<br>
            	女性の社会進出を応援しています。
            </div>
        </div>
		<div class="amb_box">
            <div class="author">
            	<img src="/img/ambassador/am3.png">
            	<p>孫 那加子</p>
            </div>
            <div class="detail">
            	○○会社 代表取締役<br>
            	女性の社会進出を応援しています。
            </div>
        </div>
</div>

<style>
.about_box_wrap.amb{
    text-align: center;
    padding: 30px;
}
.amb_box{
    width: 75%;
    margin: auto;
    text-align: center;
    margin: 60px auto;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 10px 10px 30px 10px;
    font-size: 16px;
}
.author{
    font-size: 20px;
    font-weight: bold;
}
.author img{
    width: 30%;
    margin-top: 20px;
    min-width: 120px;
}
.amb_top_description{
    font-size: 18px;
    margin-top: 40px;
}

@media screen and (max-width: 1000px) {
    .amb_top_img{
        width: 90%;
        min-width: 290px;
    }
}

@media screen and (max-width: 600px) {
    .amb_top_description{
        font-size: 14px;
    }
    .amb_box{
        font-size: 14px;
    }
    .author{
        font-size: 16px;
    }

}

</style>