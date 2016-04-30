<?php
namespace Users\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Spider\Model\Table\SpiderTable;
use Users\Model\Entity\Capability;

/**
 * Capabilities Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Roles
 * @property \Cake\ORM\Association\BelongsToMany $Users
 */
class CapabilitiesTable extends SpiderTable
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

        $this->table('capabilities');
        $this->displayField('title');
        $this->primaryKey('id');
        $this->belongsToMany('Roles', [
            'through' => 'RolesCapabilities',
        ]);
        $this->belongsToMany('Users', [
            'through' => 'UsersCapabilities'
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
            ->allowEmpty('title');

        $validator
            ->allowEmpty('description');

        return $validator;
    }
}
