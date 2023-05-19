<?php

namespace App\Modules\Generator\Models\Generator;

use App\Modules\Generator\Models\Generator\GeneratorImageModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Модель для таблицы "generator_image_resource".
 *
 * @property int $id
 * @property string $original_link
 * @property int $iteration_amount
 * @property Carbon $date
 * @property Collection|GeneratorImageModel[] images
 */
class GeneratorImageResourceModel extends Model
{
    protected $table = 'generator_image_resource';
    protected $fillable = ['original_link', 'iteration_amount'];

    protected $dates = ['date'];

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GeneratorImageModel::class, 'generate_image_resource_id');
    }

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
