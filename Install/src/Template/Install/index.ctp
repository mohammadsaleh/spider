<?php
use Cake\Core\Configure;
use Cake\Cache\Cache;

$check = true;
?>


<br/><br/><br/>
<div class="install">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $title_for_layout; ?>
        </div>
        <div class="panel-body">
            <div class="columns large-12 checks">
                <h4>Environment</h4>
                <?php if (version_compare(PHP_VERSION, '5.5.9', '>=')): ?>
                    <p class="bg-success">Your version of PHP is 5.5.9 or higher (detected <?= phpversion() ?>).</p>
                <?php else: ?>
                    <?= $check = false; ?>
                    <p class="problem">Your version of PHP is too low. You need PHP 5.5.9 or higher to use CakePHP
                        (detected <?= phpversion() ?>).</p>
                <?php endif; ?>

                <?php if (extension_loaded('mbstring')): ?>
                    <p class="bg-success">Your version of PHP has the mbstring extension loaded.</p>
                <?php else: ?>
                    <?= $check = false; ?>
                    <p class="problem">Your version of PHP does NOT have the mbstring extension loaded.</p>;
                <?php endif; ?>

                <?php if (extension_loaded('openssl')): ?>
                    <p class="bg-success">Your version of PHP has the openssl extension loaded.</p>
                <?php elseif (extension_loaded('mcrypt')): ?>
                    <p class="bg-success">Your version of PHP has the mcrypt extension loaded.</p>
                <?php else: ?>
                    <?= $check = false; ?>
                    <p class="problem">Your version of PHP does NOT have the openssl or mcrypt extension loaded.</p>
                <?php endif; ?>

                <?php if (extension_loaded('intl')): ?>
                    <p class="bg-success">Your version of PHP has the intl extension loaded.</p>
                <?php else: ?>
                    <?= $check = false; ?>
                    <p class="problem">Your version of PHP does NOT have the intl extension loaded.</p>
                <?php endif; ?>
                <hr>

                <h4>Filesystem</h4>
                <?php if (is_writable(TMP)): ?>
                    <p class="bg-success">Your tmp directory is writable.</p>
                <?php else: ?>
                    <?= $check = false; ?>
                    <p class="problem">Your tmp directory is NOT writable.</p>
                <?php endif; ?>

                <?php if (is_writable(LOGS)): ?>
                    <p class="bg-success">Your logs directory is writable.</p>
                <?php else: ?>
                    <?= $check = false; ?>
                    <p class="problem">Your logs directory is NOT writable.</p>
                <?php endif; ?>

                <?php $settings = Cache::config('_cake_core_'); ?>
                <?php if (!empty($settings)): ?>
                    <p class="bg-success">The <em><?= $settings['className'] ?>Engine</em> is being used for core
                        caching. To change
                        the config edit config/app.php</p>
                <?php else: ?>
                    <?= $check = false; ?>
                    <p class="problem">Your cache is NOT working. Please check the settings in config/app.php</p>
                <?php endif; ?>

            </div>
        </div>


        <?php
        if ($check) {
            $out = $this->Html->link(__d('spider', 'Install'), array(
                'action' => 'database',
            ), array(
                'button'  => 'success',
                'class'   => 'btn btn-primary btn-lg active btn-action',
                'id'   => 'next',
                'tooltip' => array(
                    'data-title'     => __d('spider', 'Click here to begin installation'),
                    'data-placement' => 'left',
                ),
            ));
        } else {
            $out = '<p>' . __d('spider', 'Installation cannot continue as minimum requirements are not met.') . '</p>';
        }
        ?>


        <div class="panel-footer">
            <?= $this->Html->div('form-actions', $out); ?>            
        </div>
    </div>
</div>


</div>

