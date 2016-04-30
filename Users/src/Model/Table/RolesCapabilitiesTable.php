<?php
namespace Users\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Spider\Model\Table\SpiderTable;
use Users\Model\Entity\RolesCapability;

/**
 * RolesCapabilities Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\BelongsTo $Capabilities
 */
class RolesCapabilitiesTable extends SpiderTable
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

        $this->table('roles_capabilities');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'className' => 'Users.Roles'
        ]);
        $this->belongsTo('Capabilities', [
            'foreignKey' => 'capability_id',
            'className' => 'Users.Capabilities'
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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['capability_id'], 'Capabilities'));
        return $rules;
    }
}
