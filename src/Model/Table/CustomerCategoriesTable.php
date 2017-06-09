<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerCategories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentCustomerCategories
 * @property \Cake\ORM\Association\HasMany $ChildCustomerCategories
 * @property \Cake\ORM\Association\HasMany $CustomerCategoryOptions
 * @property \Cake\ORM\Association\HasMany $Customers
 *
 * @method \App\Model\Entity\CustomerCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomerCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomerCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class CustomerCategoriesTable extends Table
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

        $this->setTable('customer_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree',[
            'level' => 'level'
        ]);

        $this->belongsTo('ParentCustomerCategories', [
            'className' => 'CustomerCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildCustomerCategories', [
            'className' => 'CustomerCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('CustomerCategoryOptions', [
            'foreignKey' => 'customer_category_id'
        ]);
        $this->hasMany('Customers', [
            'foreignKey' => 'customer_category_id'
        ]);
        $this->hasMany('SmsDetails', [
            'foreignKey' => 'customer_category_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

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
