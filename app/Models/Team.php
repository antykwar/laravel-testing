<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
    ];

    public function add(User | Collection $user): void
    {
        if ($user instanceof User) {
            $user = collect([$user]);
        }

        $this->guardAgainstTooManyMembers($user);
        $this->members()->saveMany($user);
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function count(): int
    {
        return $this->members()->count();
    }

    public function removeUser(User $user): void
    {
        $this->members()->find($user->id)?->delete();
    }

    public function exterminateUsers(): void
    {
        $this->members()->delete();
    }

    protected function guardAgainstTooManyMembers($collection): void
    {
        if ($this->count() >= $this->size) {
            throw new Exception();
        }

        if (($this->count() + $collection->count()) > $this->size) {
            throw new Exception();
        }
    }
}
