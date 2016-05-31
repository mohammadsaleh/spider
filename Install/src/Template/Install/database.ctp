<?php use Cake\Core\Configure; ?>

<div class="install">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5><?php echo $title_for_layout; ?></h5>
        </div>
        <div class="panel-body">
            <div class="box-typical box-typical-padding">

                <div class="install">
                    <?php if ($currentConfiguration['exists']): ?>
                        <div class="alert alert-warning">
                            <strong><?php echo __d('spider', 'Warning'); ?>:</strong>
                            <?php echo __d('spider', 'A `database.php` file already exists.'); ?>
                            <?php
                            if ($currentConfiguration['valid']):
                                $valid = __d('spider', 'Valid');
                                $class = 'text-success';
                            else:
                                $valid = __d('spider', 'Invalid');
                                $class = 'text-error';
                            endif;
                            echo __d('spider', 'This file is %s.', $this->Html->tag('span', $valid, compact('class')));
                            ?>
                            <?php if ($currentConfiguration['valid']): ?>
                                <?php
                                echo $this->Html->link(
                                    __d('spider', 'Reuse this file and proceed.'),
                                    array('action' => 'data')
                                );
                                ?>
                            <?php else: ?>
                                <?php echo __d('spider', 'This file will be replaced.'); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>



                    <?php
                    echo $this->Form->create(false, array(
                            'url'           => array(
                                'plugin'     => 'install',
                                'controller' => 'install',
                                'action'     => 'database'
                            ),
                            'inputDefaults' => array(
                                'class' => 'span11',
                            ),
                        )
                    ); ?>


                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Datasource</label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-list-alt"></span>
                                </div>
                                <select name="datasource" placeholder="Database" id="datasource" class="form-control">
                                    <option value="Mysql" selected="selected">mysql</option>
                                    <option value="Sqlite">sqlite</option>
                                    <option value="Postgres">postgres</option>
                                    <option value="Sqlserver">mssql</option>
                                </select>

                                </p>
                            </div>
                        </div>
                    </div>
                    <!--==============================-->
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">Host</label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-home"></span>
                                </div>
                                <input type="text" name="host" class="form-control" id="inputPassword"
                                       placeholder="host"
                                       value="localhost">
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--======================================-->
                    <!--======================================-->
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">username</label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </div>
                                <input type="text" name="username" class="form-control" id="inputPassword"
                                       placeholder="username"
                                       value="root">
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--======================================-->
                    <!--======================================-->
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">password</label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </div>
                                <input type="text" name="password" class="form-control" id="inputPassword"
                                       placeholder="password" value="">
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--======================================-->
                    <!--======================================-->
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">database</label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-briefcase"></span>
                                </div>
                                <input type="text" name="database" class="form-control" id="inputPassword"
                                       placeholder="database" value="spider">
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--======================================-->
                    <!--======================================-->
                    <div class="form-group row">

                        <label class="col-sm-2 form-control-label">prefix</label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <p class="form-control-static">


                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </div>
                                <input type="text" name="prefix" class="form-control" id="inputPassword"
                                       placeholder="prefix" value="">
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--======================================-->
                    <!--======================================-->
                    <div class="form-group row">
                        <label class="col-sm-2 form-control-label">port</label>

                        <div class="col-sm-10">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-asterisk"></span>
                                </div>
                                <input type="text" name="port" class="form-control" id="inputPassword"
                                       placeholder="port"
                                       value="">
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--======================================-->
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="form-actions">
                <?php echo $this->Form->submit('Submit', array('button' => 'success', 'id' => 'next', 'div' => 'input submit')); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>


<div class="page-content">
    <div class="container-fluid">

    </div><!--.box-typical-->
</div><!--.container-fluid-->
</div>


<!-------------------------------------->
