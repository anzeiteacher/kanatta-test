<?php $tosya = ($setting['company_type'] == 1) ? '当社' : '当方' ?>
<div class="about_box_wrap amb cons">
	<h1 class="amb_top">
		<img class="amb_top_img" src="/img/ambassador/amb_top.png" alt="アンバサダーページ">
	</h1>
	<div class="amb_top_description">
		<p>Kanattaを応援してくださっているアンバサダーの紹介ページです。</p>
	</div>
	<ul>
		<li>
    		<div class="cons_box">
                <div class="author">
                <ul>
                	<li class="left"><img src="/img/ambassador/kikuchi.jpg"></li>
                	<li class="right">
                    	<p class="company">ASTREX 航空宇宙技研 会長<br>
                        	一般社団法人 航空宇宙振興会夢宙 理事長<br>
                        	一般社団法人 宇宙生命科学研究基金 理事</p>
                    	<p class="name">菊池 秀明 様</p>
                    </li>
                </ul>
                </div>
                <div class="detail">
                	<p>経歴</p>
                	2006年より民間初の人工衛星「まいど1号」で知られる東大阪宇宙開発協同組合で最高統括責任者に就任。<br>
					2008年宇宙開発合同会社「ASTREX」設立し、会長に就任。<br>
					その後はJAXA、東京大学等で人工衛星や探査機の開発に数多く携わっている。<br>

					現在、千人で打上げる人工衛星プロジェクトや、宇宙大好きツアーなどさまざまな啓蒙活動を行っている。
                </div>
                <div class="detail">
                	<p>応援メッセージ</p>
                	産業革命以降200年余りの間、主に男性の発想で形成されてきた社会組織や産業構造は既に臨界に達しています。<br>
					更なる社会の発展の為にはあらゆる場面での女性の活躍が大切な時代となっています。<br>
					そんな中、女性の発想が十分に発揮できる環境こそがより素晴らしい未来を築いていくはず！<br>
					活力溢れる女性たちに大きな期待を込めてkanattaを心より応援させて頂きます。
                </div>
            </div>
        </li>
     </ul>
</div>

<style>
#contents{
    max-width: 1200px;
    margin: 0 20px;
}
.cons ul{
    padding-left: 0px;
}
.cons ul li{
    width: 45%;
    display: inline-block;
    vertical-align: top;
}

.about_box_wrap.amb{
    text-align: center;
    padding: 10px;
}
.cons_box{
    margin: auto;
    text-align: center;
    margin: 20px 25px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 10px 15px 30px 15px;
    font-size: 15px;
}
.author{
    font-size: 17px;
    font-weight: bold;
}
.author img{
    width: 30%;
    margin-top: 20px;
    min-width: 120px;
}
.author .company{
    font-size: 11px;
    text-align: left;
}
.author .name{
    font-size: 20px;
}
.author p{
    display: inline-block;
    margin: 3px;
    vertical-align: middle;
}
.author ul li{
    list-style: none;
    width: 40%;
    display: table-cell;
    vertical-align: middle;
    height: auto;
}
.cons_box .detail{
    text-align: left;
    margin-top: 20px;
    font-size: 14px;
}
.cons_box .detail p{
    font-size: 17px;
    font-weight: bold;
}
.amb_top_description{
    font-size: 17px;
    margin-top: 40px;
    margin-bottom: 25px;
}
.amb_top_description p{
    width: 90%;
    margin: auto;
}

@media screen and (min-width: 601px) and (max-width: 1000px) {
    .amb_top_img{
        width: 90%;
        min-width: 290px;
    }
    #contents{
        margin: 0px;
    }
    .cons_box {
        margin: 50px 20px;
        font-size: 14px;
    }
    .cons_box .detail p {
        font-size: 16px;
    }
}
@media screen and (max-width: 800px) {
    .cons ul li {
        width: 90%;
    }
    .author ul li{
        display: inline-table;
    }
    .author .company{
        margin: 10px auto;
        white-space: nowrap;
        text-align: center;
    }
    .author p {
        display: block;
    }
}

@media screen and (max-width: 600px) {
    .amb_top_img{
        width: 100%;
        min-width: 290px;
    }
    .amb_top_description{
        font-size: 14px;
    }
    .cons_box{
        font-size: 14px;
    }
    .author{
        font-size: 14px;
    }
    #contents{
        margin: 0px;
    }
    .cons_box {
        margin: 50px 20px;
        font-size: 12px;
        padding: 0px 10px 20px 10px;
    }
    .cons_box .detail p {
        font-size: 14px;
    }
    .about_box_wrap.amb{
        padding: 2px;
    }
}
@media screen and (max-width: 450px) {
    .cons_box {
        margin: 35px 0px;
    }
}

</style>