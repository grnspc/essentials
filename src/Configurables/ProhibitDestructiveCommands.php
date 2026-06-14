<?php

declare(strict_types=1);

namespace Grnspc\Essentials\Configurables;

use Grnspc\Essentials\Contracts\Configurable;
use Illuminate\Support\Facades\DB;

final readonly class ProhibitDestructiveCommands implements Configurable
{
    /**
     * Whether the configurable is enabled or not.
     */
    public function enabled(): bool
    {
        return config()->boolean(sprintf('essentials.%s', self::class), true);
    }

    /**
     * Run the configurable.
     */
    public function configure(): void
    {
        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );
    }
}
