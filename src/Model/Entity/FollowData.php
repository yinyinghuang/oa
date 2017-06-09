<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FollowData Entity
 *
 * @property int $id
 * @property int $account_id
 * @property \Cake\I18n\FrozenTime $date
 * @property int $followed
 * @property int $unfollowed
 * @property int $total
 *
 * @property \App\Model\Entity\Account $account
 */
class FollowData extends Entity
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
