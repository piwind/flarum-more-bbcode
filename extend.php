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

namespace Imeepo\MoreBBCode;

use Flarum\Api\Serializer\PostSerializer;
use Flarum\Extend;
use Imeepo\MoreBBCode\ReplaceCode;
use s9e\TextFormatter\Configurator;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/resources/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
    (new Extend\Formatter)
        ->configure(Configure::class)
        ->render(Rendering::class),
    new Extend\Locales(__DIR__ . '/resources/locale')
];