<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\PhoneFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Phone
 *
 * @property int $id
 * @property int $user_id
 * @property string $number
 * @property int $type
 * @property bool $is_primary
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read string $formatted_number
 * @property-read string $type_name
 * @property-read User $user
 * @method static PhoneFactory factory($count = null, $state = [])
 * @method static Builder|Phone newModelQuery()
 * @method static Builder|Phone newQuery()
 * @method static Builder|Phone query()
 * @method static Builder|Phone whereCreatedAt($value)
 * @method static Builder|Phone whereId($value)
 * @method static Builder|Phone whereIsPrimary($value)
 * @method static Builder|Phone whereNumber($value)
 * @method static Builder|Phone whereType($value)
 * @method static Builder|Phone whereUpdatedAt($value)
 * @method static Builder|Phone whereUserId($value)
 * @method static Builder|Phone primary()
 * @method static Builder|Phone ofType(int $type)
 */
class Phone extends Model {
    use HasFactory;

    public const int TYPE_MOBILE = 1;
    public const int TYPE_HOME = 2;
    public const int TYPE_WORK = 3;
    public const int TYPE_OTHER = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'number',
        'type',
        'is_primary',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'formatted_number',
        'type_name',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Format the phone number based on its type.
     *
     * @return Attribute
     */
    protected function formattedNumber(): Attribute {
        return Attribute::make(
            get: function () {
                $cleaned = preg_replace('/[^0-9]/', '', $this->number);

                if ($this->type === self::TYPE_MOBILE && strlen($cleaned) === 11) {
                    return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $cleaned);
                }

                if (strlen($cleaned) === 10) {
                    return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $cleaned);
                }

                return $this->number;
            }
        );
    }

    /**
     * Get the human-readable type name.
     *
     * @return Attribute
     */
    protected function typeName(): Attribute {
        return Attribute::make(
            get: fn () => match($this->type) {
                self::TYPE_MOBILE => 'Celular',
                self::TYPE_HOME => 'Residencial',
                self::TYPE_WORK => 'Trabalho',
                self::TYPE_OTHER => 'Outro',
                default => 'Desconhecido',
            }
        );
    }

    /**
     * Normalize the phone number before saving.
     *
     * @return Attribute
     */
    protected function number(): Attribute {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }

    /**
     * Scope a query to only include primary phones.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePrimary(Builder $query): Builder {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to filter phones by type.
     *
     * @param Builder $query
     * @param int $type
     * @return Builder
     */
    public function scopeOfType(Builder $query, int $type): Builder {
        return $query->where('type', $type);
    }

    /**
     * Mark this phone as primary.
     * Unmarks any other primary phones the user may have.
     *
     * @return bool
     */
    public function markAsPrimary(): bool {
        $this->user->phones()->update(['is_primary' => false]);
        return $this->update(['is_primary' => true]);
    }

    /**
     * Create a new phone for the given user.
     *
     * @param User $user
     * @param string $number
     * @param int $type
     * @param bool $markAsPrimary
     * @return self
     */
    public static function createForUser(User $user, string $number, int $type = self::TYPE_MOBILE, bool $markAsPrimary = false): self {
        $phone = $user->phones()->create([
            'number' => $number,
            'type' => $type,
        ]);

        if ($markAsPrimary) $phone->markAsPrimary();

        return $phone;
    }
}
