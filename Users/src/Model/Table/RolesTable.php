<?php
namespace Users\Model\Table;

use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Search\Manager;
use Spider\Model\Table\SpiderTable;
use Users\Model\Entity\Role;

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

        $this->table('users_roles');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Tree');
        $this->belongsTo('ParentRoles', [
            'className' => 'Users.Roles',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildRoles', [
            'className' => 'Users.Roles',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsToMany('Users', [
            'through' => 'Users.UsersRoles'
        ]);
    }

    public function searchConfiguration(){
        $search = new Manager($this);
        $search
            ->like('q', [
                'before' => true,
                'after' => true,
                'field' => [
                    $this->aliasField('name'),
                    $this->aliasField('title'),
                ]
            ]);
        return $search;
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

    public function beforeSave(Event $event, Entity $entity, $options = []){
        //get all children of this role
        //remove this caps for all childrens
        if($entity->id){
            $capabilitiesIds = (new Collection($entity->capabilities))->extract('id')->filter()->toArray();
            $thisRoleChildrensIds = (new Collection($this->find('children', ['for' => $entity->id])))->extract('id')->filter()->toArray();
            $this->RolesCapabilities->deleteAll([
                'role_id IN' => $thisRoleChildrensIds,
                'capability_id IN' => $capabilitiesIds
            ]);
        }
    }

    public function findCapabilities(Query $query, array $options)
    {
        $allCapabilities = $this->Capabilities->find('list', [
            'keyField' => 'id',
            'valueField' => 'description'
        ])->toArray();
        $parentCapabilities = [];
        if(isset($options['id'])){
            $parentCapabilities = $this->getAllParentCapabilities($options['id']);
            ksort($parentCapabilities);
        }
        $allCapabilities = array_diff($allCapabilities, $parentCapabilities);
        ksort($allCapabilities);

        return ['parent' => $parentCapabilities, 'all' => $allCapabilities];
    }

    public function getAllParentCapabilities($id, $options = ['valueField' => 'description'])
    {
        $parents = $this->find('path', ['for' => $id])->toArray();
        if(!empty($parents)){
            array_pop($parents);
            $parentsIds = [];
            foreach($parents as $parent){
                $parentsIds[] = $parent->id;
            }

            if(!empty($parentsIds)){
                $parentCapabilities = $this->Capabilities->find('list',
                    array_merge([
                        'keyField' => 'id',
                        'valueField' => 'description'
                    ], $options))
                    ->matching('Roles', function($q) use ($parentsIds){
                        return $q->where(['Roles.id IN' => $parentsIds]);
                    });

                return $parentCapabilities->toArray();
            }
        }
        return [];
    }
}
