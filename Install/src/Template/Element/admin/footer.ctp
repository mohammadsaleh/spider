<?php  use Cake\Core\Configure; ?>
<footer class="navbar-inverse">
    <div class="navbar-inner">

        <div class="footer-content">
            <?php
            $link = $this->Html->link(
                __d('croogo', 'Croogo %s', strval(Configure::read('Croogo.version'))),
                'http://www.croogo.org'
            );
            ?>
            <?php echo __d('croogo', 'Powered by %s', $link); ?>
            <?php echo $this->Html->image('//assets.croogo.org/powered_by.png'); ?>
        </div>

    </div>
</footer>


<footer class="navbar-inverse">
    <div class="navbar-inner">

        <div class="footer-content">
            Powered by <a href="http://www.croogo.org">Croogo </a>	<img src="//assets.croogo.org/powered_by.png" class="" alt="">	</div>

    </div>
</footer>