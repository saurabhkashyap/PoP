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

namespace Aws\Common\Credentials;

use Aws\Common\Exception\InstanceProfileCredentialsException;
use Aws\Common\InstanceMetadata\InstanceMetadataClient;

/**
 * Credentials decorator used to implement retrieving credentials from the
 * EC2 metadata server
 */
class RefreshableInstanceProfileCredentials extends AbstractRefreshableCredentials
{
    /**
     * @var InstanceMetadataClient
     */
    protected $client;
    /** @var bool */
    private $customClient;

    /**
     * Constructs a new instance profile credentials decorator
     *
     * @param CredentialsInterface   $credentials Credentials to adapt
     * @param InstanceMetadataClient $client      Client used to get new credentials
     */
    public function __construct(CredentialsInterface $credentials, InstanceMetadataClient $client = null)
    {
        $this->credentials = $credentials;
        $this->setClient($client);
    }

    public function setClient(InstanceMetadataClient $client = null)
    {
        $this->customClient = null !== $client;
        $this->client = $client ?: InstanceMetadataClient::factory();
    }

    public function serialize()
    {
        $serializable = array(
            'credentials' => parent::serialize(),
            'customClient' => $this->customClient,
        );

        if ($this->customClient) {
            $serializable['client'] = serialize($this->client);
        }

        return json_encode($serializable);
    }

    public function unserialize($value)
    {
        $serialized = json_decode($value, true);
        parent::unserialize($serialized['credentials']);
        $this->customClient = $serialized['customClient'];
        $this->client = $this->customClient ?
            unserialize($serialized['client'])
            : InstanceMetadataClient::factory();
    }

    /**
     * Attempt to get new credentials from the instance profile
     *
     * @throws InstanceProfileCredentialsException On error
     */
    protected function refresh()
    {
        $credentials = $this->client->getInstanceProfileCredentials();
        // Expire the token 30 minutes early to pre-fetch before expiring.
        $this->credentials->setAccessKeyId($credentials->getAccessKeyId())
            ->setSecretKey($credentials->getSecretKey())
            ->setSecurityToken($credentials->getSecurityToken())
            ->setExpiration($credentials->getExpiration() - 1800);
    }
}
