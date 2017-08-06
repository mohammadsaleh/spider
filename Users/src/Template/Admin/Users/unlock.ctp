<?php
$this->Html->script('forms/uniform.min.js', ['block' => 'core_script']);
?>
<div class="page-container login-container" style="min-height:621px">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                <?= $this->Form->create(null, ['type' => 'post'])?>
                    <div class="panel panel-body login-form">
                        <div class="text-center mt-10">
                            <?= $this->Html->image($user['avatar'] ?: '/assets/images/users/user6.png', ['style' => 'width:50%', 'class' => 'img-circle'])?>
                            <h6 class="content-group text-center text-semibold"><?= $user['full_name']?> <small class="display-block">Unlock your dashboard</small></h6>
                        </div>
                        <div class="text-center mb-10">
                            <small class="display-block">
                                <?= $this->Flash->render('Auth')?>
                            </small>
                        </div>
                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <div class="form-control-feedback">
                                <i class="fa fa-asterisk text-muted"></i>
                            </div>
                        </div>
                        <div class="login-options">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="checkbox ml-5">
                                        <label>
                                            <input name="remember_me" checked="checked" type="checkbox" class="styled">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-right mt-10">
                                    <a href="http://localhost/templates/bird/theme/login_password_recover.html">Forgot password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg btn-labeled btn-labeled-right btn-block"><b><i class="fa fa-unlock-alt"></i></b> Unlock</button>
                        </div>
                    </div>
                <?= $this->Form->end()?>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });
});
</script>