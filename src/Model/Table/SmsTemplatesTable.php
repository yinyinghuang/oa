<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SmsTemplates Model
 *
 * @method \App\Model\Entity\SmsTemplate get($primaryKey, $options = [])
 * @method \App\Model\Entity\SmsTemplate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SmsTemplate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SmsTemplate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SmsTemplate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SmsTemplate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SmsTemplate findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SmsTemplatesTable extends Table
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

        $this->setTable('sms_templates');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('SmsDetails', [
            'foreignKey' => 'sms_template_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('templateid', 'create')
            ->notEmpty('templateid');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->allowEmpty('variables');

        $validator
            ->requirePresence('sign', 'create')
            ->notEmpty('sign');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->isUnique(['templateid']));

        return $rules;
    }
}
