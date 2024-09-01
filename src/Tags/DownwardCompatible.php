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

class DownwardCompatible
{
    protected FunctionHelper $functions;
    public function __construct(FunctionHelper $functions)
    {
        $this->functions = $functions;
    }
    public function __invoke(Configurator $config)
    {
        //OLD SUPPORT #
        if ($this->functions->isEnable("size")) {
            $config->BBCodes->addCustom(
                '[SIZE1]{TEXT}[/SIZE1]',
                '<span style="font-size: 12px;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[SIZE2]{TEXT}[/SIZE2]',
                '<span style="font-size: 15px;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[SIZE3]{TEXT}[/SIZE3]',
                '<span style="font-size: 22px;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[SIZE4]{TEXT}[/SIZE4]',
                '<span style="font-size: 26px;">{TEXT}</span>'
            );
        }
        //OLD SUPPORT #
        if ($this->functions->isEnable("color")) {
            $config->BBCodes->addCustom(
                '[COLORT]{TEXT}[/COLORT]',
                '<span style="color: #1abc9c;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[COLORG]{TEXT}[/COLORG]',
                '<span style="color: #2ecc71;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[COLORB]{TEXT}[/COLORB]',
                '<span style="color: #3498db;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[COLORP]{TEXT}[/COLORP]',
                '<span style="color: #9b59b6;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[COLORY]{TEXT}[/COLORY]',
                '<span style="color: #f1c40f;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[COLORO]{TEXT}[/COLORO]',
                '<span style="color: #e67e22;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[COLORR]{TEXT}[/COLORR]',
                '<span style="color: #e74c3c;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(
                '[COLORS]{TEXT}[/COLORS]',
                '<span style="color: #95a5a6;">{TEXT}</span>'
            );
        }
    }
}