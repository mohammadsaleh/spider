<?php
echo $this->Html->script('jquery_ui/jquery-ui.min');
echo $this->Html->script('tree/jquery.tree-multiselect.min');
?>
<select id="treeview-select" multiple="multiple" name="permissions[]">
    <?php
    foreach($allAcos as $key => $aco){
    ?>
        <option value="<?= $key?>" <?= in_array($key, $permissions) ? 'selected' : ''?> data-section="<?= substr($key, 0, strrpos($key, '/') > 0 ? strrpos($key, '/') : strlen($key))?>"><?= !empty($aco['title']) ? $aco['title'] : $aco['name']?></option>
    <?php
    }
    ?>
</select>
<script>
    $(document).ready(function(){
        $("#treeview-select").treeMultiselect({
            enableSelectAll: true,
            sortable: true,
            hideSidePanel: true,
            startCollapsed: true
        });
    })
</script>