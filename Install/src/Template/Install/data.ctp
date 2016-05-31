<div class="install">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5><?php echo $title_for_layout; ?></h5>
        </div>
        <div class="panel-body">
            <p>
                <?php
                echo __d('spider', 'Create tables and load initial data');
                ?>
            </p>
        </div>
        <div class="panel-footer">
            <div class="form-actions">
                <?php
                echo $this->Html->link(__d('spider', 'Build database'), array(
                    'plugin'     => 'install',
                    'controller' => 'install',
                    'action'     => 'data',                    
                    '?'          => array('run' => 1),
                ), array(
                    'tooltip' => array(
                        'data-title'     => __d('spider', 'Click here to build your database'),
                        'data-placement' => 'left',
                    ),
                    'button'  => 'success',
                    'class'        => 'btn btn-default',
                    'id'         => 'next',
                    'icon'    => 'none',
                    'onclick' => '$(this).attr(\'disabled\', \'disabled\').find(\'i\').addClass(\'icon-spin icon-spinner\');',
                ));
                ?>
            </div>
        </div>


    </div>
</div>

