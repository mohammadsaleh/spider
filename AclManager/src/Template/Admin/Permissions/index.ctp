<?php $this->Html->css('/assets/css/app/email', ['block' => 'top_css'])?>
<div class="page-header"><h1>Inbox <small>Your custom mailing box</small></h1></div>
<div class="row">
    <div class="col-sm-3">
        <a href="email-compose.html" class="btn btn-danger btn-block">Compose</a>
        <hr class="clean">
        <div class="panel panel-default">
            <div class="panel-heading clean"><?= __d('acl_manager', 'Roles')?></div>
            <div class="panel-body no-padd">
                <div class="list-group no-margn mail-nav">
                    <?php foreach($roles as $id => $role){?>
                    <?= $this->Html->link($role, '/admin/access/list/'.$id, ['class' => 'list-group-item'])?>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-9">
        <div class="row">
            <div class="col-lg-9 col-xs-5">
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                 All <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">All</a></li>
                <li><a href="#">None</a></li>
                <li><a href="#">Read</a></li>
                <li><a href="#">Unread</a></li>
                <li><a href="#">Starred</a></li>
                <li><a href="#">UnStarred</a></li>
              </ul>
            </div>
            <button type="button" class="btn btn-default dropdown-toggle tooltip-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh"><i class="fa fa-refresh"></i></button>
            <div class="btn-group visible-lg-inline-block">
              <button type="button" class="btn btn-default tooltip-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Archive"><i class="fa fa-inbox"></i></button>
              <button type="button" class="btn btn-default tooltip-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Move to folder"><i class="fa fa-folder"></i></button>
              <button type="button" class="btn btn-default tooltip-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></button>
            </div>
            </div>
            <div class="col-lg-3 col-xs-7">
            <div class="input-group">
              <input type="search" class="form-control" placeholder="Search mail">
              <span class="input-group-btn">
                <button class="btn btn-purple" type="button"><i class="fa fa-search"></i></button>
              </span>
            </div>
            </div>
        </div>
        <hr class="clean">
        <div class="panel panel-default">
            <div class="panel-body">

                <table class="table table-hover mails">
                    <tbody><tr class="active">
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Google Inc</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Account verification confirm</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        07:23 AM
                        </td>
                    </tr>
                    <tr class="active">
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Facebook</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Mauris bibendum felis quis <span class="label label-warning">tortor ultricies</span></a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        07:10 AM
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star text-warning"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Akshay Kumar</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Sed congue libero sit amet dui laoreet</a>
                        </td>
                        <td class="mail-attachment visible-lg">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        05:42 AM
                        </td>
                    </tr>
                    <tr class="active">
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">John Doe</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Vivamus porttitor ante et</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Nov 02
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star text-warning"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">ThemeForest</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Aliquam <span class="label label-primary">luctus nibh</span> ac maximus ornare</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Nov 03
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Twitter Inc</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Activate your account</a>
                        </td>
                        <td class="mail-attachment visible-lg">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Nov 03
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Sakshi Arora</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">In sit amet arcu in erat venenatis ornare.</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Nov 03
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Google Inc</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Account verification confirm</a>
                        </td>
                        <td class="mail-attachment visible-lg">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Nov 14
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star text-warning"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Maecenas vitae</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Aliquam ultricies purus eget interdum finibus.</a>
                        </td>
                        <td class="mail-attachment visible-lg">
                        <i class="fa fa-paperclip"></i>
                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Nov 27
                        </td>
                    </tr>
                    <tr class="active">
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Morbi lacinia magna</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Quisque eleifend elit porttitor ipsum</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Oct 18
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Vivamus porttitor</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Sed <span class="label label-success">congue est quis</span> risus ipsum lacinia consequat.</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Oct 20
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Google Inc</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Account verification confirm</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Oct 29
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Maecenas vitae</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Aliquam ultricies purus eget interdum finibus.</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Oct 27
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Morbi lacinia magna</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Quisque eleifend elit porttitor ipsum</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Oct 30
                        </td>
                    </tr>
                    <tr>
                        <td class="mail-select">
                        <label class="cr-styled">
                            <input type="checkbox" ng-model="todo.done" class="ng-pristine ng-untouched ng-valid">
                            <i class="fa"></i>
                        </label>
                        </td>
                        <td class="mail-rateing">
                        <i class="fa fa-star"></i>
                        </td>
                        <td class="sender visible-lg visible-md">
                        <a href="email-read.html">Vivamus porttitor</a>
                        </td>

                        <td class="mail-content">
                        <a href="email-read.html">Sed congue est quis risus</a>
                        </td>
                        <td class="mail-attachment visible-lg">

                        </td>
                        <td class="text-right visible-lg visible-md visible-sm">
                        Oct 30
                        </td>
                    </tr>
                </tbody></table>

                <hr>

                <div class="row">
                    <div class="col-xs-7">
                        Showing 1 - 20 of 141
                    </div>
                    <div class="col-xs-5">
                        <div class="btn-group pull-right">
                          <button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i></button>
                          <button type="button" class="btn btn-default"><i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>