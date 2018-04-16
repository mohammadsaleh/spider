<?php
namespace AclManager\Model\Table;

use AclManager\Model\Entity\Aro;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Spider\Model\Table\SpiderTable;

/**
 * Aros Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Acos */
class ArosTable extends SpiderTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('spider_aclmanager_aros');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsToMany('Acos', [
            'foreignKey' => 'aro_id',
            'targetForeignKey' => 'aco_id',
            'joinTable' => 'spider_aclmanager_aros_acos',
            'className' => 'AclManager.Acos'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
        $validator
            ->allowEmpty('model');
        $validator
            ->add('foreign_key', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('foreign_key');
        return $validator;
    }
}
