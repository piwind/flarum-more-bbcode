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

class Container
{
    protected FunctionHelper $functions;
    public function __construct(FunctionHelper $functions)
    {
        $this->functions = $functions;
    }
    public function __invoke(Configurator $config)
    {
        // Details
        if ($this->functions->isEnable("detail"))
            $config->BBCodes->addCustom(
                '[DETAILS title={TEXT1;optional}]{TEXT2}[/DETAILS]',
                '<details><summary>{TEXT1}</summary><div>{TEXT2}</div></details>'
            );

        // Tabs
        if ($this->functions->isEnable("tabs")) {
            $config->BBCodes->addCustom(
                '[tabs]{TEXT}[/tabs]',
                '<div class="tabs"><div class="tabs-title"><xsl:apply-templates/></div></div>'
            );
            $config->BBCodes->addCustom(
                '[tab name={ANYTHING} active={ANYTHING?}]{TEXT}[/tab]',
                <<<'XML'
<div class="tab">
    <input type="radio">
        <xsl:if test="@active">
            <xsl:attribute name="checked">checked</xsl:attribute>
        </xsl:if>
    </input>
    <label>{@name}</label>

    <div class="content">
        <xsl:apply-templates/>
    </div>
</div>
XML
            );
        }
    }
}