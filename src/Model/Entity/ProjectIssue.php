<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectIssue Entity
 *
 * @property int $id
 * @property int $task_id
 * @property int $project_schedule_id
 * @property string $issue
 * @property int $user_id
 * @property int $state
 * @property int $project_issue_solution_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Task $task
 * @property \App\Model\Entity\ProjectSchedule $project_schedule
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ProjectIssueSolution $project_issue_solution
 */
class ProjectIssue extends Entity
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
