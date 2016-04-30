<?php
namespace Users\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Search\Manager;
use Spider\Model\Table\SpiderTable;
use Users\Model\Entity\User;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Presenters
 * @property \Cake\ORM\Association\BelongsTo $Cities
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $ActivationKeys
 * @property \Cake\ORM\Association\HasMany $UserAccounts
 * @property \Cake\ORM\Association\HasMany $UserLogins
 * @property \Cake\ORM\Association\BelongsToMany $Banks
 */
class UsersTable extends SpiderTable
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

        $this->table('users');
        $this->displayField('alias');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Presenters', [
            'foreignKey' => 'presenter_id',
            'className' => 'Users.Users'
        ]);
//        $this->belongsTo('Cities', [
//            'foreignKey' => 'city_id',
//            'className' => 'Users.Cities'
//        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'className' => 'Users.Roles'
        ]);
        $this->hasMany('ActivationKeys', [
            'foreignKey' => 'user_id',
            'className' => 'Users.ActivationKeys'
        ]);
        $this->hasMany('UserAccounts', [
            'foreignKey' => 'user_id',
            'className' => 'Users.UserAccounts'
        ]);
        $this->hasMany('UserLogins', [
            'foreignKey' => 'user_id',
            'className' => 'Users.UserLogins'
        ]);
        $this->hasMany('RewardRequests', [
            'foreignKey' => 'user_id',
            'className' => 'Bazibartar.RewardRequests'
        ]);
        $this->hasMany('UsersAgencies', [
            'foreignKey' => 'user_id',
            'className' => 'B2b.UsersAgencies'
        ]);

        $this->belongsToMany('Banks', [
            'through' => 'Users.UsersBanks'
//            'foreignKey' => 'user_id',
//            'targetForeignKey' => 'bank_id',
//            'joinTable' => 'users_banks',
//            'className' => 'Users.Banks'
        ]);
        $this->belongsToMany('Capabilities', [
            'through' => 'UsersCapabilities'
        ]);
    }

    public function searchConfiguration()
    {
        $search = new Manager($this);
        $search
            ->value('username', [
                'field' => $this->aliasField('username')
            ])
            ->like('q', [
                'before' => true,
                'after' => true,
                'field' => [
                    $this->aliasField('firstname'),
                    $this->aliasField('lastname')
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
            ->add('username', 'email', [
                'rule' => ['email'],
                'message' => 'ایمیل وارد شده معتبر نمی باشد'
            ]);

        $validator
            ->add('password', 'valid', [
                'rule' => ['minLength', 8],
                'message' => 'رمز عبور حداقل 8 کاراکتر باشد'
            ]);

        $validator
            ->add('confirm_password', 'valid', [
                'rule' => ['minLength', 8],
                'message' => 'رمز عبور حداقل 8 کاراکتر باشد'
            ])
            ->add('confirm_password', 'confirmation', [
                'rule' => ['compareWith', 'password'],
                'message' => 'رمز عبور و تایید رمز عبور یکسان نیست'
            ]);

        $validator
            ->allowEmpty('firstname');

        $validator
            ->allowEmpty('lastname');

        $validator
            ->allowEmpty('alias');

        $validator
            ->allowEmpty('mobile');

        $validator
            ->allowEmpty('birthday');

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
        $rules->add($rules->isUnique(['username'], 'این ایمیل قبلا در سیستم موجود می باشد.'));
//        $rules->add($rules->existsIn(['presenter_id'], 'Users'));
//        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        return $rules;
    }
    
//    public function beforeSave(Event $event, Entity $entity, $options = []){
//
//    }
}
