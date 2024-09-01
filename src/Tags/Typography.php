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

class Typography
{
    protected FunctionHelper $functions;
    public function __construct(FunctionHelper $functions)
    {
        $this->functions = $functions;
    }
    public function __invoke(Configurator $config)
    {

        //Padding Block Left/Right
        if ($this->functions->isEnable("padding-left"))
            $config->BBCodes->addCustom(
                '[pleft]{TEXT}[/pleft]',
                '<div style="padding-left: 40px;">{TEXT}</div>'
            );
        if ($this->functions->isEnable("padding-right"))
            $config->BBCodes->addCustom(
                '[pright]{TEXT}[/pright]',
                '<div style="padding-right: 40px;">{TEXT}</div>'
            );



        //Image Position Left/Center/Right
        //Left
        if ($this->functions->isEnable("image-right")) {
            $config->BBCodes->addCustom(
                '[img-left]{TEXT}[/img-left]',
                '<div class="img-left">{TEXT}</div>'
            );

            $config->BBCodes->addCustom(
                '[ileft]{TEXT}[/ileft]',
                '<div class="img-left">{TEXT}</div>'
            );
        }
        //Center
        if ($this->functions->isEnable("image-center")) {
            $config->BBCodes->addCustom(
                '[img-center]{TEXT}[/img-center]',
                '<div class="img-center">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[icenter]{TEXT}[/icenter]',
                '<div class="img-center">{TEXT}</div>'
            );
        }
        //Right
        if ($this->functions->isEnable("image-right")) {
            $config->BBCodes->addCustom(
                '[img-right]{TEXT}[/img-right]',
                '<div class="img-right">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[iright]{TEXT}[/iright]',
                '<div class="img-right">{TEXT}</div>'
            );
        }

        // Dropcap
        if ($this->functions->isEnable("dropcap"))
            $config->BBCodes->addCustom(
                '[dropcap]{TEXT}[/dropcap]',
                '<div class="has-dropcap">{TEXT}</div>'
            );

        // Padding
        if ($this->functions->isEnable("indent"))
            $config->BBCodes->addCustom(
                '[indent={NUMBER}]{TEXT}[/indent]',
                '<div style="padding-left: {NUMBER}px;">{TEXT}</div>'
            );
    }
}