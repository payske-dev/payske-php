<?php

// File generated from our OpenAPI spec

namespace Payske\Terminal;

/**
 * A Location represents a grouping of readers.
 *
 * Related guide: <a
 * href="https://docs.payske.com/docs/terminal/creating-locations">Fleet Management</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property \Payske\PayskeObject $address
 * @property string $display_name The display name of the location.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \Payske\PayskeObject $metadata Set of <a href="https://docs.payske.com/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 */
class Location extends \Payske\ApiResource
{
    const OBJECT_NAME = 'terminal.location';

    use \Payske\ApiOperations\All;
    use \Payske\ApiOperations\Create;
    use \Payske\ApiOperations\Delete;
    use \Payske\ApiOperations\Retrieve;
    use \Payske\ApiOperations\Update;
}
