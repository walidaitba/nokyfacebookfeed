<?php

/**
 * Copyright © Nokytech Themes 2022-present. All rights reserved.
 */

namespace Nokytech\FbNokyFeed\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class LayoutOptions
 * @package Nokytech\FbNokyFeed\Model\Config\Source
 */
class LayoutOptions implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'standard', 'label' => __('Standard')],
            ['value' => 'extreme', 'label' => __('Extreme')],
            ['value' => 'gallery', 'label' => __('Gallery')]
        ];
    }
}
