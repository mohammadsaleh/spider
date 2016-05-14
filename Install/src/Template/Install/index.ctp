<?php
use Cake\Core\Configure;

?>


<div class="mian">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="#"><?php echo __d('spider', 'Install Spider') ?></a>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="install">
                    <h2><?php echo $title_for_layout; ?></h2>
                    <?php
                    $check = true;
                    // tmp is writable
                    if (is_writable(TMP)) {
                        echo '<p class="alert alert-success">' . __d('spider', 'Your tmp directory is writable.') . '</p>';

                    } else {
                        $check = false;
                        echo '<p class="alert alert-danger">' . __d('spider', 'Your tmp directory is NOT writable.') . '</p>';
                    }
//                    // config is writable
//                    if (is_writable(APP . 'config')) {
//                        echo '<p class="alert alert-success">' . __d('spider', 'Your config directory is writable.') . '</p>';
//                    } else {
//                        $check = false;
//                        echo '<p class="alert alert-danger">' . __d('spider', 'Your config directory is NOT writable.') . '</p>';
//                    }
                    // php version
                    $minPhpVersion = '5.3.10';
                    $operator = '>=';
                    if (version_compare(phpversion(), $minPhpVersion, $operator)) {
                        echo '<p class="alert alert-success">' . sprintf(__d('spider', 'PHP version %s %s %s'), phpversion(), $operator, $minPhpVersion) . '</p>';
                    } else {
                        $check = false;
                        echo '<p class="alert alert-danger">' . sprintf(__d('spider', 'PHP version %s < %s'), phpversion(), $minPhpVersion) . '</p>';
                    }
                    // cakephp version
                    $minCakeVersion = '2.5.4';
                    $cakeVersion = Configure::version();
                    $operator = '>=';
                    if (version_compare($cakeVersion, $minCakeVersion, $operator)) {
                        echo '<p class="alert alert-success">' . __d('spider', 'CakePhp version %s %s %s', $cakeVersion, $operator, $minCakeVersion) . '</p>';
                    } else {
                        $check = false;
                        echo '<p class="alert alert-danger">' . __d('spider', 'CakePHP version %s < %s', $cakeVersion, $minCakeVersion) . '</p>';
                    }
                    ?>
                </div>

            </div>
            <?php
                if ($check) {
                    $out = $this->Html->link(__d('spider', 'Install'), array(
                        'plugin' => 'Install',
                        'controller' => 'Install',
                        'action' => 'database',
                    ), array(
                        'button'  => 'btn btn-success',
                    ));
                } else {
                    
                    $out = '<p>' . __d('spider', 'Installation cannot continue as minimum requirements are not met.') . '</p>';
                }
            ?>
        </div>      
    </div>
</div>


<div class="panel-footer"><?= $out ?></div>