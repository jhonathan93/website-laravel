<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property string $street
 * @property string $number
 * @property string|null $complement
 * @property string $district
 * @property string $city
 * @property string $state
 * @property string $zip_code
 * @property string $country
 * @property bool $is_primary
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read string $formatted_zip_code
 * @property-read string $full_address
 * @property-read User $user
 * @method static AddressFactory factory($count = null, $state = [])
 * @method static Builder|Address newModelQuery()
 * @method static Builder|Address newQuery()
 * @method static Builder|Address query()
 * @method static Builder|Address whereCity($value)
 * @method static Builder|Address whereComplement($value)
 * @method static Builder|Address whereCountry($value)
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereDistrict($value)
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereIsPrimary($value)
 * @method static Builder|Address whereNumber($value)
 * @method static Builder|Address whereState($value)
 * @method static Builder|Address whereStreet($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereUserId($value)
 * @method static Builder|Address whereZipCode($value)
 * @method static Builder|Address primary()
 * @method static Builder|Address forCountry(string $country)
 */
class Address extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'zip_code',
        'country',
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
        'formatted_zip_code',
        'full_address',
    ];

    /**
     * Define the relationship with the User model.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Format the zip code with hyphen (XXXXX-XXX).
     *
     * @return Attribute
     */
    protected function formattedZipCode(): Attribute {
        return Attribute::make(
            get: fn () => substr($this->zip_code, 0, 5) . '-' . substr($this->zip_code, 5),
        );
    }

    /**
     * Get the full formatted address string.
     *
     * @return Attribute
     */
    protected function fullAddress(): Attribute {
        return Attribute::make(
            get: fn () => implode(', ', array_filter([
                "{$this->street}, {$this->number}",
                $this->complement,
                $this->district,
                $this->city,
                $this->state,
                $this->formatted_zip_code,
                $this->country !== 'Brasil' ? $this->country : null
            ]))
        );
    }

    /**
     * Normalize the zip code by removing non-digit characters before saving.
     *
     * @return Attribute
     */
    protected function zipCode(): Attribute {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }

    /**
     * Scope a query to only include primary addresses.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopePrimary(Builder $query): Builder {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to filter addresses by country.
     *
     * @param  Builder  $query
     * @param  string  $country
     * @return Builder
     */
    public function scopeForCountry(Builder $query, string $country): Builder {
        return $query->where('country', $country);
    }

    /**
     * Mark this address as the primary address for the user.
     * Unmarks any other primary addresses the user may have.
     *
     * @return bool
     */
    public function markAsPrimary(): bool {
        $this->user->addresses()->update(['is_primary' => false]);

        return $this->update(['is_primary' => true]);
    }

    /**
     * Check if the address is from Brazil.
     *
     * @return bool
     */
    public function isBrazilian(): bool {
        return strtolower($this->country) === 'brasil';
    }

    /**
     * Create a new address for the given user.
     *
     * @param User $user
     * @param  array  $attributes
     * @param  bool  $markAsPrimary
     * @return self
     */
    public static function createForUser(User $user, array $attributes, bool $markAsPrimary = false): self {
        $address = $user->addresses()->create($attributes);

        if ($markAsPrimary) $address->markAsPrimary();

        return $address;
    }
}
