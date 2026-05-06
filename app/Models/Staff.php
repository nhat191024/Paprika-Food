<?php

namespace App\Models;

use Database\Factories\StaffFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Database\Factories\StaffFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Staff withoutTeam($teams)
 * @mixin \Eloquent
 */
class Staff extends User
{
    /** @use HasFactory<StaffFactory> */
    use HasFactory;

    protected $table = 'users';

    protected string $guard_name = 'web';

    protected static function newFactory(): StaffFactory
    {
        return StaffFactory::new();
    }
}
