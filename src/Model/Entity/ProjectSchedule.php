<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectSchedule Entity
 *
 * @property int $id
 * @property int $task_id
 * @property int $project_id
 * @property string $title
 * @property string $brief
 * @property int $user_id
 * @property int $state
 * @property \Cake\I18n\FrozenTime $start_time
 * @property \Cake\I18n\FrozenTime $end_time
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Task $task
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ProjectIssue[] $project_issues
 * @property \App\Model\Entity\ProjectProgress[] $project_progresses
 */
class ProjectSchedule extends Entity
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
