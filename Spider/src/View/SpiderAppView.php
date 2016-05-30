<?php
namespace Spider\View;

use Cake\Event\Event;
use Cake\View\View;

/**
 * App View class
 */
class SpiderAppView extends View
{

    /**
     * Initialization hook method.
     *
     * For e.g. use this method to load a helper for all views:
     * `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Spider.Spider');
        $this->loadHelper('Html', ['className' => 'BootstrapUI.Html']);
        $this->loadHelper('Form', ['className' => 'BootstrapUI.Form']);
        $this->loadHelper('Flash', ['className' => 'BootstrapUI.Flash']);
        $this->loadHelper('Paginator', ['className' => 'BootstrapUI.Paginator']);
        $this->eventManager()->dispatch(new Event('Spider.SpiderAppView.initialize', $this));
    }
}
