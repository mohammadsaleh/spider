<?php
namespace AclManager\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Spider\Model\Table\SpiderTable;
use AclManager\Model\Entity\UsersRole;

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

        $this->setTable('spider_aclmanager_users_roles');
        $this->setPrimaryKey('id');
        $this->belongsTo('Users', [
            'className' => 'Users.Users',
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Roles', [
            'className' => 'AclManager.Roles',
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

    public function afterSave(Event $event, Entity $entity, $options = [])
    {
//        debug($options);
//        debug($entity);die;
    }
}
