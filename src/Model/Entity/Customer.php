<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property int $customer_category_id
 * @property string $name
 * @property string $company
 * @property int $country_code
 * @property int $mobile
 * @property int $email
 * @property int $position
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CustomerCategory $customer_category
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\CustomerBusiness[] $customer_businesses
 * @property \App\Model\Entity\Finance[] $finances
 */
class Customer extends Entity
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
