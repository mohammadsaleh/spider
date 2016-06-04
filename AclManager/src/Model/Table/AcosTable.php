<?php
namespace AclManager\Model\Table;

use AclManager\Model\Entity\Aco;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Spider\Model\Table\SpiderTable;

/**
 * Acos Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Aros */
class AcosTable extends SpiderTable
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

        $this->table('spider_aclmanager_acos');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->belongsToMany('Aros', [
            'foreignKey' => 'aco_id',
            'targetForeignKey' => 'aro_id',
            'joinTable' => 'aclmanager_aros_acos',
            'className' => 'AclManager.Aros'
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
            ->allowEmpty('name');
        $validator
            ->allowEmpty('title');
        $validator
            ->allowEmpty('description');
        $validator
            ->allowEmpty('model');
        $validator
            ->add('foreign_key', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('foreign_key');
        return $validator;
    }
}
