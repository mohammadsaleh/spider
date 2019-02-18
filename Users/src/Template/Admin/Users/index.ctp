<?php
$this->Html->script('forms/uniform.min', ['block' => true]);
$this->Html->script('forms/tokenfield.min', ['block' => true]);
$this->Html->script('forms/tagsinput.min', ['block' => true]);
$this->Html->script('forms/typeahead.bundle.min', ['block' => true]);
$this->Html->script('forms/uniform.min', ['block' => true]);
$this->extend('/Common/content_index');
$this->element('index_scripts');
$this->assign('content_title', !empty($title) ? $title : __('List User'));
$this->assign('table_title', 'Table Title');
$this->assign('table_description', 'Table Description');
$this->Breadcrumbs->add(!empty($title) ? $title : __('List User'));

$indexDataTable = $this->DataTables->create('.index-datatable');
$indexDataTable->setConfig('columnSearch', true);
$indexDataTable->setConfig(['displayLength' => 10]);
$indexDataTable->ajax(\Cake\Routing\Router::url(['action' => 'index']));

$this->append('script');
?>
<script>
var indexDatatable = {
    columns: [
        {
            name: 'Users.id',
            data: 'id',
            searchable: true
        },
        {
            name: 'Users.username',
            data: 'username',
            searchable: true
        },
        {
            name: 'Users.firstname',
            data: 'firstname',
            render: function(data, type, full, meta){
                return data + ' ' + full.lastname;
            }
        },
        {
            name: 'Users.lastname',
            data: 'lastname',
            visible: false
        },
        {
            name: 'Users.mobile',
            data: 'mobile',
            render: function (data, type, full, meta) {
                var output = data;
                if(full.users_profile && full.users_profile.agency_phone){
                    output += '<br />' + full.users_profile.agency_phone;
                }
                return output;
            }
        },
        {
            name: 'Users.avatar',
            data: 'avatar',
            searchable:false,
            render: function(data, type, full, meta){
                if(data){
                    return '<img src="<?= $this->request->base?>' + data + '" class="avatar" alt="">';
                }
                return '';
            }
        },
        {
            name: 'Users.status',
            data: 'status',
            searchable: true,

            render: function (data, type, full, meta) {
                switch(data){
                    case -1:
                        return '<span class="label label-danger"><?=__d('users', 'Deleted')?></span>';
                    case 0:
                        return '<span class="label label-warning"><?=__d('users', 'DeActive')?></span>';
                    case 1:
                        return '<span class="label label-success"><?=__d('users', 'Active')?></span>';
                    case 2:
                        return '<span class="label label-info"><?=__d('users', 'Profile Completed')?></span>';
                    case 3:
                        return '<span class="label label-primary"><?=__d('users', 'Charged Account')?></span>';

                }
            }
        },
        {
            name: 'Users.created',
            data: 'created',
            searchable: false,
        },
        {
            name: 'Users.modified',
            data: 'modified',
            searchable: false,
        },
        {
            data: null,
            render: function(data,type,full,meta) {
                var output = '<?= str_replace(["\n", "\r"], '', $this->element('index_actions'))?>';
                output = output.replace(new RegExp("-ID-", 'gi'), data.id);
                return output;
            }
        }
    ],
};
</script>

<?php
$this->end();
?>

<?php $this->append('actions');?>
<?= $this->Html->link('<i class="fa fa-plus positio-left"></i> ' . __('New User'), ['action' => 'add'], ['class' => 'btn btn-success btn-sm', 'escape' => false]);?>
<?php $this->end();?>

<?php $this->append('table');?>
<style>
    .avatar{
        max-width:30%;
        width:100px
    }
</style>
<table id="example" class="table datatable index-datatable">
    <thead>
        <tr>
            <th>
                id
                <input type="text" class="form-control input-sm">
            </th>
            <th>
                username
            </th>
            <th>
                full name
            </th>
            <th>
                last name
            </th>
            <th>
                mobile
            </th>
            <th>avatar</th>
            <th>
                status
                <?= $this->Form->select('status', [
                   '' => '',
                   -1 => 'Deleted',
                   0  => 'DeActive',
                   1  => 'Active',
                   2  => 'Profile Completed',
                   3  => 'Charged Account',
                ], ['class' => 'form-control']);?>
            </th>
            <th>created</th>
            <th>modified</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<?php $this->end();?>