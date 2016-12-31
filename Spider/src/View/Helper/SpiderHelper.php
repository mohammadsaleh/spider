<?php
namespace Spider\View\Helper;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\View;
use Spider\Lib\Date\Persian;
use Spider\Lib\Spider;
use Spider\Lib\SpiderNav;
use Users\Lib\UserLib;

/**
 * Spider helper
 */
class SpiderHelper extends Helper
{

    public $helpers = ['Html', 'Time', 'Acl'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    protected $_hasActiveMenuItem = false;

    /**
     * @param string $format
     * @param int|string|DateTime $date
     * @return mixed|string
     */
    public function persianDate($date, $format = 'Y-m-d H:i:s')
    {
        $time = new Time($date);
//        $unix = $time->i18nFormat(\IntlDateFormatter::FULL, 'Asia/Tehran', 'en_US')->toUnixString();
//        debug($unix);die;
        return Persian::date($format, (int)$time->toUnixString(), '', 'Asia/Tehran', 'en');
    }

    /**
     * @param int|string|DateTime $date
     * @return mixed
     */
    public function getTimeStamp($date)
    {
        return $this->Time->toUnix($date, 'Asia/Tehran');
    }

    public function adminMenus($items, $options = [], $depth = 0)
    {
        if($depth == 0){
            if($this->Acl){
                $this->Acl->checkMenuPermissions($items);
            }
        }
        $options += [
//            'a-' . $depth => [],
//            'a-*' => [],
//            'li-*' => [
//                'active' => ['class' => 'active'],
//                'open' => ['class' => 'open']
//            ],
            'type' => 'sidebar',
            'children' => true,
            'title' => ['class' => 'title'],
            'arrow' => ['class' => 'arrow'],
            'child_ul' => [
                'class' => 'sub-menu'
            ]
        ];
        $output = '';
        $items = Hash::sort($items, '{s}.weight', 'ASC');
        foreach($items as $item){
            $liClass = [];
            if($this->request->here == Router::url($item['url'])){
                $liClass[] = 'active';
                if($depth > 0){
                    $this->_hasActiveMenuItem = true;
                }
            }
            $childrenBody = '';
            if(!empty($item['children'])){
                $childrenBody .= $this->Html->tag('ul', null, $options['child_ul']);
                $childrenBody .= $this->adminMenus($item['children'], $options, ($depth+1));
                $childrenBody .= $this->tagend('ul');
            }

            //If first item and has current url is in sub child then active&open menu
            //Then reset activeMenu flag
//            $listOptions = (isset($options['li-' . $depth]) ? $options['li-' . $depth] : (isset($options['li-*']) ? $options['li-*'] : []));
//            debug($listOptions);die;
            if($this->_hasActiveMenuItem && $depth == 0){
                $liClass[] = 'active';
                $liClass[] = 'open';
                $this->_hasActiveMenuItem = false;
            }
            $output .= $this->Html->tag('li', null, ['class' => $liClass]);
            $linkOptions = (isset($options['a-' . $depth]) ? $options['a-' . $depth] : (isset($options['a-*']) ? $options['a-*'] : []));
            $output .= $this->Html->link(
                $this->__buildMenuLinkBody($item, $depth, $options),
                $item['url'],
                array_merge(['escape' => false], $linkOptions)
            );
            $output .= $childrenBody;
            $output .= $this->tagend('li');
        }
        return $output;
    }
    /*public function adminMenus($items, $options = [], $depth = 0)
    {
        $options += [
            'type' => 'sidebar',
            'children' => true,
            'title' => ['class' => 'title'],
            'arrow' => ['class' => 'arrow'],
            'child_ul' => [
                'class' => 'sub-menu'
            ]
        ];
        $output = '';
        $items = Hash::sort($items, '{s}.weight', 'ASC');
        foreach($items as $item){
            $liClass = [];
            if($this->request->here == Router::url($item['url'])){
                $liClass[] = 'active';
                if($depth > 0){
                    $this->_hasActiveMenuItem = true;
                }
            }
            $childrenBody = '';
            if(!empty($item['children'])){
                $childrenBody .= $this->Html->tag('ul', null, $options['child_ul']);
                $childrenBody .= $this->adminMenus($item['children'], $options, ($depth+1));
                $childrenBody .= $this->tagend('ul');
            }

            //If first item and has current url is in sub child then active&open menu
            //Then reset activeMenu flag
            if($this->_hasActiveMenuItem && $depth == 0){
                $liClass[] = 'active';
                $liClass[] = 'open';
                $this->_hasActiveMenuItem = false;
            }
            $output .= $this->Html->tag('li', null, ['class' => $liClass]);
            $output .= $this->Html->link(
                $this->__buildMenuLinkBody($item, $depth, $options),
                $item['url'],
                ['escape' => false]
            );
            $output .= $childrenBody;
            $output .= $this->tagend('li');
        }
        return $output;
    }*/

    private function __buildMenuLinkBody($item, $depth, $options = [])
    {
        $linkBody = [
            'icon' => $this->Html->tag('i', '', ['class' => $item['icon']]),
            'title' => $item['title'],
            'arrow' => ''
        ];
        if($depth == 0){
            $linkBody['title'] = $this->Html->tag('span', $item['title'], $options['title']);
        }
        if(!empty($item['children']) && $options['arrow']){
            $linkBody['arrow'] = $this->Html->tag('span', '', $options['arrow']);
        }
        return implode('', $linkBody);
    }

    public function tagend($tag)
    {
        return $this->Html->formatTemplate('tagend', [
            'tag' => $tag
        ]);
    }

    public function generateStar($fullStarNumber = 0, $options = [])
    {
        $output = '';
        $options += [
            'full' => 'glyphicon glyphicon-star',
            'empty' => 'glyphicon glyphicon-star-empty',
        ];
        for($i = 0; $i < min($fullStarNumber, 5); $i++){
            $output .= $this->Html->tag('i', '', ['class' => $options['full']]);
        }
        for($i = 0; $i < (5 - min($fullStarNumber, 5)); $i++){
            $output .= $this->Html->tag('i', '', ['class' => $options['empty']]);
        }
        return $output;
    }

    public function getWeekDay($dayNumber){
        $weekDays = ['شنبه', 'یکشنبه','دوشنبه','سه شنبه','چهارشنبه','پنجشنبه','جمعه'];
        if($dayNumber >= 0 && $dayNumber <= 6){
            return $weekDays[$dayNumber];
        }
        return '';
    }

    public function status($status, $options = [], $url = null)
    {
        $options = [
            'icons' => [
                0 => 'published',
                1 => 'unpublished',
            ],
            'ajax_url' => null,
        ];
    }

    public function script($blockName = null, $scripts = [])
    {
        if(is_array($blockName)){
            $scripts = $blockName;
            $blockName = 'script';
        }elseif(!empty($scripts)){
            $blockName = $blockName ?: 'script';
        }
        //Write and cache script items to given blockName.
        foreach($scripts as &$scriptItem){
            if(!is_array($scriptItem)){
                $scriptItem = ['url' => $scriptItem, 'weight' => 10];
            }elseif(count($scriptItem) == 1){
                $scriptItem = ['url' => array_shift($scriptItem), 'weight' => 10];
            }else{
                $scriptItem = ['url' => array_shift($scriptItem), 'weight' => array_shift($scriptItem)];
            }
        }
        $scripts = Hash::combine($scripts, '{n}.url', '{n}');
        Spider::mergeConfig('Spider.' . $blockName, $scripts);
    }

    public function fetch($blockName)
    {
        //Read script block items.
        $output = '';
        $scripts = Configure::consume('Spider.' . $blockName);
        $scripts = Hash::sort($scripts, '{s}.weight', 'asc');
        foreach($scripts as $script){
            $output .= $this->Html->script($script['url']) . "\n";
        }
        return $output;
    }
}
