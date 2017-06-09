<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ArticleData Entity
 *
 * @property int $id
 * @property bool $account_id
 * @property \Cake\I18n\FrozenTime $date
 * @property string $title
 * @property bool $level
 * @property int $hits
 * @property int $sharing_times
 * @property int $user_id
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\User $user
 */
class ArticleData extends Entity
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
