<?php
namespace Settings\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Settings\Model\Entity\Setting;
use Spider\Model\Table\SpiderTable;

/**
 * Settings Model
 *
 */
class SettingsTable extends SpiderTable
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

        $this->setTable('spider_settings_settings');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
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
            ->allowEmpty('value');
        $validator
            ->allowEmpty('title');
        $validator
            ->allowEmpty('description');
        $validator
            ->allowEmpty('params');
        $validator
            ->add('weight', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('weight');
        $validator
            ->add('editable', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('editable');
        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('created_by');
        $validator
            ->add('updated_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('updated_by');
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
//        $rules->add($rules->existsIn(['created_by'], 'Users'));
//        $rules->add($rules->existsIn(['updated_by'], 'Users'));
        return $rules;
    }
}
