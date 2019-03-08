<?= $this->Html->script('forms/uniform.min', ['block' => true])?>

<div class="page-container login-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                <!-- Simple login form -->
                <?= $this->Form->create(null);?>
                    <div class="panel panel-body login-form">
                        <div class="text-center mb-20">
                            <div class="icon-object border-slate-300 text-slate-300"><i class="fa fa-user"></i></div>
                            <h5 class="content-group"><?= __d('users', 'Login to your account')?>
                                <small class="display-block">
                                    <?= $this->getSession()->check('Flash.Auth') ? $this->Flash->render('Auth') : __d('users', 'Please put your credentials')?>
                                </small>
                            </h5>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <?= $this->Form->control('username', ['class' => 'form-control', 'label' => false, 'placeholder' => __d('users', 'username')]);?>
                            <div class="form-control-feedback">
                                <i class="fa fa-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <?= $this->Form->control('password', ['class' => 'form-control', 'label' => false, 'placeholder' => __d('users', 'password')]);?>
                            <div class="form-control-feedback">
                                <i class="fa fa-lock text-muted"></i>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <?= $this->Captcha->create('captcha', ['input' => false, 'mlabel' => false])?>
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                            <div class="input text">
                                <input type="text" name="captcha" autocomplete="off" class="form-control" id="captcha">
                            </div>
                            <div class="form-control-feedback">
                                <i class="fa fa-user-secret text-muted"></i>
                            </div>
                        </div>
                        <div class="login-options">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="checkbox ml-5">
                                        <label>
                                            <?= $this->Form->checkbox('remember_me', ['class' => 'styled'])?>
                                            <?= __d('users', 'Remember me')?>
                                        </label>
                                    </div>
                                </div>

                                <div class="hide col-sm-6 text-right mt-10">
                                    <a href="http://localhost/templates/bird/theme/login_password_recover.html"><?= __d('users', 'Forgot password?')?></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-lg btn-labeled btn-labeled-right btn-block"><b><i class="fa fa-sign-in"></i></b> Sign in</button>
                        </div>
                    </div>
                <?= $this->Form->end();?>
                <!-- /simple login form -->
                <?= $this->element('Global/footer')?>
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
<!-- /page content -->
</div>

<script>
$(function() {
    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });
});
</script>