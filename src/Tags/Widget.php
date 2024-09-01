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

class Widget
{
    protected FunctionHelper $functions;
    protected Translator $translator;
    public function __construct(FunctionHelper $functions, Translator $translator)
    {
        $this->functions = $functions;
        $this->translator = $translator;
    }
    public function __invoke(Configurator $config)
    {
        //Progress Bar
        if ($this->functions->isEnable("progress"))
            $config->BBCodes->addCustom(
                '[PBAR]{TEXT},{TEXT2},{COLOR},{COLOR2},{COLOR3},{NUMBER},{NUMBER2},{NUMBER3},{NUMBER4}[/PBAR]',
                '<div class="MiniFLAR-ProgressBar-container">
            <h3 class="MiniFLAR-ProgressBar-header">{TEXT}</h3>
            <div class="MiniFLAR-ProgressBar-meter" style="border: {NUMBER}px solid {COLOR};border-radius:{NUMBER3}px;
            margin-bottom:{NUMBER4}px">
                <div class="MiniFLAR-ProgressBar-meter-status" style="width: {NUMBER2}%; background-color: {COLOR2};
                    border-bottom-left-radius: {NUMBER3}px; border-top-left-radius: {NUMBER3}px;
                    border-right: 0.5em solid {COLOR3}">
                        <span class="MiniFLAR-ProgressBar-meter-pointer">{TEXT2}</span>
                </div>
            </div>
        </div>'
            );
        if ($this->functions->isEnable("alert"))
            $this->addAlerts($config);
    }

    protected function addAlerts(Configurator $config)
    {
        // Common Types
        foreach (['error', 'success', 'warning', 'notice'] as $type) {
            $label = $this->translator->trans("xypp-more-bbcode.forum.alert.label.$type");
            $config->BBCodes->addCustom(
                "[a$type]{TEXT}[/a$type]",
                '<div id="aaalertbody"><div class="aaalert aa' . $type . '"><p class="aainner"><strong>' . $label . ' </strong>{TEXT}</p></div></div>'
            );
            $config->BBCodes->addCustom(
                "[b$type]{TEXT}[/b$type]",
                '<div id="aaalertbody"><div class="bbalert-box bb' . $type . '"><span>' . $label . ' </span>{TEXT}</div></div>'
            );
            $config->BBCodes->addCustom(
                "[c$type]{COLOR},{COLOR2},{COLOR3},{TEXT},{TEXT2}[/c$type]",
                '<div id="aaalertbody"><div class="bbalert-box bb' . $type . '" style="color: {COLOR}; background-color: {COLOR2}; border-color: {COLOR3};"><span>{TEXT}: </span>{TEXT2}</div></div>'
            );
            $config->BBCodes->addCustom(
                "[d$type title=\"{TEXT}\" font=\"{COLOR}\" bg=\"{COLOR2}\" border=\"{COLOR3}\"]{TEXT2}[/d$type]",
                '<div id="aaalertbody"><div class="bbalert-box bb' . $type . '" style="color: {COLOR}; background-color: {COLOR2}; border-color: {COLOR3};"><span>{TEXT}: </span>{TEXT2}</div></div>'
            );
        }

        // Special Types
        $config->BBCodes->addCustom(
            '[acustom]{COLOR},{COLOR2},{COLOR3},{TEXT}[/acustom]',
            '<div id="aaalertbody"><div class="aaalert"><p class="aainner" style="color: {COLOR}; background-color: {COLOR2}; border-color: {COLOR3};">{TEXT}</p></div></div>'
        );
        $config->BBCodes->addCustom(
            '[bcustom]title={TEXT} font={COLOR} bg={COLOR2} border={COLOR3}[/bcustom]',
            '<div id="aaalertbody"><div class="aaalert"><p class="aainner" style="color: {COLOR}; background-color: {COLOR2}; border-color: {COLOR3};">{TEXT}</p></div></div>'
        );
        $config->BBCodes->addCustom(
            '[abasic]{TEXT}[/abasic]',
            '<div id="aaalertbody"><div class="aaalert"><p class="aainner">{TEXT}</p></div></div>'
        );
    }
}