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
use Xypp\MoreBBCode\Helper\FunctionHelper;

class Misc
{
    protected FunctionHelper $functions;
    public function __construct(FunctionHelper $functions)
    {
        $this->functions = $functions;
    }
    public function __invoke(Configurator $config)
    {
        if ($this->functions->isEnable("litedown"))
            $config->Litedown;
        if ($this->functions->isEnable("table"))
            $config->PipeTables;
        if ($this->functions->isEnable("spoiler"))
            $config->tags['ispoiler']->template = '<span class="spoiler" data-s9e-livepreview-ignore-attrs="class" onclick="removeAttribute(\'class\')"><xsl:apply-templates/></span>';
    }
}