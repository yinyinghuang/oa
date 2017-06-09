<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerCategoryValue Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $customer_category_option_id
 * @property string $value
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\CustomerCategoryOption $customer_category_option
 */
class CustomerCategoryValue extends Entity
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
