<div class="install">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5><?php echo $title_for_layout; ?></h5>
        </div>
        <div class="panel-body">
            <div class="box-typical box-typical-padding">

                <div class="install">
                    <?php
                    echo $this->Form->create(false, array(
                            'url'           => array(
                                'plugin'     => 'install',
                                'controller' => 'install',
                                'action'     => 'adminuser'
                            ),
                            'inputDefaults' => array(
                                'class' => 'span11',
                            ),
                        )
                    ); ?>


                    
                    <!--======================================-->
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">username</label>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </div>
                                <input type="text" name="username" class="form-control" id="inputPassword"
                                       placeholder="username"
                                       value="admin">
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--======================================-->
                    <!--======================================-->
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">password</label>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </div>
                                <input type="password" name="password" class="form-control" id="inputPassword"
                                       placeholder="password" value="">
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--======================================-->
                    <!--======================================-->
                    <div class="form-group row">
                        <label class="col-sm-3 form-control-label">verify_password</label>

                        <div class="col-sm-9">
                            <div class="input-group">
                                <p class="form-control-static">

                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </div>
                                <input type="password" name="verify_password" class="form-control" id="inputPassword"
                                       placeholder="verify_password" value="">
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
                <?php echo $this->Form->submit('Save', array('button' => 'success', 'id' => 'next', 'div' => 'input submit')); ?>
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
