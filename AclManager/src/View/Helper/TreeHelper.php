<?php
namespace AclManager\View\Helper;
use Cake\View\Helper;

/**
 * Created by PhpStorm.
 * User: Davari
 * Date: 9/3/2016
 * Time: 1:11 PM
 */
class TreeHelper extends Helper
{

    public $helpers = ['Html', 'Spider'];

    public function aro($nodes = [], $level = 0)
    {
        $output = '';
        if(!empty($nodes)){
            foreach($nodes as $node){
                $ulOptions = ['class' => 'list'];
                if($level == 0){
                    $ulOptions = array_merge($ulOptions, ['class' => 'list-icons no-margin-bottom']);
                }
                $output .= $this->Html->tag('ul', null, $ulOptions);
                $output .= $this->Html->tag('li');
                $output .= $this->Html->tag('i', '', ['class' => 'fa fa-arrow-circle-o-right text-white']);
                $output .= $this->Html->link($node['title'],
                    '/admin/access/permissions/r-' . $node['id'],
                    [
                        'class' => 'role-permissions text-white'
                    ]
                );
                if(!empty($node['children'])){
                    $output .= $this->aro($node['children'], ($level + 1));
                }
                $output .= $this->Spider->tagend('li');
                $output .= $this->Spider->tagend('ul');
            }
        }
        return $output;
    }
}