<?php

declare(strict_types=1);

use Grnspc\Essentials\Configurables\AutomaticallySuffixActionClass;

beforeEach(function (): void {
    config()->set('essentials.action.suffix', false);
});

it('adds "Action" suffix for Action classes', function (): void {
    $actionSuffix = new AutomaticallySuffixActionClass;
    $actionSuffix->configure();

    expect(config('essentials.action.suffix'))->toBeTrue();
});

it('is enabled by default', function (): void {
    $actionSuffix = new AutomaticallySuffixActionClass;

    expect($actionSuffix->enabled())->toBeTrue();
});

it('can be disabled via configuration', function (): void {
    config()->set('essentials.'.AutomaticallySuffixActionClass::class, false);

    $actionSuffix = new AutomaticallySuffixActionClass;

    expect($actionSuffix->enabled())->toBeFalse();
});
