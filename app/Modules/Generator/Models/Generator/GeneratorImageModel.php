<?php

namespace App\Modules\Generator\Models\Generator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Модель для таблицы "generate_image".
 *
 * @property int $id
 * @property string $original_link
 * @property int $generate_image_resource_id
 * @property int $iteration
 * @property Carbon $date
 */
class GeneratorImageModel extends Model
{
    protected $table = 'generate_image';
    protected $fillable = ['original_link', 'generate_image_resource_id', 'iteration'];

    protected $dates = ['date'];

    /**
     * Метод, вызываемый при создании новой записи.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->date = now(); // Установка текущей даты при создании записи
    }
}
