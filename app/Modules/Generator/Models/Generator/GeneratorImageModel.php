<?php

namespace App\Modules\Generator\Models\Generator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Модель для таблицы "generate_image".
 *
 * @property int $id
 * @property string $original_link
 * @property int $generator_image_resource_id
 * @property int $iteration
 * @property Carbon $date
 */
class GeneratorImageModel extends Model
{
    protected $table = 'generator_image';
    protected $fillable = ['original_link', 'generator_image_resource_id', 'iteration'];
    public $timestamps = false;
    protected $dates = ['date'];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->date = now(); // Установка текущей даты при создании записи
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'original_link' => $this->original_link,
            'date' => $this->date,
        ];
    }
}
