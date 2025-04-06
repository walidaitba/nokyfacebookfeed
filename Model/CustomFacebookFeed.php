<?php

/**
 * Copyright © Nokytech Themes 2022-present. All rights reserved.
 */

namespace Nokytech\FbNokyFeed\Model;

use Psr\Log\LoggerInterface;

/**
 * Class CustomFacebookFeed
 * @package Nokytech\FbNokyFeed\Model
 */
class CustomFacebookFeed
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var string
     */
    private string $accessToken;

    /**
     * @var string
     */
    private string $pageId;

    /**
     * CustomFacebookFeed constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Set credentials for Facebook API
     * @param string $accessToken
     * @param string $pageId
     */
    public function setCredentials(string $accessToken, string $pageId): void
    {
        $this->accessToken = $accessToken;
        $this->pageId = $pageId;
    }

    /**
     * Get Facebook feed data
     * @param array $settings
     * @return array
     */
    public function getFeed(array $settings): array
    {
        $url = "https://graph.facebook.com/v2.10/{$this->pageId}/posts?fields=message,full_picture,story,created_time,shares,likes.summary(true),comments.summary(true),attachments&limit={$settings['number']}&access_token={$this->accessToken}";
        $this->logger->info('Fetching URL: ' . $url);

        $response = @file_get_contents($url);
        if ($response === false) {
            $this->logger->error('Failed to fetch data from Facebook.');
            return [];
        }

        $feed = json_decode($response, true);
        if (isset($feed['error'])) {
            $this->logger->error('Facebook API error: ' . $feed['error']['message']);
            return [];
        }

        $pageInfoUrl = "https://graph.facebook.com/v2.10/{$this->pageId}?fields=name,picture&access_token={$this->accessToken}";
        $this->logger->info('Fetching Page Info URL: ' . $pageInfoUrl);

        $pageInfoResponse = @file_get_contents($pageInfoUrl);
        if ($pageInfoResponse === false) {
            $this->logger->error('Failed to fetch page info from Facebook.');
            return [];
        }

        $pageInfo = json_decode($pageInfoResponse, true);
        if (isset($pageInfo['error'])) {
            $this->logger->error('Facebook Page Info API error: ' . $pageInfo['error']['message']);
            return [];
        }

        $this->logger->info('Fetched feed data: ' . json_encode($feed));
        $this->logger->info('Fetched page info: ' . json_encode($pageInfo));

        return [
            'feed' => $feed['data'],
            'page_info' => $pageInfo
        ];
    }
}
