<?php

declare(strict_types=1);

namespace Grnspc\Essentials\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

final class StrongPassword implements ValidationRule
{
    /** @var array<string> */
    private array $errors = [];

    /**
     * @param  string  $value
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = Str::of($value);

        match (true) {
            $value->length() < 15 => $this->testShortPassword($value),
            default => null,
        };

        // If there are any validation errors, construct and return the failure message
        if ($this->errors !== []) {
            $errorMessage = Str::of('The :attribute must '.implode(', ', $this->errors))->replace(',', 'and');

            $fail($errorMessage->value());
        }
    }

    private function testShortPassword(Stringable $value): void
    {
        if ($value->length() < 8) {
            $this->errors[] = 'be at least 8 OR 15 characters';
        }

        // Check for at least one uppercase letter
        if (! $value->test('/[A-Z]/')) {
            $this->errors[] = 'contain at least one uppercase letter';
        }

        // Check for at least one alphabet character (can be uppercase or lowercase)
        if (! $value->test('/[a-zA-Z]/')) {
            $this->errors[] = 'contain at least one alphabet character';
        }

        // Check for at least one symbol (special character)
        if (! $value->test('/[^a-zA-Z\d]/')) {
            $this->errors[] = 'contain at least one special character';
        }
    }
}
