<?php
namespace AclManager\Model\Table;

use AclManager\Model\Entity\ArosAco;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Spider\Model\Table\SpiderTable;

/**
 * ArosAcos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Aros * @property \Cake\ORM\Association\BelongsTo $Acos */
class ArosAcosTable extends SpiderTable
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

        $this->table('aclmanager_aros_acos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Aros', [
            'foreignKey' => 'aro_id',
            'className' => 'AclManager.Aros'
        ]);
        $this->belongsTo('Acos', [
            'foreignKey' => 'aco_id',
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
            ->add('id', 'valid', ['rule' => 'integer'])
            ->allowEmpty('id', 'create');
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['aro_id'], 'Aros'));
        $rules->add($rules->existsIn(['aco_id'], 'Acos'));
        return $rules;
    }
}
