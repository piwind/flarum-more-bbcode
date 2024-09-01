<?php

/*
 * This file is part of xypp/more-bbcode.
 *
 * Copyright (c) 2024 小鱼飘飘
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Xypp\MoreBBCode\Tags;

use Flarum\Locale\Translator;
use s9e\TextFormatter\Configurator;

/**
 * Fix for highlight JS not working after changing post content.
 *
 * @link https://github.com/flarum/framework/issues/3794
 */
class HighlightJSFix
{
    public function __invoke(Configurator $config)
    {
        if ($config->tags->exists("CODE")) {
            $codeTag = $config->tags->get('CODE');
            $script = '
                <script>
                    if(window.hljsLoader && !document.currentScript.parentNode.hasAttribute(\'data-s9e-livepreview-onupdate\')) {
                        window.hljsLoader.highlightBlocks(document.currentScript.parentNode);
                    }
                </script>';
            $codeTag->template = str_replace('</pre>', $script . '</pre>', $codeTag->template);
        }
    }
}