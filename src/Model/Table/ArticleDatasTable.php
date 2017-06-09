<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ArticleDatas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Accounts
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ArticleData get($primaryKey, $options = [])
 * @method \App\Model\Entity\ArticleData newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ArticleData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ArticleData|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ArticleData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ArticleData[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ArticleData findOrCreate($search, callable $callback = null, $options = [])
 */
class ArticleDatasTable extends Table
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

        $this->setTable('article_datas');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->boolean('level')
            ->requirePresence('level', 'create')
            ->notEmpty('level');

        $validator
            ->integer('hits')
            ->requirePresence('hits', 'create')
            ->notEmpty('hits');

        $validator
            ->integer('sharing_times')
            ->requirePresence('sharing_times', 'create')
            ->notEmpty('sharing_times');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
