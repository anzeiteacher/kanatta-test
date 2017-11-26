<?php $tosya = ($setting['company_type'] == 1) ? '当社' : '当方' ?>
<div class="about_box_wrap amb cons">
	<h1 class="amb_top">
		<img class="amb_top_img" src="/img/consultant/cons_top.png" alt="コンサルタントページ">
	</h1>
	<div class="amb_top_description">
		<p>クラウドファンディングで成功されているコンサルタントの紹介ページです。</p>
	</div>
	<ul>
		<li>
    		<div class="cons_box">
                <div class="author">
                	<img src="/img/consultant/con1.jpg">
                	<p>株式会社Kanatta 代表取締役<br>叶 かなこ</p>
                </div>
                <div class="detail">
                	<p>経歴</p>
                	東京都世田谷区出身。
                	○○大学卒業後、○○会社に入社、2016年4月に株式会社Kanattaを設立。
                </div>
                <div class="detail">
                	<p>クラウドファンディング成功実績</p>
                	2016年10月 都心に保育施設を創りたい 120万達成(105%)
                	2017年4月  田舎の小民家を改装したい 200万達成(150%)
                </div>
                <div class="detail">
                	<p>得意分野</p>
                	面白いことアイディアを生み出すこと、面白くないことも面白くすること
                </div>
                <div class="detail">
                	<p>一言</p>
                	やることはたくさんありますが、一緒に成功させましょう。
                </div>
            </div>
        </li>
		<li>
    		<div class="cons_box">
                <div class="author">
                	<img src="/img/consultant/con2.jpg">
                	<p>株式会社Kanaeru 代表取締役<br>金子 つとむ</p>
                </div>
                <div class="detail">
                	<p>経歴</p>
                	東京都世田谷区出身。
                	○○大学卒業後、○○会社に入社、2016年4月に株式会社Kanattaを設立。
                </div>
                <div class="detail">
                	<p>クラウドファンディング成功実績</p>
                	2016年10月 都心に保育施設を創りたい 120万達成(105%)
                	2017年4月  田舎の小民家を改装したい 200万達成(150%)
                </div>
                <div class="detail">
                	<p>得意分野</p>
                	面白いことアイディアを生み出すこと、面白くないことも面白くすること
                </div>
                <div class="detail">
                	<p>一言</p>
                	やることはたくさんありますが、一緒に成功させましょう。
                </div>
            </div>
        </li>
     </ul>
	<ul>
		<li>
    		<div class="cons_box">
                <div class="author">
                	<img src="/img/consultant/con3.jpg">
                	<p>株式会社Kanatte 代表取締役<br>鈴木 佳菜子</p>
                </div>
                <div class="detail">
                	<p>経歴</p>
                	東京都世田谷区出身。
                	○○大学卒業後、○○会社に入社、2016年4月に株式会社Kanattaを設立。
                </div>
                <div class="detail">
                	<p>クラウドファンディング成功実績</p>
                	2016年10月 都心に保育施設を創りたい 120万達成(105%)
                	2017年4月  田舎の小民家を改装したい 200万達成(150%)
                </div>
                <div class="detail">
                	<p>得意分野</p>
                	面白いことアイディアを生み出すこと、面白くないことも面白くすること
                </div>
                <div class="detail">
                	<p>一言</p>
                	やることはたくさんありますが、一緒に成功させましょう。
                </div>
            </div>
        </li>
		<li>
    		<div class="cons_box">
                <div class="author">
                	<img src="/img/consultant/con4.jpg">
                	<p>株式会社Kanatteta 代表取締役<br>佐藤 金太郎</p>
                </div>
                <div class="detail">
                	<p>経歴</p>
                	東京都世田谷区出身。
                	○○大学卒業後、○○会社に入社、2016年4月に株式会社Kanattaを設立。
                </div>
                <div class="detail">
                	<p>クラウドファンディング成功実績</p>
                	2016年10月 都心に保育施設を創りたい 120万達成(105%)
                	2017年4月  田舎の小民家を改装したい 200万達成(150%)
                </div>
                <div class="detail">
                	<p>得意分野</p>
                	面白いことアイディアを生み出すこと、面白くないことも面白くすること
                </div>
                <div class="detail">
                	<p>一言</p>
                	やることはたくさんありますが、一緒に成功させましょう。
                </div>
            </div>
        </li>
     </ul>
</div>

<style>
.cons ul li{
    width: 45%;
    display: inline-block;
    height: 270px;
}
.cons_box .author p{
    display: inline-block;
    margin: 15px;
    vertical-align: middle;
}

.about_box_wrap.amb{
    text-align: center;
    padding: 30px;
}
.cons_box{
    margin: auto;
    text-align: center;
    margin: 50px 25px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 10px 10px 30px 10px;
    font-size: 16px;
}
.author{
    font-size: 18px;
    font-weight: bold;
}
.author img{
    width: 30%;
    margin-top: 20px;
    min-width: 120px;
}
.cons_box .detail{
    text-align: left;
    margin-left: 6%;
    margin-top: 20px;
}
.cons_box .detail p{
    font-size: 18px;
    font-weight: bold;
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
    .cons_box{
        font-size: 14px;
    }
    .author{
        font-size: 16px;
    }

}

</style>