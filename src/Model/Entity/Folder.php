<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Folder Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $spell
 * @property string $name
 * @property int $ord
 * @property int $level
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 * @property bool $deleted
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Folder $parent_folder
 * @property \App\Model\Entity\File[] $files
 * @property \App\Model\Entity\Folder[] $child_folders
 */
class Folder extends Entity
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
