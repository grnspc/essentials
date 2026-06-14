<?php

declare(strict_types=1);

use Grnspc\Essentials\Configurables\AutomaticallyEagerLoadRelationships;
use Illuminate\Database\Eloquent\Model;

beforeEach()
    ->skip(fn (): bool => ! method_exists(Model::class, 'automaticallyEagerLoadRelationships'),
        'Automatically eager loading relationships is not supported in this version of Laravel.');

it('enables automatic eager loading', function (): void {
    Model::automaticallyEagerLoadRelationships(false);

    $eagerLoad = new AutomaticallyEagerLoadRelationships;
    $eagerLoad->configure();

    expect(Model::isAutomaticallyEagerLoadingRelationships())->toBeTrue();
});

it('is disabled by default', function (): void {
    $eagerLoad = new AutomaticallyEagerLoadRelationships;

    expect($eagerLoad->enabled())->toBeFalse();
});

it('can be disabled via configuration', function (): void {
    config()->set('essentials.'.AutomaticallyEagerLoadRelationships::class, false);

    $eagerLoad = new AutomaticallyEagerLoadRelationships;

    expect($eagerLoad->enabled())->toBeFalse();
});

it('does nothing when automaticallyEagerLoadRelationships method does not exist', function (): void {
    final class TestModel {}

    $eagerLoad = new AutomaticallyEagerLoadRelationships(TestModel::class);
    $eagerLoad->configure();

    // Enabled by default
    expect($eagerLoad->enabled())->toBeFalse();
});
