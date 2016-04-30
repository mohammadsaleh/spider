

<div class="page-content">
    <h3 class="page-title">
    <?= __d('settings','Edit Settings') ?>
    <small></small>
</h3>    <div class="page-bar">
        <ul class="page-breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <?= $this->Html->link(__('Home'), ['action' => 'dashboard']);?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <?= $this->Html->link(__d('settings', 'Settings'), ['action' => 'index']);?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span><?= __('title') ?></span>
    </li>
</ul>    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tabbable tabbable-custom boxless tabbable-reversed">

                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_0" data-toggle="tab">
                            Form Actions
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_0">
                        <div class="portlet box blue-hoki">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>Add your caption here
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse" data-original-title="" title="">
                                    </a>
                                    <a href="#portlet-config" data-toggle="modal" class="config" data-original-title=""
                                       title="">
                                    </a>
                                    <a href="javascript:;" class="reload" data-original-title="" title="">
                                    </a>
                                    <a href="javascript:;" class="remove" data-original-title="" title="">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <div class="form-actions top">
                                    <div class="btn-set pull-left">
                                        <?=
                                        $this->Html->link(__d('settings', 'Add New Settings'),
                                            ['action' => 'add'],
                                            ['class' => 'btn btn-info']
                                        );
                                        ?>
                                        <?=
                                        $this->Html->link(__d('settings', 'List Settings'),
                                            ['action' => 'index'],
                                            ['class' => 'btn btn-primary']
                                        );
                                        ?>
                                    </div>
                                </div>
                                <?= $this->Form->create($setting, ['class' => 'form-horizontal']);?>
                                <div class="form-body">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'key'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('key', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'value'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('value', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'title'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('title', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'description'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('description', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'params'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('params', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'weight'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('weight', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'editable'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('editable', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'created_by'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('created_by', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'updated_by'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('updated_by', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'created'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('settings', 'updated'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <?= $this->Form->button(__('Submit'), ['class' => 'green']) ?>
                                            <?= $this->Html->link(__('Cancel'), \Cake\Routing\Router::url(['action' => 'index']), ['class' => 'btn default']) ?>
                                        </div>
                                    </div>
                                </div>
                                <?= $this->Form->end() ?>
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>