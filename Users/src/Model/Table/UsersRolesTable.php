<?php
namespace Users\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Spider\Model\Table\SpiderTable;
use Users\Model\Entity\UsersRole;

/**
 * UsersRoles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentUsersRoles * @property \Cake\ORM\Association\HasMany $ChildUsersRoles */
class UsersRolesTable extends SpiderTable
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

        $this->table('spider_users_users_roles');
        $this->primaryKey('id');
        $this->belongsTo('Users', [
            'className' => 'Users.Users',
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Roles', [
            'className' => 'Users.Roles',
            'foreignKey' => 'role_id'
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
        return $rules;
    }
}
