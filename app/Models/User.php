<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
        'bio',
        'force_password_change'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'force_password_change' => 'boolean'

        ];
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }


    /**
     * Get the URL of the user's photo.
     *
     * @return string|null
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            // Vérifier si c'est une URL complète (pour les anciennes données)
            if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
                return $this->photo;
            }

            // Générer l'URL correcte comme pour les plats
            return asset('storage/images/users/' . $this->photo);
        }

        // Retourner null pour utiliser l'icône SVG par défaut
        return null;
    }
}
