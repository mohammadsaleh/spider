<?php
$this->Html->script('ckeditor_4.6.1/ckeditor', ['block' => true]);
$this->extend('/Common/content_form');
$this->element('form_scripts');
$this->assign('content_title', !empty($title) ? $title : __('Add Setting'));
$this->Html->addCrumb(!empty($title) ? $title : __('Site Setting'));
$this->set('form', $this->Form->create(null, ['class' => 'form-horizontal']));
?>


<?php $this->append('form');?>
    <div class="panel-heading">
    <h4 class="panel-title"><?= __('Add Setting') ?></h4>
</div>
    <div class="panel-body">
    <div class="tabbable">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="active">
                <a href="#site-settings" data-toggle="tab">Site</a>
            </li>
            <li>
                <a href="#other-settings" data-toggle="tab">Other</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="site-settings">
                <?php
                foreach($settings as $setting) {
                    if(!$setting['editable']){
                        continue;
                    }
                    $options = ['type' => $setting['type'], 'label' => false, 'class' => 'form-control'];
                    $options['value'] = $setting['value'];
                    $options['id'] = 'settings-' . str_replace('.', '-', $setting['name']);
                    if($setting['params']){
                        $options = array_merge($options, json_decode($setting['params'], true));
                    }
                    if($options['type'] == 'radio'){
                        $options['templates'] = [
                            'nestingLabel' => '{{hidden}}<label{{attrs}} class="radio-inline radio-left">{{input}}{{text}}</label>'
                        ];
                    }
                    if(isset($options['ckeditor'])){
                        $this->Html->scriptBlock('CKEDITOR.replace("' . $options['id'] . '");', ['block' => true]);
                        unset($options['ckeditor']);
                    }
//                    debug($options);die;
                    ?>
                    <div class="form-group">
                    <label class="control-label col-lg-3"><?= $setting['title'] ?></label>
                    <div class="col-lg-9">
                    <?= $this->Form->control('settings.' . $setting['name'], $options); ?>
                    </div>
                </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane" id="other-settings">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
            </div>
        </div>
    </div>
</div>
<?php $this->end();?>