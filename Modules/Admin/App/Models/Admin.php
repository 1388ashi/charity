<?php

namespace Modules\Admin\App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function isDeletable(): bool
    {
        return !$this->hasRole('super_admin');
    }
    public function givePermissions(array $permissions, $onUpdate = false)
    {
        if (!$this->hasRole('admin')) {
            $this->assignRole('admin');
        }
        $onUpdate === true ? $this->syncPermissions($permissions) : $this->givePermissionTo($permissions);
    }
    public function getJalaliCreatedAt(): string
    {
        return verta($this->attributes['created_at'])->format('Y/m/d H:i');
    }
    public function getJalaliLastLogin(): string
    {
        return $this->attributes['last_login'] ?
            verta($this->attributes['last_login'])->format('Y/m/d H:i') :
            'تاکنون ورود نکرده است';
    }
}
