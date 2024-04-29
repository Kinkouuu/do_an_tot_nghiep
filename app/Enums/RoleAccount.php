<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoleAccount extends Enum
{
    const Admin = 'admin';
    const Manager = 'manager';
    const Employee = 'employee';
    const Customer = 'customer';
}
