<div class="install">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5><?php echo $title_for_layout; ?></h5>
        </div>
        <div class="panel-body">
            <?php if ($installed): ?>
                <p class="success">
                    <?php echo __d('spider', 'The user %s has been created with administrative rights.',
                        sprintf('<strong>%s</strong>', $user['User']['username']));
                    ?>
                </p>

                <p>
                    <?php echo __d('spider', 'Admin panel: %s', $this->Html->link(Router::url('/admin', true), Router::url('/admin', true))); ?>
                </p>

                <p>
                    <?php
                    echo __d('spider', 'You can start with %s or jump in and %s.',
                        $this->Html->link(__d('spider', 'configuring your site'), $urlSettings),
                        $this->Html->link(__d('spider', 'create a blog post'), $urlBlogAdd)
                    );
                    ?>
                </p>
            <?php endif; ?>

            
        </div>


    </div>
</div>

