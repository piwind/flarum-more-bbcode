<?php

/*
 * This file is part of flarum-more-bbcode.
 *
 * Copyright (c) 2022 Sami Mazouz.
 * Copyright (c) 2024 小鱼飘飘
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Piwind\MoreBBCode\Tags;

use s9e\TextFormatter\Configurator;

class LiteYouTubeTemplate
{
    public function __invoke(Configurator $config)
    {
        if (!isset($config->MediaEmbed)) {
            return;
        }
        if ($config->tags->exists("YOUTUBE")) {
            $tag = $config->tags['YOUTUBE'];
            $tag->template = '<lite-youtube videoid="{@id}"></lite-youtube>';
        }
    }
}