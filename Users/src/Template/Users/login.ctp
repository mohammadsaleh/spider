<?php
echo $this->Flash->render('Auth');
echo $this->Form->create();
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->button(__('Submit'));
echo $this->Form->end();