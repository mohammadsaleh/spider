<?php
echo $this->Flash->render('Auth');
echo $this->Form->create();
echo $this->Form->control('username');
echo $this->Form->control('password');
echo $this->Form->button(__('Submit'));
echo $this->Form->end();