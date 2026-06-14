<?php

declare(strict_types=1);

namespace Grnspc\Essentials\Configurables;

use Grnspc\Essentials\Contracts\Configurable;
use Illuminate\Database\Eloquent\Model;

final readonly class Unguard implements Configurable
{
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
        Model::unguard();
    }
}
