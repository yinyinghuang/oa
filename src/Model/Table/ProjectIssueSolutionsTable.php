<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectIssueSolutions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 * @property \Cake\ORM\Association\BelongsTo $ProjectIssues
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $ProjectIssues
 *
 * @method \App\Model\Entity\ProjectIssueSolution get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProjectIssueSolution newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProjectIssueSolution[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProjectIssueSolution|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProjectIssueSolution patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectIssueSolution[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProjectIssueSolution findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProjectIssueSolutionsTable extends Table
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

        $this->setTable('project_issue_solutions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProjectIssues', [
            'foreignKey' => 'project_issues_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ProjectIssues', [
            'foreignKey' => 'project_issue_solution_id'
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
            ->requirePresence('solution', 'create')
            ->notEmpty('solution');

        $validator
            ->requirePresence('attachment', 'create')
            ->notEmpty('attachment');

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
        //$rules->add($rules->existsIn(['task_id'], 'Tasks'));
        $rules->add($rules->existsIn(['project_issues_id'], 'ProjectIssues'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
