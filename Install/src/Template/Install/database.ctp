<?php  use Cake\Core\Configure; ?>


<div class="page-content">
    <div class="container-fluid">
        <div class="box-typical box-typical-padding">

            <h5 class="m-t-lg with-border">Horizontal Inputs</h5>

            <form>
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">Text</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><input type="text" class="form-control" id="inputPassword" placeholder="Text"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">Text Disabled</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><input type="text" disabled="" class="form-control" id="inputPassword" placeholder="Text Disabled"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">Text Readonly</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><input type="text" readonly="" class="form-control" id="inputPassword" placeholder="Text Readonly"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 form-control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleSelect" class="col-sm-2 form-control-label">Select</label>
                    <div class="col-sm-10">
                        <select id="exampleSelect" class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleSelect2" class="col-sm-2 form-control-label">Multiple select</label>
                    <div class="col-sm-10">
                        <select multiple="" class="form-control" id="exampleSelect2">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleSelect" class="col-sm-2 form-control-label">Textarea</label>
                    <div class="col-sm-10">
                        <textarea rows="4" class="form-control" placeholder="Textarea"></textarea>
                    </div>
                </div>
            </form>
        </div><!--.box-typical-->
    </div><!--.container-fluid-->
</div>



<!-------------------------------------->
<?php
echo $this->Form->create(false, array(
    'url' => array(
        'plugin' => 'install',
        'controller' => 'install',
        'action' => 'database'
    ),
    'inputDefaults' => array(
        'class' => 'span11',
    ),
), array(
    'class' => 'inline',
));
?>
    <div class="install">
        <h2><?php echo $title_for_layout; ?></h2>

        <?php if ($currentConfiguration['exists']):  ?>
            <div class="alert alert-warning">
                <strong><?php echo __d('croogo', 'Warning'); ?>:</strong>
                <?php echo __d('croogo', 'A `database.php` file already exists.'); ?>
                <?php
                if ($currentConfiguration['valid']):
                    $valid = __d('croogo', 'Valid');
                    $class = 'text-success';
                else:
                    $valid = __d('croogo', 'Invalid');
                    $class = 'text-error';
                endif;
                echo __d('croogo', 'This file is %s.', $this->Html->tag('span', $valid, compact('class')));
                ?>
                <?php if ($currentConfiguration['valid']): ?>
                    <?php
                    echo $this->Html->link(
                        __d('croogo', 'Reuse this file and proceed.'),
                        array('action' => 'data')
                    );
                    ?>
                <?php else: ?>
                    <?php echo __d('croogo', 'This file will be replaced.'); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        echo $this->Form->input('datasource', array(
            'placeholder' => __d('croogo', 'Database'),
            'default' => 'Database/Mysql',
            'empty' => false,
            'options' => array(
                'Database/Mysql' => 'mysql',
                'Database/Sqlite' => 'sqlite',
                'Database/Postgres' => 'postgres',
                'Database/Sqlserver' => 'mssql',
            ),
        ));
        echo $this->Form->input('host', array(
            'placeholder' => __d('croogo', 'Host'),
            'default' => 'localhost',
            'tooltip' => __d('croogo', 'Database hostname or IP Address'),
            'before' => '<span class="add-on"><i class="icon-home"></i></span>',
            'div' => 'input input-prepend',
            'label' => false,
        ));
        echo $this->Form->input('login', array(
            'placeholder' => __d('croogo', 'Login'),
            'default' => 'root',
            'tooltip' => __d('croogo', 'Database login/username'),
            'before' => '<span class="add-on"><i class="icon-user"></i></span>',
            'div' => 'input input-prepend',
            'label' => false,
        ));
        echo $this->Form->input('password', array(
            'placeholder' => __d('croogo', 'Password'),
            'tooltip' => __d('croogo', 'Database password'),
            'before' => '<span class="add-on"><i class="icon-key"></i></span>',
            'div' => 'input input-prepend',
            'label' => false,
        ));
        echo $this->Form->input('database', array(
            'placeholder' => __d('croogo', 'Name'),
            'default' => 'croogo',
            'tooltip' => __d('croogo', 'Database name'),
            'before' => '<span class="add-on"><i class="icon-briefcase"></i></span>',
            'div' => 'input input-prepend',
            'label' => false,
        ));
        echo $this->Form->input('prefix', array(
            'placeholder' => __d('croogo', 'Prefix'),
            'tooltip' => __d('croogo', 'Table prefix (leave blank if unknown)'),
            'before' => '<span class="add-on"><i class="icon-minus"></i></span>',
            'div' => 'input input-prepend',
            'label' => false,
        ));
        echo $this->Form->input('port', array(
            'placeholder' => __d('croogo', 'Port'),
            'tooltip' => __d('croogo', 'Database port (leave blank if unknown)'),
            'before' => '<span class="add-on"><i class="icon-asterisk"></i></span>',
            'div' => 'input input-prepend',
            'label' => false,
        ));
        ?>
    </div>
    <div class="form-actions">
        <?php echo $this->Form->submit('Submit', array('button' => 'success', 'div' => 'input submit')); ?>
    </div>
<?php echo $this->Form->end(); ?>