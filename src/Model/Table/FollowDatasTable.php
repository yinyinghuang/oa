<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FollowDatas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\FollowData get($primaryKey, $options = [])
 * @method \App\Model\Entity\FollowData newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FollowData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FollowData|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FollowData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FollowData[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FollowData findOrCreate($search, callable $callback = null, $options = [])
 */
class FollowDatasTable extends Table
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

        $this->setTable('follow_datas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id'
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
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->integer('followed')
            ->requirePresence('followed', 'create')
            ->notEmpty('followed');

        $validator
            ->integer('unfollowed')
            ->requirePresence('unfollowed', 'create')
            ->notEmpty('unfollowed');

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
        $rules->add($rules->existsIn(['account_id'], 'Accounts'));

        return $rules;
    }
}
