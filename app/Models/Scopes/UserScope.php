<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                // No scope for admin users
                return;
            }

            // For non-admin users
            $builder->where('user_id', Auth::user()->id);
                    
                    
        } else {
            // For unauthenticated users or as a fallback
            $builder->where('is_data_correct', false)
                    ->where('is_data_entered', false);
        }
    }
}
