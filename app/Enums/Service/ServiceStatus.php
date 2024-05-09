<?php declare(strict_types=1);

namespace App\Enums\Service;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ServiceStatus extends Enum
{
    const DeActive = '0';
    const Active = '1';
}
