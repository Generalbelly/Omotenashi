<?php

namespace App\Domains\Models;


interface OAuthAccessToken
{
    /**
     * @inheritdoc
     */
    public function getToken();

    /**
     * @inheritdoc
     */
    public function getRefreshToken();

    /**
     * @inheritdoc
     */
    public function getExpires();

    /**
     * @inheritdoc
     */
    public function getResourceOwnerId();

    /**
     * @inheritdoc
     */
    public function hasExpired();

    /**
     * @inheritdoc
     */
    public function getValues();

    /**
     * @inheritdoc
     */
    public function jsonSerialize();
}