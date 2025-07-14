<?php

use App\Enums\ConfirmedEnum;

it('has correct enum values', function () {
    expect(ConfirmedEnum::Confirmed->value)->toBe(1);
    expect(ConfirmedEnum::NotConfirmed->value)->toBe(0);
});

it('returns correct label for Confirmed', function () {
    expect(ConfirmedEnum::Confirmed->label())->toBe('Confirmed2');
});

it('returns correct label for NotConfirmed', function () {
    expect(ConfirmedEnum::NotConfirmed->label())->toBe('Not Confirmed2');
});
