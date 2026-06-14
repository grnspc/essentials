<?php

declare(strict_types=1);

namespace Grnspc\Essentials\Configurables;

use Grnspc\Essentials\Contracts\Configurable;
use Illuminate\Database\Eloquent\Model;

final readonly class AutomaticallyEagerLoadRelationships implements Configurable
{
    public function __construct(
        private string $modelClass = Model::class
    ) {}

    /**
     * Whether the configurable is enabled or not.
     */
    public function enabled(): bool
    {
        return config()->boolean(sprintf('essentials.%s', self::class), false);
    }

    /**
     * Run the configurable.
     */
    public function configure(): void
    {
        if (! method_exists($this->modelClass, 'automaticallyEagerLoadRelationships')) {
            return;
        }

        Model::automaticallyEagerLoadRelationships();
    }
}
