<?php

/**
 * Copyright © Nokytech Themes 2022-present. All rights reserved.
 */

namespace Nokytech\FbNokyFeed\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Nokytech\FbNokyFeed\Model\CustomFacebookFeed;
use Psr\Log\LoggerInterface;

/**
 * Class Feed
 * @package Nokytech\FbNokyFeed\Block
 */
class Feed extends Template
{
    /**
     * @param Template\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param CustomFacebookFeed $customFacebookFeed
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        private ScopeConfigInterface $scopeConfig,
        private CustomFacebookFeed $customFacebookFeed,
        private LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get Facebook Access Token from configuration
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        $token = $this->scopeConfig->getValue('fbnokyfeed/general/access_token', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $this->logger->info('Access Token: ' . $token);
        return $token;
    }

    /**
     * Get Facebook Page ID from configuration
     * @return string|null
     */
    public function getPageId(): ?string
    {
        $pageId = $this->scopeConfig->getValue('fbnokyfeed/general/page_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $this->logger->info('Page ID: ' . $pageId);
        return $pageId;
    }

    /**
     * Get the number of posts to display from configuration
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->scopeConfig->getValue('fbnokyfeed/general/number', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get layout style from configuration
     * @return string|null
     */
    public function getLayout(): ?string
    {
        return $this->scopeConfig->getValue('fbnokyfeed/general/layout', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get number of columns for desktop from configuration
     * @return string|null
     */
    public function getColumns(): ?string
    {
        return $this->scopeConfig->getValue('fbnokyfeed/general/columns', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get number of columns for tablet from configuration
     * @return string|null
     */
    public function getColumnsTablet(): ?string
    {
        return $this->scopeConfig->getValue('fbnokyfeed/general/columns_tablet', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get number of columns for mobile from configuration
     * @return string|null
     */
    public function getColumnsMobile(): ?string
    {
        return $this->scopeConfig->getValue('fbnokyfeed/general/columns_mobile', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get feed height from configuration
     * @return string|null
     */
    public function getHeight(): ?string
    {
        return $this->scopeConfig->getValue('fbnokyfeed/general/height', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get background color from configuration
     * @return string|null
     */
    public function getBgColor(): ?string
    {
        return $this->scopeConfig->getValue('fbnokyfeed/general/bgcolor', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get accent color from configuration
     * @return string|null
     */
    public function getAccentColor(): ?string
    {
        return $this->scopeConfig->getValue('fbnokyfeed/general/accent_color', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Fetch Facebook feed data
     * @return array
     */
    public function getFacebookFeed(): array
    {
        $accessToken = $this->getAccessToken();
        $pageId = $this->getPageId();
        $settings = [
            'number' => $this->getNumber(),
            'layout' => $this->getLayout(),
            'columns' => $this->getColumns(),
            'columns_tablet' => $this->getColumnsTablet(),
            'columns_mobile' => $this->getColumnsMobile(),
            'height' => $this->getHeight(),
            'bgcolor' => $this->getBgColor()
        ];

        $this->logger->info('Fetching Facebook feed with settings: ' . json_encode($settings));

        if (empty($accessToken) || empty($pageId)) {
            $this->logger->error('Facebook access token or page ID is not set.');
            return [];
        }

        $this->customFacebookFeed->setCredentials($accessToken, $pageId);

        $feedData = $this->customFacebookFeed->getFeed($settings);

        $this->logger->info('Fetched feed: ' . json_encode($feedData));

        return $feedData;
    }
}
