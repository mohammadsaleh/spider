<?php
namespace AclManager\View\Helper;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Spider\Lib\SpiderNav;
use Users\Lib\UserLib;

/**
 * Created by PhpStorm.
 * User: Davari
 * Date: 9/3/2016
 * Time: 1:11 PM
 */
class AclHelper extends Helper
{

    /**
     * Check permissions of admin menu items
     *
     * @param $items
     */
    public function checkMenuPermissions(&$items)
    {
        foreach ($items as $key => &$item){
            $url = $item['url'];
            if(is_string($url)){
                if((strpos($url, '#') === false)){
                    $url = Router::parse($url);
                }elseif(empty($item['children'])){
                    unset($items[$key]);
                    continue;
                }
            }
            if(is_array($url) || (is_string($url) && (strpos($url, '#') === false))){
                $prefix = Inflector::camelize(trim(SpiderNav::getAdminScope()), '/') . '/';
                $plugin = Inflector::camelize($url['plugin']) ? 'plugin/' . Inflector::camelize($url['plugin']) . '/' : '';
                $controller = Inflector::camelize($url['controller']) . '/';
                $action = $url['action'];
                $aco = $plugin . $prefix . $controller . $action . '/';
                if(!UserLib::getAuth()->hasAllow($aco)){
                    unset($items[$key]);
                }else{
                    $this->checkMenuPermissions($item['children']);
                }
            }else{
                $this->checkMenuPermissions($item['children']);
            }
            if(empty($item['children']) && (!is_array($item['url']) && strpos($item['url'], '#') !== false)){
                unset($items[$key]);
            }
        }
    }
}