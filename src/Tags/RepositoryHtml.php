<?php

/*
 * This file is part of flarum-more-bbcode.
 *
 * Copyright (c) 2024 小鱼飘飘
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Piwind\MoreBBCode\Tags;

use Flarum\Locale\Translator;
use s9e\TextFormatter\Configurator;
use Piwind\MoreBBCode\Helper\FunctionHelper;

class RepositoryHtml
{
    protected FunctionHelper $functions;
    public function __construct(FunctionHelper $functions)
    {
        $this->functions = $functions;
    }
    public function __invoke(Configurator $config)
    {
        // Allowed HTML tags
        // Delete unsafe tags
        if ($this->functions->isEnable("iframe")) {
            $config->HTMLElements->allowUnsafeElement('iframe');
            $config->HTMLElements->allowUnsafeAttribute('iframe', 'src');
            $config->HTMLElements->allowUnsafeAttribute('iframe', 'scrolling');
            $config->HTMLElements->allowUnsafeAttribute('iframe', 'height');
            $config->HTMLElements->allowUnsafeAttribute('iframe', 'loading');
            $config->HTMLElements->allowUnsafeAttribute('iframe', 'name');
            $config->HTMLElements->allowUnsafeAttribute('iframe', 'width');
            $config->HTMLElements->allowUnsafeAttribute('iframe', 'align');
            $config->HTMLElements->allowUnsafeAttribute('iframe', 'frameborder');
        }
    }
}