<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FinanceTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $CustomerIncomes
 * @property \Cake\ORM\Association\HasMany $Finances
 *
 * @method \App\Model\Entity\FinanceType get($primaryKey, $options = [])
 * @method \App\Model\Entity\FinanceType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FinanceType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FinanceType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FinanceType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FinanceType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FinanceType findOrCreate($search, callable $callback = null, $options = [])
 */
class FinanceTypesTable extends Table
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

        $this->setTable('finance_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('CustomerIncomes', [
            'foreignKey' => 'finance_type_id'
        ]);
        $this->hasMany('Finances', [
            'foreignKey' => 'finance_type_id'
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
}
