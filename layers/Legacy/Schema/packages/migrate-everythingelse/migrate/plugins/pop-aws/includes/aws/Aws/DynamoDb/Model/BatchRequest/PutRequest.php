<?php
/**
 * Copyright 2010-2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Aws\DynamoDb\Model\BatchRequest;

use Aws\Common\Exception\InvalidArgumentException;
use Aws\DynamoDb\Model\Item;
use Guzzle\Service\Command\AbstractCommand;

/**
 * Represents a batch put request. It is composed of a table name and item
 */
class PutRequest extends AbstractWriteRequest
{
    /**
     * @var array The item to be inserted into the DynamoDB table
     */
    protected $item;

    /**
     * Factory that creates a PutRequest from a PutItem command
     *
     * @param AbstractCommand $command The command to create the request from
     *
     * @return PutRequest
     *
     * @throws InvalidArgumentException if the command is not a PutItem command
     */
    public static function fromCommand(AbstractCommand $command)
    {
        if ($command->getName() !== 'PutItem') {
            throw new InvalidArgumentException();
        }

        // Get relevant data for a PutRequest
        $table = $command->get('TableName');
        $item  = $command->get('Item');

        // Return an instantiated PutRequest object
        return new PutRequest($item, $table);
    }

    /**
     * Constructs a new put request
     *
     * @param array|Item $item      The item to put into DynamoDB
     * @param string     $tableName The name of the table which has the item
     *
     * @throw InvalidArgumentException if the table name is not provided
     */
    public function __construct($item, $tableName = null)
    {
        if ($item instanceof Item) {
            $this->item = $item->toArray();
            $this->tableName = $tableName ?: $item->getTableName();
        } elseif (is_array($item)) {
            $this->item = $item;
            $this->tableName = $tableName;
        } else {
            throw new InvalidArgumentException('The item must be an array or an Item object.');
        }

        if (!$this->tableName) {
            throw new InvalidArgumentException('A table name is required to create a PutRequest.');
        }
    }

    /**
     * The parameter form of the request
     *
     * @return array
     */
    public function toArray()
    {
        return array('PutRequest' => array('Item' => $this->item));
    }

    /**
     * Get the item
     *
     * @return Item
     */
    public function getItem()
    {
        return new Item($this->item);
    }
}
