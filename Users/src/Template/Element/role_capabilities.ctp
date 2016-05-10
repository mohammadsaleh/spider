<?php
$itsOwnCapabilities = [];
if(!isset($role)){
    $role = [];
}
$itsOwnCapabilities = \Cake\Utility\Hash::extract($role, 'capabilities.{n}.id');
foreach($capabilities as $type => $allCapabilities){
    foreach($allCapabilities as $key => $title){
        $checked = false;
        $disabled = false;
        if($type == 'parent'){
            $checked = true;
            $disabled = true;
        }
        if($type == 'all'){
            if(in_array($key, $itsOwnCapabilities)){
                $checked = true;
            }
        }
?>
    <div>
        <span>
            <?=
            $this->Form->checkbox('capabilities._ids.', [
                'class' => 'make-switch',
                'data-on-text' => __("Yes"),
                'data-off-text' => __("No"),
                'hiddenField' => false,
                'checked' => $checked,
                'disabled' => $disabled,
                'value' => $key,
                'div' => false,
                'label' => false
            ]);
            ?>
        </span>
        <?= ' : ' . $title;?>
    </div>
<?php
    }
}
?>