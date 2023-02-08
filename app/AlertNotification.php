<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertNotification extends Model
{
    public static $types = [
        [
          'id' => 1,
          'type' => 'Project',
          'background' => 'bg-primary',
          'icon' => 'fas fa-fw fa-cubes text-white fa-xs'
        ],
        [
          'id' => 2,
          'type' => 'Task',
          'background' => 'bg-primary',
          'icon' => 'fas fa-fw fa-list-ul fa text-white fa-xs'
        ],
        [
          'id' => 3,
          'type' => 'Billing',
          'background' => 'bg-success',
          'icon' => 'fas fa-donate text-white fa-xs'
        ],
        [
          'id' => 4,
          'type' => 'Custom',
          'background' => 'bg-info',
          'icon' => 'fas fa-info text-white fa-xs'
        ]
    ];

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'summary',
        'url'
    ];

    public static function getTypes()
    {
        return AlertNotification::$types;
    }

    public function getTypeById($id, $property = 'all')
    {
        $item = null;
        foreach (AlertNotification::$types as $type) {
            if ($type['id'] == $id) {
                if (array_key_exists($property, $type)) {
                    return $type[$property];
                    break;
                } else {
                    return $type;
                }

            }
        }
        return $item;
    }
}
