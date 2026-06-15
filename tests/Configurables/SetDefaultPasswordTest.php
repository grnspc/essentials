<?php

declare(strict_types=1);

use Grnspc\Essentials\Configurables\SetDefaultPassword;
use Illuminate\Validation\Rules\Password;

beforeEach(function (): void {
    Password::defaults();
});

it('sets default password rules', function (): void {
    $setDefaultPassword = new SetDefaultPassword;
    $setDefaultPassword->configure();

    $passwordRules = Password::default()->appliedRules();

    // dd($passwordRules);

    expect($passwordRules['min'])->toBe(8);
})->skip(fn (): bool => method_exists(Password::class, 'appliedRules') === false,
    'The appliedRules method is not available in this version of Laravel.');

it('is enabled by default', function (): void {
    $setDefaultPassword = new SetDefaultPassword;

    expect($setDefaultPassword->enabled())->toBeTrue();
});

it('can be disabled via configuration', function (): void {
    config()->set('essentials.'.SetDefaultPassword::class, false);

    $setDefaultPassword = new SetDefaultPassword;

    expect($setDefaultPassword->enabled())->toBeFalse();
});

it('is disabled when testing', function (): void {
    app()->detectEnvironment(fn (): string => 'testing');

    $setDefaultPassword = new SetDefaultPassword;

    expect($setDefaultPassword->enabled())->toBeFalse();
});
