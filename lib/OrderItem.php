<?php

namespace Payske;

/**
 * Class OrderItem.
 *
 * @property string $object
 * @property int $amount
 * @property string $currency
 * @property string $description
 * @property string $parent
 * @property int $quantity
 * @property string $type
 */
class OrderItem extends PayskeObject
{
    const OBJECT_NAME = 'order_item';
}
