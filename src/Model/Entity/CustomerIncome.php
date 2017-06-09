<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerIncome Entity
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $detail
 * @property string $type
 * @property string $receipt
 * @property int $customer_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Customer $customer
 */
class CustomerIncome extends Entity
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
