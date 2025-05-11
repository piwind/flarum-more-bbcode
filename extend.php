<?php

/*
 * This file is part of flarum-more-bbcode.
 *
 * Copyright (c) 2023 imeepo.
 * Copyright (c) 2024 小鱼飘飘
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Piwind\MoreBBCode;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Piwind\MoreBBCode\Tags\Cloud;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/resources/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/resources/less/admin.less'),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    (new Extend\Formatter)
        ->configure(Configure::class)
        ->render(Rendering::class),
    (new Extend\Settings)
        ->default("piwind-more-bbcode.cloud", Cloud::$DEFAULT_VALUE)
        ->default("piwind-more-bbcode.disable", '{"gdoc":true,"iframe":true}')
        ->default("piwind-more-bbcode.collect-all", "none")
        ->default("piwind-more-bbcode.remove-markdown", "none")
        ->default("piwind-more-bbcode.collect-markdown", "first")
        ->default("piwind-more-bbcode.pref-markdown", "all")
        ->serializeToForum("piwind-more-bbcode-remove-markdown", "piwind-more-bbcode.remove-markdown")
        ->serializeToForum("piwind-more-bbcode-collect-all", "piwind-more-bbcode.collect-all")
        ->serializeToForum("piwind-more-bbcode-collect-markdown", "piwind-more-bbcode.collect-markdown")
        ->serializeToForum("piwind-more-bbcode-pref-markdown", "piwind-more-bbcode.pref-markdown"),
    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(ForumAttributes::class),
    (new Extend\User)
        ->registerPreference("piwind-more-bbcode-auto-close")
        ->registerPreference("piwind-more-bbcode-pref-markdown")
        ->registerPreference("piwind-more-bbcode-collect-all")
        ->registerPreference("piwind-more-bbcode-remove-markdown")
        ->registerPreference("piwind-more-bbcode-collect-markdown")
];
