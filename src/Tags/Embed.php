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

class Embed
{
    protected FunctionHelper $functions;
    public function __construct(FunctionHelper $functions)
    {
        $this->functions = $functions;
    }
    public function __invoke(Configurator $config)
    {
        // Simple Audio Embedding
        if ($this->functions->isEnable("audio"))
            $config->BBCodes->addCustom(
                '[audio mp3="{URL1?}" m4a="{URL2?}" wav="{URL3?}" ogg="{URL4?}" flac="{URL5?}" webm="{URL6?}" width="{NUMBER?;defaultValue=100}"]',
                '<p><audio class="bbaudio inline-exclude" style="width:{NUMBER}%;" controls controlsList="nodownload">
                        <source src="{URL1}" type="audio/mpeg">
                        <source src="{URL2}" type="audio/mp4">
                        <source src="{URL3}" type="audio/wav">
                        <source src="{URL4}" type="audio/ogg">
                        <source src="{URL5}" type="audio/flac">
                        <source src="{URL6}" type="audio/webm">
                </audio></p>'
            );


        // Download Button
        if ($this->functions->isEnable("download"))
            $config->BBCodes->addCustom(
                '[down link={URL} size={TEXT1} name={TEXT2}]',
                '<div class="ButtonGroup dadadownload"><span class="Button hasIcon Button--icon Button--primary dadadownload"><i class="fas fa-download"></i></span><span class="Button"><a href="{URL}" title="{TEXT2}" target="_blank" rel="ugc noopener nofollow">{TEXT2}</a></span><span class="Button Button--primary">{TEXT1}</span></div>'
            );

        //Simple Video Embedding
        if ($this->functions->isEnable("clip"))
            $config->BBCodes->addCustom(
                '[clip mp4="{URL?}"]',
                '<p><video controls src="{URL}"></video></p>'
            );

        //Google Document Embed
        if ($this->functions->isEnable("gdoc"))
            $config->BBCodes->addCustom(
                '[GDOC]{URL}[/GDOC]',
                '<p class="bbextend-gdoc"><a href="{URL}" target="_blank" rel="ugc noopener nofollow"><i class="fas fa-file-word"></i> View Google Doc</a></p>'
            );
    }
}