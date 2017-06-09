<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property bool $gender
 * @property string $telephone
 * @property string $email
 * @property bool $state
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ArticleData[] $article_datas
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\Dropbox[] $dropboxes
 * @property \App\Model\Entity\FinanceReview[] $finance_reviews
 * @property \App\Model\Entity\Finance[] $finances
 * @property \App\Model\Entity\ProjectIssueSolution[] $project_issue_solutions
 * @property \App\Model\Entity\ProjectIssue[] $project_issues
 * @property \App\Model\Entity\ProjectSchedule[] $project_schedules
 * @property \App\Model\Entity\Project[] $projects
 * @property \App\Model\Entity\Task[] $tasks
 * @property \App\Model\Entity\UserDepartmentRole[] $user_department_roles
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
}
