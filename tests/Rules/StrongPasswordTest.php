<?php

declare(strict_types=1);

use Grnspc\Essentials\Rules\StrongPassword;

it('works with valid password', function (string $password): void {
    $rule = new StrongPassword;

    $failed = false;

    $rule->validate('password', $password, function () use (&$failed): void {
        $failed = true;
    });

    expect($failed)->toBeFalse();
})->with([
    'Pa$$w0rd!123',
    'P@ssw0rd',
    'iamthebestpassword',
]);

it('fails with invalid password', function (string $password): void {
    $rule = new StrongPassword;

    $failed = false;

    $rule->validate('password', $password, function () use (&$failed): void {
        $failed = true;
    });

    expect($failed)->toBeTrue();
})->with([
    'Password',
    'passw0rd',
    'p@ssw0rd',
    'iamthebestpass',
    '',
]);
