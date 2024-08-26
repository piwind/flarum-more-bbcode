<?php

/*
 * This file is part of imeepo/flarum-more-bbcode.
 *
 * Copyright (c) 2024 小鱼飘飘
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Imeepo\MoreBBCode;
use Flarum\Locale\Translator;
use s9e\TextFormatter\Configurator;

class Configure
{
    private $translator;
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }
    public function __invoke(Configurator $config)
    {
        $config->BBCodes->addCustom(
            '[REPLY]{TEXT}[/REPLY]',
            '<div class="reply2see"><div class="reply2see_title">' .
            $this->translator->trans('xypp-more-bbcode.forum.hidden_content_reply')
            . '</div><xsl:apply-templates /></div>'
        );
        $config->BBCodes->addCustom(
            '[LOGIN]{TEXT}[/LOGIN]',
            '<div class="login2see"><div class="login2see_title">' .
            $this->translator->trans('xypp-more-bbcode.forum.hidden_content_login') .
            '</div><xsl:apply-templates /></div>'
        );
        $config->BBCodes->addCustom(
            '[cloud type={TEXT1} title={TEXT2} url={URL}]{TEXT3}[/cloud]',
            '<div class="imeepo_cloud cloud_{TEXT1}"><div class="cloud_logo"></div><div class="cloud_describe"><div class="cloud_title">{TEXT2}</div><div class="cloud_content"><span class="cloud_type"></span><span class="cloud_password cloud_hide{TEXT3}"> | <span class="cloud_text"></span>{TEXT3}</span></div></div><a class="cloud_button" href="{URL}" target="_blank" rel="noopener noreferrer"><i class="fa fa-download"></i></a></div>'
        );

        $config->tags->add("login2see_guest")->template =
            '<div class="login2see"><div class="login2see_alert">' .
            $this->translator->trans(
                'xypp-more-bbcode.forum.login_to_see',
                array(
                    '{login}' => '<a class="login2see_login">' . $this->translator->trans('core.forum.header.log_in_link') . '</a>',
                )
            ) . '</div></div>';

        $config->tags->add("reply2see_alert")->template =
            '<div class="reply2see"><div class="reply2see_alert">' .
            $this->translator->trans(
                'xypp-more-bbcode.forum.reply_to_see',
                array(
                    '{reply}' => '<a class="reply2see_reply">' . $this->translator->trans('core.forum.discussion_controls.reply_button') . '</a>',
                )
            ) . '</div></div>';
    }
}