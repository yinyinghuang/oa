<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $controller
 * @property int $itemid
 * @property int $state
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\FinanceApply $finance_apply
 * @property \App\Model\Entity\ProjectIssueSolution[] $project_issue_solutions
 * @property \App\Model\Entity\ProjectIssue[] $project_issues
 * @property \App\Model\Entity\ProjectProgress[] $project_progresses
 * @property \App\Model\Entity\ProjectSchedule[] $project_schedules
 * @property \App\Model\Entity\Project[] $projects
 */
class Task extends Entity
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
}
