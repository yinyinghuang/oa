<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerCategoryOption Entity
 *
 * @property int $id
 * @property int $customer_category_id
 * @property string $name
 * @property string $type
 * @property string $value
 * @property bool $required
 *
 * @property \App\Model\Entity\CustomerCategory $customer_category
 * @property \App\Model\Entity\CustomerCategoryValue[] $customer_category_values
 */
class CustomerCategoryOption extends Entity
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
