<?php
namespace AclManager\Model\Table;

use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Search\Manager;
use Spider\Model\Table\SpiderTable;
use AclManager\Model\Entity\Role;

/**
 * Roles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentRoles
 * @property \Cake\ORM\Association\HasMany $ChildRoles
 * @property \Cake\ORM\Association\HasMany $Users
 */
class RolesTable extends SpiderTable
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

        $this->setTable('spider_aclmanager_roles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Tree');
        $this->belongsTo('ParentRoles', [
            'className' => 'AclManager.Roles',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildRoles', [
            'className' => 'AclManager.Roles',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsToMany('Users.Users', [
            'through' => 'AclManager.UsersRoles'
        ]);
    }

//    public function searchConfiguration(){
//        $search = new Manager($this);
//        $search
//            ->like('q', [
//                'before' => true,
//                'after' => true,
//                'field' => [
//                    $this->aliasField('name'),
//                    $this->aliasField('title'),
//                ]
//            ]);
//        return $search;
//    }

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
            ->add('lft', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('lft');

        $validator
            ->add('rght', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('rght');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentRoles'));
        return $rules;
    }

}
