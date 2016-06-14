<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Saleh
 * Date: 8/29/2015
 * Time: 10:59 PM
 */
namespace Spider\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Spider\Lib\Hook;

class SpiderTable extends Table
{

    public function initialize(array $config){
        parent::initialize($config);
        $this->addBehavior('Search.Search');
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        Hook::applyHookMethods('Hook.table_methods', $this);
        $this->eventManager()->dispatch(new Event('SpiderTable.afterConstruct', $this));
    }

    public function setField($conditions, $fieldName, $fieldValue = null){
        if(!is_array($conditions)){
            $entity = $this->get($conditions);
        }else{
            $entity = $this->find()->where($conditions)->first();
        }
        /** @var Entity $entity */
        if($entity){
            if(in_array($fieldName, $this->schema()->columns())) {
                if(!isset($fieldValue)){
                    $entity->{$fieldName} = (int)!$entity->{$fieldName};
                }else{
                    $entity->{$fieldName} = $fieldValue;
                }
                if($this->save($entity)){
                    return $entity->{$fieldName};
                }
            }
        }
        return false;
    }

    public function __call($method, $args){
        if (preg_match('/^(set|toggle)(?:[A-Z][a-z_]*)+$/', $method, $match) > 0){
            $method = ltrim($method, $match[1]);
            $fieldName = strtolower(preg_replace('/(?<=\w)(?=[A-Z])/', '_$1', $method));
            return $this->setField($args[0], $fieldName, (!empty($args[1]) ? $args[1] : null));
        }else{
            return parent::__call($method, $args);
        }
    }

}