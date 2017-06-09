<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $ArticleDatas
 * @property \Cake\ORM\Association\HasMany $Customers
 * @property \Cake\ORM\Association\HasMany $Dropboxes
 * @property \Cake\ORM\Association\HasMany $FinanceBalances
 * @property \Cake\ORM\Association\HasMany $Finances
 * @property \Cake\ORM\Association\HasMany $ProjectIssueSolutions
 * @property \Cake\ORM\Association\HasMany $ProjectIssues
 * @property \Cake\ORM\Association\HasMany $ProjectSchedules
 * @property \Cake\ORM\Association\HasMany $Projects
 * @property \Cake\ORM\Association\HasMany $Tasks
 * @property \Cake\ORM\Association\HasMany $UserDepartmentRoles
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('ArticleDatas', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Customers', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Dropboxes', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('FinanceBalances', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Finances', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ProjectIssueSolutions', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ProjectIssues', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ProjectSchedules', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Projects', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'user_id'
        ])->setDependent(true);
        $this->hasMany('UserDepartmentRoles', [
            'foreignKey' => 'user_id'
        ])->setDependent(true);

        $this->hasMany('ProjectViewers', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->boolean('gender')
            ->allowEmpty('gender');

        $validator
            ->requirePresence('telephone', 'create')
            ->notEmpty('telephone');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->boolean('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
