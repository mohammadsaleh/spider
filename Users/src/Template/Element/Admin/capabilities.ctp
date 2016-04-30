<?php
$roleComatibilities = [];
if(!isset($isParent) || !$isParent){
    $isParent = false;
}
if(!$isParent){
    foreach($role->capabilities as $capability){
        $roleComatibilities[] = $capability->id;
    }
}
foreach($capabilities as $key => $title){
    $checked = false;
    $disabled = false;
    if(!$isParent){
        if(in_array($key, $roleComatibilities)){
            $checked = true;
        }
    }else{
        $checked = true;
        $disabled = true;
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
<?php }?>