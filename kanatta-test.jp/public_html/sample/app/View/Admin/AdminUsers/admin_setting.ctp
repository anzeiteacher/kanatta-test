<div class="setting_title">
    <h2>ユーザーの表示項目の設定</h2>
</div>
<br><br>

<div class="container">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo $this->Html->url('/admin/admin_users')?>">ユーザー一覧</a></li>
        <li class="active"><a href="<?php echo $this->Html->url('/admin/admin_users/setting') ?>">ユーザの表示項目の設定</a></li>
    </ul>
    <br><br>
    <div class="row">
        <div class="col-md-6">
            <p>下記項目を表示設定にした場合、プロフィールに表示されます。<br>
                またプロジェクト検索画面の検索条件にも反映されます。</p><br>

            <?php echo $this->Form->create('Setting',
                array('inputDefaults' => array('class' => 'form-control'))) ?>
            <div class="form-group">
                <?php echo $this->Form->input('display_user_birth_school',
                    array('label' => '出身校の表示', 'type' => 'select',
                        'options' => array(0 => '非表示', 1 => '表示')))?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->input('display_user_birth_area',
                    array('label' => '出身地の表示', 'type' => 'select',
                        'options' => array(0 => '非表示', 1 => '表示')))?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">更新</button>
            </div>
            <?php echo $this->Form->end() ?>
        </div>
    </div>
</div>


