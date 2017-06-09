<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SmsTemplate Entity
 *
 * @property int $id
 * @property string $templateid
 * @property string $name
 * @property string $content
 * @property string $variables
 * @property string $sign
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class SmsTemplate extends Entity
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
