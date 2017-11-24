<p class ="select_box-title">プロジェクトを始めるには</p>

<div class="select_box_wrap">
    <div class="select_box">
    	<div class="select-description">
    		プロジェクトの作成にはアカウント登録が必要です。<br>
    		アカウント登録がまだの方は
    		<a href="<?php echo $this->Html->url('/mail_auth') ?>" class="new">
				新規登録
    		</a>
    		からお願いします。
    	</div>
    	<div class="select-description select-start">
            <div class="hidden-xs hidden-sm">
   			<?php echo $this->Html->image('kanako.png') ?>
        		<div class="select-creat">
                	<p>自分で作成する</p><br>
                	すでに企画やプランがあってすぐに作成したい方はこちらから<br><br>
    				<a href="<?php echo $this->Html->url('/make') ?>">
                        <p class="select-btn1">プロジェクトを作る</p>
                    </a>
                </div>
        		<div class="select-cons">
                	<p>相談しながら作成する</p><br>
                	アイディアはあるけどどう形にしたらいいかわからない<br>
                	自分にできるかどうか不安<br>
                	という方はこちら<br><br>
                	<a href="<?php echo $this->Html->url('/consult') ?>">
    	            	<p class="select-btn2">Kanattaスタッフに相談する</p>
    	            </a>
        		</div>
        	</div>
        	<div class="hidden-md hidden-lg">
        	<ul>
        		<li class="li-sec1">
	      			<?php echo $this->Html->image('kanako.png') ?>
	      		</li>
				<li class="li-sec2">
            		<div class="select-creat">
                    	<p>自分で作成する</p>
                    	すでに企画やプランがあってすぐに作成したい方はこちらから<br>
        				<a href="<?php echo $this->Html->url('/make') ?>">
                            <p class="select-btn1">プロジェクトを作る</p>
                        </a>
                    </div>
            		<div class="select-cons">
                    	<p>相談しながら作成する</p>
                    	アイディアはあるけどどう形にしたらいいかわからない<br>
                    	自分にできるかどうか不安<br>
                    	という方はこちら<br>
                    	<a href="<?php echo $this->Html->url('/consult') ?>">
        	            	<p class="select-btn2">Kanattaスタッフに相談する</p>
        	            </a>
            		</div>
            	</li>
            </ul>
            </div>
        </div>
    </div>
</div>

<style>
.select_box .select-description{
    width: 95%;
    margin: 20px auto;
    text-align: center;
    line-height: 35px;
}
.select-description.select-start{
    position: relative;
}
.select-description.select-start img{
    max-width: 235px;
}

.select_box .select-description .select-creat,
.select_box .select-description .select-cons{
    width: 30%;
    background-color: rgba(255, 255, 255, 0.6);
    padding: 20px;
    position: absolute;
    top: 65px;
}
.select_box .select-description .select-creat p,
.select_box .select-description .select-cons p{
    text-align: center;
}
.select_box .select-description .select-creat{
    left: 10%;
    text-align: left;
}
.select_box .select-description .select-cons{
    right: 10%;
    text-align: left;
}

.select_box .select-description .hidden-lg .select-creat,
.select_box .select-description .hidden-lg .select-cons{
    text-align: left;
    width: 75%;
    display: inline-block;
    position: initial;
    padding: 25px;
    line-height: 15px;
    left: 25%;
    text-align: left;
    line-height: 24px;
}
.select_box .select-description .hidden-lg .select-creat .select-btn1,
.select_box .select-description .hidden-lg .select-cons .select-btn2{
    width: 60%;
    margin: 5px auto;
}
.select_box .select-description .hidden-lg li.li-sec1 img{
    width: 20vw;
    position: absolute;
    left: 0px;
}
.select_box .select-description .hidden-lg div.select-cons{
    margin-top: 15px;
}
.select_box .select-description .hidden-lg ul{
    list-style: none;
    padding: 0;
}
.select_box .select-description .hidden-lg ul li.li-sec1{
    width: 40%;
    display: inline;
}
.select_box .select-description .hidden-lg ul li.li-sec2{
    width: 85%;
    display: inline-table;
    margin-left: 18vw;
}

.select_box-title{
    text-align:center;
    margin-top: 30px;
}
.select_box .select-description .select-creat .select-btn1,
.select_box .select-description .select-cons .select-btn2{
    background-color: #dc5d78;
    color: #fff;
    border-radius: 12px;
    padding: 4px;
    font-size: 16px;
    width: 80%;
    margin: auto;
}
.select_box_wrap .select_box .select-description a.new{
    color: #dc5d78;
    background-color: #fff;
    border-radius: 10px;
    border: solid 1px #dc5d78;
    padding: 0px 10px 0 12px;
}


@media screen and (max-width: 561px) {
    .select_box_wrap .select_box .select-description{
        line-height: 20px;
        margin: 30px auto;
    }
    .select_box_wrap .select_box .select-description a.new{
        padding: 0 5px 0 7px;
    }
}
/* 画面サイズごとの設定 */

/* Lサイズ、ワイドスクリーン : Large Devices, Wide Screens */
@media only screen and (min-width : 993px) {
    .select-creat p,
    .select-cons p,
    .select_box-title{
	    font-size: 28px;
    }
    .select-btn1,
    .select-btn2,
    .select-description{
		font-size: 22px;
    }
    .select-creat,
    .select-cons{
        font-size: 22px;
    }
    .select-description a.new{
        font-size: 22px;
    }
    .select-description.select-start img{
        width: 200px;
    }
    .select_box .select-description {
        width: 100%;
        line-height: 30px;
    }
}

/* Mサイズ、デスクトップ : Medium Devices, Desktops */
@media only screen and (min-width : 769px) and (max-width : 992px) {
    .select-creat p,
    .select-cons p,
    .select_box-title{
	    font-size: 26px;
	}
    .select-btn1,
    .select-btn2,
    .select-description{
		font-size: 20px;
	}
    .select-creat,
    .select-cons{
        font-size: 20px;
    }
    .select-description a.new{
        font-size: 20px;
    }
    .select-description.select-start img{
        width: 200px;
    }
}

/* Sサイズ、タブレット : Small Devices, Tablets */
@media only screen and (min-width : 561px) and (max-width : 768px) {
    .select-creat p,
    .select-cons p,
    .select_box-title{
	    font-size: 24px;
    }
    .select-btn1,
    .select-btn2,
    .select-description{
	    font-size: 18px;
	}
    .select-creat,
    .select-cons{
        font-size: 18px;
    }
    .select-description a.new{
        font-size: 16px;
    }
    .select-description.select-start img{
        width: 150px;
    }
}

/* XSサイズ : Extra Small Devices, Phones */
@media only screen and (max-width : 560px) {
    .select-creat p,
    .select-cons p,
    .select_box-title{
	    font-size: 18px;
	}
    .select-btn1,
    .select-btn2,
    .select-description{
	    font-size: 16px;
	}
    .select-creat,
    .select-cons{
        font-size: 14px;
    }
    .select-description a.new{
        font-size: 12px;
    }
    .select-description.select-start img{
        width: 120px;
    }
    .select_box .select-description .hidden-lg .select-creat, .select_box .select-description .hidden-lg .select-cons{
        width: 90%;
        padding: 5px;
        line-height: 17px;
    }
}
</style>