<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Privileges Model
 *
 * @method \App\Model\Entity\Privilege get($primaryKey, $options = [])
 * @method \App\Model\Entity\Privilege newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Privilege[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Privilege|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Privilege patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Privilege[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Privilege findOrCreate($search, callable $callback = null, $options = [])
 */
class PrivilegesTable extends Table
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

        $this->setTable('privileges');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('who')
            ->requirePresence('who', 'create')
            ->notEmpty('who');

        $validator
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->requirePresence('what', 'create')
            ->notEmpty('what');

        $validator
            ->requirePresence('how', 'create')
            ->notEmpty('how');

        return $validator;
    }
}
