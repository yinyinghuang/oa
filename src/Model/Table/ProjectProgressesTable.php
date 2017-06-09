<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectProgresses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ProjectSchedules
 *
 * @method \App\Model\Entity\ProjectProgress get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectProgress newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectProgress[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectProgress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectProgress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectProgress[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectProgress findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProjectProgressesTable extends Table
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

        $this->setTable('project_progresses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProjectSchedules', [
            'foreignKey' => 'project_schedule_id',
            'joinType' => 'INNER'
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
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->integer('progress')
            ->requirePresence('progress', 'create')
            ->notEmpty('progress');

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
        $rules->add($rules->existsIn(['project_schedule_id'], 'ProjectSchedules'));

        return $rules;
    }
}
