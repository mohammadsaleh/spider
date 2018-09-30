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
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $ActivationKeys
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

        $this->setTable('spider_users_users');
        $this->setDisplayField('alias');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('Users.ActivationKeys', [
            'foreignKey' => 'user_id',
            'className' => 'Users.ActivationKeys'
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
        return $rules;
    }

    public function beforeSave(Event $event, Entity $entity, $options = [])
    {
//        debug($entity);
//        debug($options);
//        die;
    }
}
