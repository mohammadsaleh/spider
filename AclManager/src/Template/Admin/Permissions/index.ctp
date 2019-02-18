<?php
$this->Html->css('tree/jquery.tree-multiselect.min', ['block' => true]);

$this->extend('/Common/content_index');
$this->assign('table_description', '');
$this->assign('content_title', !empty($title) ? $title : __('Permissions'));
$this->Breadcrumbs->add(!empty($title) ? $title : __('Permissions'));
?>
<?php $this->append('actions');?>
<?= $this->Html->link('<i class="fa fa-plus positio-left"></i> ' . __('New Setting'), ['action' => 'add'], ['class' => 'btn btn-success btn-sm', 'escape' => false]);?>
<?php $this->end();?>

<?php $this->append('css');?>
<style>
    .panel-group .panel-heading{
        padding: 0px 20px;
        line-height: 35px;
    }
    .panel-collapse > .panel-body{
        padding-left: 0;
        padding-right: 0;
    }
</style>
<?php $this->end();?>

<div class="content">
    <?php $this->append('table')?>
    <div class="col-md-12">
        <div class="tabbable nav-tabs-vertical nav-tabs-left">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="active"><a href="bootstrap_tabs.htm#users" data-toggle="tab" aria-expanded="false"><i class="fa fa-users position-left"></i> <?= __d('acl_manager', 'Role Permissions')?></a></li>
                <li class=""><a href="bootstrap_tabs.htm#user" data-toggle="tab" aria-expanded="true"><i class="fa fa-user position-left"></i> <?= __d('acl_manager', 'User Permissions')?></a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane has-padding active" id="users">

                    <div class="panel-group panel-group-control" id="accordion">
                        <?php foreach($roles as $id => $role){?>
                            <form class="panel" action="<?= \Cake\Routing\Router::url(\Spider\Lib\SpiderNav::getAdminScope() . "/access/permissions/r-$id")?>" method="post">
                            <div class="panel-heading bg-grey-300 clearfix">
                                <span class="panel-title pull-left">
                                    <?= $this->Html->link($role,
                                        "#accordion-group-$id",
                                        [
                                            'data-toggle' => "collapse",
                                            'data-parent' => "#accordion",
                                            'data-id' => $id,
                                            'data-href' => \Cake\Routing\Router::url(\Spider\Lib\SpiderNav::getAdminScope() . "/access/permissions/r-$id"),
                                            'class' => 'role-permissions collapsed'
                                        ]
                                    )
                                    ?>
                                </span>
                                <button class="btn btn-success pull-right" type="submit">apply</button>
                            </div>
                            <div id="accordion-group-<?=$id?>" class="panel-collapse collapse">
                                <div class="panel-body permissions-list permissions-list-<?=$id?>"></div>
                            </div>
                        </form>
                        <?php }?>
                    </div>
                </div>

                <div class="tab-pane has-padding" id="user">

                </div>
            </div>
        </div>
    </div>
    <?php $this->end()?>
</div>

<?php $this->append('script'); ?>
<script>
    $(document).ready(function(){
        $('.role-permissions').on('click', function(e){
            $('.permissions-list').each(function(){
                $(this).empty();
            });
            href = $(this).data('href');
            id = $(this).data('id');
            $.ajax({
                url: href,
                success: function(response){
                    $('.permissions-list-'+id).html(response);
                }
            });
        });
    })
</script>
<?php $this->end();?>
