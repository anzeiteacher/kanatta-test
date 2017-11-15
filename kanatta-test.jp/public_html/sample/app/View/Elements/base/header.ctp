<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>
        <?php
        if(!empty($top_title)){
            echo h($top_title);
        }else{
            if(!empty($setting['site_name'])){
                echo (isset($title) ? $title.' - ' : '').h($setting['site_name']);
            }else{
                echo (isset($title) ? $title.' - ' : '');
            }
        }
        ?>
    </title>
    <meta name="Description" content="<?php echo isset($description) ? $description : '' ?>"/>
    <?php if(!empty($setting['site_keywords'])):?>
    <meta name="Keywords" content="<?php echo h($setting['site_keywords']) ?>"/>
    <?php endif;?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $this->fetch('ogp'); ?>
    <?php echo $this->Html->meta('icon'); ?>

    <?php echo $this->Html->css('/bootstrap/css/bootstrap.min')."\n" ?>
    <?php echo $this->Html->css('/bootstrap/css/elusive-webfont') ?>

    <?php echo $this->Html->css('common'); ?>
    <?php echo $this->element('css/style'); ?>

    <?php echo $this->fetch('css') ?>
</head>

<?php if(!empty($login_page)): ?>
<body class="login">
<?php else: ?>
<body>
<?php endif ?>
<?php echo $this->element('admin/google/analytics') ?>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
