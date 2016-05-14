<?php
use Cake\Core\Configure;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?php echo $title_for_layout; ?> - <?php echo __d('spider', 'Spider'); ?></title>
    <?php
    echo $this->Html->css(['Install.bootstrap/bootstrap']);

    echo $this->element('styles', array(), array('plugin' => 'install'));
    echo $this->Html->script(array(
//        '/spider/js/jquery/jquery.min',
//        '/croogo/js/croogo-bootstrap',
    ));
    ?>
</head>

<body>

<div id="wrap">
    <div class="container">
        <div class="row" id="main">
            <div class="col-md-6 col-md-offset-3">
                <?= $this->Flash->render(); ?>
                <?= $this->fetch('content'); ?>
            </div>
        </div>
    </div>
    <?= $this->element('admin/footer'); ?>
</div>


<?php
$script = <<<EOF
$('[rel=tooltip],input[data-title]').tooltip();
EOF;
//$this->Js->buffer($script);
// $this->Js->writeBuffer();
?>
</body>
</html>