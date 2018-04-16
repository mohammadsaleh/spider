

<div class="page-content">
    <h3 class="page-title">
    <?= __d('plugin_manager','Edit Plugins') ?>
    <small></small>
</h3>    <div class="page-bar">
        <ul class="page-breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <?= $this->Html->link(__('Home'), ['action' => 'dashboard']);?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <?= $this->Html->link(__d('plugin_manager', 'Plugins'), ['action' => 'index']);?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span><?= __('name') ?></span>
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
                                        $this->Html->link(__d('plugin_manager', 'Add New Plugins'),
                                            ['action' => 'add'],
                                            ['class' => 'btn btn-info']
                                        );
                                        ?>
                                        <?=
                                        $this->Html->link(__d('plugin_manager', 'List Plugins'),
                                            ['action' => 'index'],
                                            ['class' => 'btn btn-primary']
                                        );
                                        ?>
                                    </div>
                                </div>
                                <?= $this->Form->create($plugin, ['class' => 'form-horizontal']);?>
                                <div class="form-body">
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('plugin_manager', 'name'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->control('name', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('plugin_manager', 'theme'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->control('theme', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('plugin_manager', 'version'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->control('version', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('plugin_manager', 'new_version'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->control('new_version', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('plugin_manager', 'order'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->control('order', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            echo $this->Form->label(__d('plugin_manager', 'status'), null, [
                                                'class' => 'col-md-3 control-label'
                                            ]);
                                            ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->control('status', [
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'div' => false
                                                ]);
                                                ?>
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