<!-- BEGIN LOGIN FORM -->
<?= $this->Form->create(null, ['class' => 'login-form']);?>
    <h3 class="form-title"><?= __d('users', 'Login To Administrator')?></h3>
    <div class="alert alert-danger display-hide">
        <a class="close" data-close="alert"></a>
        <span>Enter any username and password. </span>
    </div>
    <div class="form-group">
        <?= $this->Form->label('username', __d('users', 'username'), ['class' => 'control-label visible-ie8 visible-ie9']);?>
        <?= $this->Form->input('username', ['class' => 'form-control form-control-solid placeholder-no-fix']);?>
    </div>
    <div class="form-group">
        <?= $this->Form->label('password', __d('users', 'Password'), ['class' => 'control-label visible-ie8 visible-ie9']);?>
        <?= $this->Form->input('password', ['class' => 'form-control form-control-solid placeholder-no-fix']);?>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success uppercase"><?= __d('users', 'Login');?></button>
        <label class="rememberme check">
            <input type="checkbox" name="remember" value="1"/>Remember
        </label>
        <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
    </div>
<?= $this->Form->end();?>
<!-- END LOGIN FORM -->
<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="forget-form" action="index.html" method="post">
    <h3>Forget Password ?</h3>
    <p>
        Enter your e-mail address below to reset your password.
    </p>
    <div class="form-group">
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn btn-default">Back</button>
        <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
</form>
<!-- END FORGOT PASSWORD FORM -->