<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SmsDetails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $SmsTemplates
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $SmsRecords
 *
 * @method \App\Model\Entity\SmsDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\SmsDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SmsDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SmsDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SmsDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SmsDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SmsDetail findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SmsDetailsTable extends Table
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

        $this->setTable('sms_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SmsTemplates', [
            'foreignKey' => 'sms_template_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CustomerCategories', [
            'foreignKey' => 'customer_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SmsRecords', [
            'foreignKey' => 'sms_detail_id'
        ])->setDependent(true);
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
            ->allowEmpty('variables');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->integer('success')
            ->allowEmpty('success');

        $validator
            ->integer('fail')
            ->allowEmpty('fail');

        $validator
            ->integer('total')
            ->allowEmpty('total');

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
        $rules->add($rules->existsIn(['sms_template_id'], 'SmsTemplates'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
