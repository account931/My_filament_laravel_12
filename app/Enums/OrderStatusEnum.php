<?php

// ->options([
// ConfirmedEnum::Confirmed->value    => ConfirmedEnum::Confirmed->label() ,      //'1'  => 'Confirmed',
// ConfirmedEnum::NotConfirmed->value => ConfirmedEnum::NotConfirmed->label(),   //'0'   => 'Not Confirmed',

namespace App\Enums;

//
enum OrderStatusEnum: string // int
{
    case Approved = 'approved';
    case Pending = 'pending';

    public function label(): string
    {
        return match ($this) {
            self::Approved => 'Orders approved',
            self::Pending => 'Orders pending',
        };
    }
}
