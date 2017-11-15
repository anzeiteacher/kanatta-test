<div id="wrap">
    <div id="menu_bar" class="<?php echo !empty($box_top) ? 'menu_bar_top' : '' ?>">
        <div id="brand">
            <a href="<?php echo $this->Html->url('/') ?>">
                <?php
                if(!empty($setting['logo'])){
                    echo $this->Label->image($setting['logo'], array('id' => 'logo'));
                }else{
                    echo h($setting['site_name']);
                }
                ?>
            </a>
        </div>
        <div class="menu">
            <a href="<?php echo $this->Html->url('/projects') ?>">
                <span class="img-icon-search"></span>
                <span class="hidden-sm hidden-xs">プロジェクトを</span>探す
            </a>
            <a href="<?php echo $this->Html->url('/select') ?>">
                <span class="img-icon-file-new"></span>
                <span class="hidden-sm hidden-xs">プロジェクトを</span>作る
            </a>
            <a href="<?php echo $this->Html->url('/about') ?>">
                <span class="img-icon-question"></span>
                <?php echo h($setting['site_name']) ?>とは
            </a>
        </div>

        <div class="menu_right">
            <?php if($auth_user): ?>
                <div class="user">
                    <a href="<?php echo $this->Html->url('/mypage') ?>">
                        <?php echo $this->User->get_user_img_sm($auth_user) ?>&nbsp;
                        <?php echo h($auth_user['User']['nick_name']) ?>
                    </a>
                </div>
                <div class="logout">
                    <a href="<?php echo $this->Html->url('/logout') ?>">
                        <span class="el-icon-off"></span>
                    </a>
                </div>
            <?php else: ?>
                <div class="login">
                    <a href="<?php echo $this->Html->url('/login') ?>">
                        <span class="img-icon-login"></span>ログイン
                    </a>
                </div>
                <!--
                <div>
                    <?php echo $this->Html->link('ログイン', '/login') ?>
                </div>
                 -->
                <div>
                    <?php echo $this->Html->link('新規登録', '/mail_auth') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="icon-bar" href="icon-bar" onclick="toggle_sub_menu();">
            <span class="el-icon-lines"></span>
        </div>

        <div id="sub_menu">
            <div>
                <a href="<?php echo $this->Html->url('/projects') ?>">
                    <span class="el-icon-search"></span>
                    探す
                </a>
            </div>
            <div>
                <a href="<?php echo $this->Html->url('/make') ?>">
                    <span class="el-icon-file-new"></span>
                    作る
                </a>
            </div>
            <div>
                <a href="<?php echo $this->Html->url('/about') ?>">
                    <span class="el-icon-question"></span>
                    <?php echo h($setting['site_name']) ?>?
                </a>
            </div>
            <?php if($auth_user): ?>
                <div>
                    <a href="<?php echo $this->Html->url('/mypage') ?>">
                        <?php echo $this->User->get_user_img_sm($auth_user) ?>
                        <?php echo h($auth_user['User']['nick_name']) ?>
                    </a>
                </div>
                <div>
                    <a href="<?php echo $this->Html->url('/logout') ?>">
                        <span class="el-icon-off"></span> ログアウト
                    </a>
                </div>
            <?php else: ?>
                <div>
                    <?php echo $this->Html->link('ログイン', '/login') ?>
                </div>
                <div>
                    <?php echo $this->Html->link('新規登録', '/mail_auth') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="contents">



