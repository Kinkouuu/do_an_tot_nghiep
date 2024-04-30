<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FilterType extends Enum
{
    const SortBy = 0;
    const Status = 1;
    const Search = 2;
    const SearchUnion = 3;
}
