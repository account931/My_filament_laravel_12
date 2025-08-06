<?php

// ->options([
// ConfirmedEnum::Confirmed->value    => ConfirmedEnum::Confirmed->label() ,      //'1'  => 'Confirmed',
// ConfirmedEnum::NotConfirmed->value => ConfirmedEnum::NotConfirmed->label(),   //'0'   => 'Not Confirmed',

namespace App\Enums;

//
enum OrderStatusEnum: string // int
{
    case Confirmed = 'confirmed';
    case Pending = 'pending';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Confirmed => 'Orders confirmed',
            self::Pending => 'Orders pending',
            self::Cancelled => 'Orders cancelled',
        };
    }
}
