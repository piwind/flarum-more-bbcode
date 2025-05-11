<?php

/*
 * This file is part of imeepo/flarum-more-bbcode.
 *
 * Copyright (c) 2023 imeepo.
 * Copyright (c) 2024 小鱼飘飘
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Xypp\MoreBBCode;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Xypp\MoreBBCode\Tags\Cloud;

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
        ->default("xypp-more-bbcode.cloud", Cloud::$DEFAULT_VALUE)
        ->default("xypp-more-bbcode.disable", '{"gdoc":true,"iframe":true}')
        ->default("xypp-more-bbcode.collect-all", "none")
        ->default("xypp-more-bbcode.remove-markdown", "none")
        ->default("xypp-more-bbcode.collect-markdown", "first")
        ->default("xypp-more-bbcode.pref-markdown", "all")
        ->serializeToForum("xypp-more-bbcode-remove-markdown", "xypp-more-bbcode.remove-markdown")
        ->serializeToForum("xypp-more-bbcode-collect-all", "xypp-more-bbcode.collect-all")
        ->serializeToForum("xypp-more-bbcode-collect-markdown", "xypp-more-bbcode.collect-markdown")
        ->serializeToForum("xypp-more-bbcode-pref-markdown", "xypp-more-bbcode.pref-markdown"),
    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(ForumAttributes::class),
    (new Extend\User)
        ->registerPreference("xypp-more-bbcode-auto-close")
        ->registerPreference("xypp-more-bbcode-pref-markdown")
        ->registerPreference("xypp-more-bbcode-collect-all")
        ->registerPreference("xypp-more-bbcode-remove-markdown")
        ->registerPreference("xypp-more-bbcode-collect-markdown")
];
