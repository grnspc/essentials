<?php

declare(strict_types=1);

namespace Grnspc\Essentials\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

final class StrongPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)) {
            $fail('The :attribute must be at least 15 characters OR at least 8 characters including a number, a symbol, a uppercase letter and a lowercase letter.');
        }

        assert(is_string($value));

        $passwordRules = match (true) {
            mb_strlen($value) >= 15 => Password::min(15),
            default => Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
        };

        $validator = Validator::make(
            [$attribute => $value],
            [$attribute => $passwordRules->max(64)->uncompromised()]
        );

        if ($validator->fails()) {
            $fail('The :attribute must be at least 15 characters OR at least 8 characters including a number, a symbol, a uppercase letter and a lowercase letter.');
        }
    }
}
