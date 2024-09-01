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

class RepositoryBBCode
{
    protected $translator;
    protected FunctionHelper $functions;
    public function __construct(Translator $translator, FunctionHelper $functions)
    {
        $this->functions = $functions;
        $this->translator = $translator;
    }
    public function __invoke(Configurator $config)
    {
        // Allowed BBCode tags
        if ($this->functions->isEnable("bold"))
            $config->BBCodes->addFromRepository('B');
        if ($this->functions->isEnable("italic"))
            $config->BBCodes->addFromRepository('I');
        if ($this->functions->isEnable("underline"))
            $config->BBCodes->addFromRepository('U');
        if ($this->functions->isEnable("strike_through"))
            $config->BBCodes->addFromRepository('S');
        if ($this->functions->isEnable("url"))
            $config->BBCodes->addFromRepository('URL');
        if ($this->functions->isEnable("image"))
            $config->BBCodes->addFromRepository('IMG');
        if ($this->functions->isEnable("email"))
            $config->BBCodes->addFromRepository('EMAIL');
        if ($this->functions->isEnable("code"))
            $config->BBCodes->addFromRepository('CODE');
        if ($this->functions->isEnable("quote"))
            $config->BBCodes->addFromRepository('QUOTE', 'default', [
                'authorStr' => '<xsl:value-of select="@author"/> ' . $this->translator->trans('xypp-more-bbcode.forum.quote.wrote')
            ]);
        if ($this->functions->isEnable("list-ul") || $this->functions->isEnable("list-ol"))
            $config->BBCodes->addFromRepository('*');
        if ($this->functions->isEnable("list-ol") || $this->functions->isEnable("list-ul"))
            $config->BBCodes->addFromRepository('LIST');

        if ($this->functions->isEnable("color"))
            $config->BBCodes->addFromRepository('COLOR');
        if ($this->functions->isEnable("size"))
            $config->BBCodes->addFromRepository('SIZE');

        // Align Codes
        if (
            $this->functions->isEnable("align-left") ||
            $this->functions->isEnable("align-right") ||
            $this->functions->isEnable("align-center") ||
            $this->functions->isEnable("align")
        )
            $config->BBCodes->addFromRepository('ALIGN');
        if ($this->functions->isEnable("align-center"))
            $config->BBCodes->addFromRepository('CENTER');
        if ($this->functions->isEnable("align-left"))
            $config->BBCodes->addFromRepository('LEFT');
        if ($this->functions->isEnable("align-right"))
            $config->BBCodes->addFromRepository('RIGHT');
        if ($this->functions->isEnable("justify"))
            $config->BBCodes->addFromRepository('JUSTIFY');


        if ($this->functions->isEnable("background"))
            $config->BBCodes->addFromRepository('BACKGROUND');
        if ($this->functions->isEnable("subscript"))
            $config->BBCodes->addFromRepository('SUB');
        if ($this->functions->isEnable("superscript"))
            $config->BBCodes->addFromRepository('SUP');
        if ($this->functions->isEnable("strike-through"))
            $config->BBCodes->addFromRepository('DEL');
        if ($this->functions->isEnable("underline"))
            $config->BBCodes->addFromRepository('INS');
        if ($this->functions->isEnable("horizontal-line"))
            $config->BBCodes->addFromRepository('HR');
        if ($this->functions->isEnable("acronym"))
            $config->BBCodes->addFromRepository('ACRONYM');
    }
}