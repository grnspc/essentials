<?php

declare(strict_types=1);

namespace Grnspc\Essentials\Configurables;

use Grnspc\Essentials\Contracts\Configurable;
use Grnspc\Essentials\Rules\StrongPassword;
use Illuminate\Validation\Rules\Password;

final class SetDefaultPassword implements Configurable
{
    /**
     * {@inheritDoc}
     */
    public function enabled(): bool
    {
        return app()->runningUnitTests() === false
            && config()->boolean(sprintf('essentials.%s', self::class), true);
    }

    /**
     * {@inheritDoc}
     */
    public function configure(): void
    {
        Password::defaults(
            callback: fn (): ?Password => app()->isProduction()
                ? new Password(8)->rules([StrongPassword::class])
                : null
        );
    }
}
