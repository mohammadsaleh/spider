<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-title"><?= __('Reset Password') ?></h4>
    </div>
    <div class="panel-body no-padding-bottom">
        <div class="row"><?= $this->Flash->render('reset')?></div>
        <div class="form-group">
            <?= $this->Form->control('password', ['placeholder' => __('Password'), 'required' => false, 'value' => '', 'class' => 'form-control', 'type' => 'password', 'label' => false]);?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('confirm_password', ['placeholder' => __('Confirm Password'), 'required' => false, 'value' => '', 'class' => 'form-control', 'type' => 'password', 'label' => false]);?>
        </div>
        <div class="form-group">
            <button type="submit" name="reset_password" value="1" class="btn btn-info btn-labeled col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <b>
                    <i class="fa fa-rotate-right"></i>
                </b> Reset Password
            </button>
        </div>

    </div>
</div>