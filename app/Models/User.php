<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use App\Services\Storage\MinioService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotificationCollection;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property Carbon|null $date_of_birth
 * @property string $cpf
 * @property string $photo
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection<int, Address> $addresses
 * @property-read Collection<int, Phone> $phones
 * @property-read int|null $addresses_count
 * @property-read int|null $phones_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Address|null $primaryAddress
 * @property-read Phone|null $primaryPhone
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCpf($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDateOfBirth($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUuid($value)
 */
class User extends Authenticatable implements MustVerifyEmail {
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'date_of_birth',
        'cpf',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'cpf',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'formatted_cpf',
        'formatted_date_of_birth',
        'age',
        'url_photo'
    ];

    /* ================= RELACIONAMENTOS ================= */

    /**
     * Get all addresses for the user.
     *
     * @return HasMany<Address>
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get all phone numbers for the user.
     *
     * @return HasMany<Phone>
     */
    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * Get the primary address for the user.
     *
     * @return HasOne<Address>
     */
    public function primaryAddress(): HasOne
    {
        return $this->hasOne(Address::class)->where('is_primary', true);
    }

    /**
     * Get the user's primary phone number.
     *
     * @return HasOne<Phone>
     */
    public function primaryPhone(): HasOne
    {
        return $this->hasOne(Phone::class)->where('is_primary', true);
    }

    /* ================= MÉTODOS DE BUSCA ================= */

    /**
     * Find a user by UUID.
     */
    public static function findByUuid(string $uuid): ?User {
        return static::where('uuid', $uuid)->first();
    }

    /**
     * Find a user by CPF.
     */
    public static function findByCpf(string $cpf): ?User {
        return static::where('cpf', $cpf)->first();
    }

    /* ================= MÉTODOS DE VERIFICAÇÃO ================= */

    /**
     * Check if the user has any addresses.
     */
    public function hasAddresses(): bool {
        return $this->addresses()->exists();
    }

    /**
     * Check if the user has any phone numbers.
     */
    public function hasPhones(): bool {
        return $this->phones()->exists();
    }

    /**
     * Check if the user is over a certain age.
     */
    public function isOverAge(int $age): bool {
        return $this->date_of_birth?->age >= $age;
    }

    /* ================= SCOPES ================= */

    /**
     * Scope a query to only include adult users (18+ years).
     */
    public function scopeAdults(Builder $query): Builder {
        return $query->where('date_of_birth', '<=', now()->subYears(18));
    }

    /**
     * Scope a query to only include users born after a specific date.
     */
    public function scopeBornAfter(Builder $query, Carbon $date): Builder {
        return $query->where('date_of_birth', '>=', $date);
    }

    /* ================= MÉTODOS DE ATALHO ================= */

    /**
     * Get the primary or first phone number.
     */
    public function getPrimaryOrFirstPhone(): ?Phone {
        return $this->primaryPhone ?: $this->phones()->first();
    }

    /**
     * Get the primary or first address.
     */
    public function getPrimaryOrFirstAddress(): ?Address {
        return $this->primaryAddress ?: $this->addresses()->first();
    }

    /* ================= ACCESSORS/MUTATORS ================= */

    /**
     * Get the user's age based on date of birth.
     */
    protected function age(): Attribute {
        return Attribute::make(
            get: fn () => $this->date_of_birth?->age,
        );
    }

    /**
     * Get the CPF formatted with punctuation.
     */
    protected function formattedCpf(): Attribute {
        return Attribute::make(
            get: fn () => $this->cpf ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf) : null,
        );
    }

    protected function formattedDateOfBirth(): Attribute {
        return Attribute::make(
            get: fn () => $this->date_of_birth ? \Carbon\Carbon::parse($this->date_of_birth)->format('d/m/Y') : null,
        );
    }

    protected function urlPhoto(): Attribute {
        return Attribute::make(
            get: fn () => $this->photo ? app(MinioService::class)->getUrl('avatars/'.$this->photo) : null,
        );
    }

    /**
     * Set the user's CPF (removing any non-digit characters).
     */
    protected function cpf(): Attribute {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value),
        );
    }

    /**
     * Set the user's password (automatically hashed).
     */
    protected function password(): Attribute {
        return Attribute::make(
            set: fn (string $value) => Hash::needsRehash($value) ? Hash::make($value) : $value,
        );
    }
}
