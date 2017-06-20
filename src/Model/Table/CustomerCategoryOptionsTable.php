<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerCategoryOptions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $CustomerCategories
 * @property \Cake\ORM\Association\HasMany $CustomerCategoryValues
 *
 * @method \App\Model\Entity\CustomerCategoryOption get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomerCategoryOption newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomerCategoryOption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerCategoryOption|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerCategoryOption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerCategoryOption[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerCategoryOption findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomerCategoryOptionsTable extends Table
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

        $this->setTable('customer_category_options');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('CustomerCategories', [
            'foreignKey' => 'customer_category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CustomerCategoryValues', [
            'foreignKey' => 'customer_category_option_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->allowEmpty('value');

        $validator
            ->boolean('required')
            ->requirePresence('required', 'create')
            ->notEmpty('required');

        $validator
            ->boolean('font')
            ->requirePresence('font', 'create')
            ->notEmpty('font');
            
        $validator
            ->boolean('searchable')
            ->requirePresence('searchable', 'create')
            ->notEmpty('searchable');

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
        $rules->add($rules->existsIn(['customer_category_id'], 'CustomerCategories'));

        return $rules;
    }
}
