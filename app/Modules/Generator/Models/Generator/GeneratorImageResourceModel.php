<?php

namespace App\Modules\Generator\Models\Generator;

use App\Modules\Generator\Models\Generator\GeneratorImageModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Модель для таблицы "generator_image_resource".
 *
 * @property int $id
 * @property string $original_link
 * @property int $iteration_amount
 * @property bool $in_process
 * @property Carbon $date
 * @property Collection|GeneratorImageModel[] images
 * @method static self ofInProcess($process)
 */
class GeneratorImageResourceModel extends Model
{
    protected $table = 'generator_image_resource';
    public $timestamps = false;
    protected $fillable = ['original_link', 'iteration_amount', 'in_process', 'date'];

    protected $dates = ['date'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->date = now();
    }


    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GeneratorImageModel::class, 'generator_image_resource_id');
    }


    public function scopeOfInProcess(Builder $query, bool $processed): Builder
    {
        return $query->where('in_process', $processed);
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'original_link' => $this->original_link,
            'date' => $this->date
        ];
    }

}
