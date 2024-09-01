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

/**
 * Reply to see/Login to see/Like to see
 */
class XXXToSee
{
    protected FunctionHelper $functions;
    protected $translator;
    public function __construct(Translator $translator, FunctionHelper $functions)
    {
        $this->functions = $functions;
        $this->translator = $translator;

    }
    public function __invoke(Configurator $config)
    {
        //Reply 2 see
        if ($this->functions->isEnable("reply")) {
            $config->BBCodes->addCustom(
                '[REPLY]{TEXT}[/REPLY]',
                '<div class="xx2see reply"><div class="xx2see_title">' .
                $this->translator->trans('xypp-more-bbcode.forum.xx2see.reply.title')
                . '</div><xsl:apply-templates /></div>'
            );
            $config->tags->add("reply2see_alert")->template =
                '<div class="xx2see"><div class="xx2see_alert">' .
                $this->translator->trans(
                    'xypp-more-bbcode.forum.xx2see.reply.deny',
                    array(
                        '{reply}' => '<a class="reply2see_reply">' . $this->translator->trans('core.forum.discussion_controls.reply_button') . '</a>',
                    )
                ) . '</div></div>';
        }
        if ($this->functions->isEnable("login"))
            $config->BBCodes->addCustom(
                '[LOGIN]{TEXT}[/LOGIN]',
                '<div class="xx2see login"><div class="xx2see_title">' .
                $this->translator->trans('xypp-more-bbcode.forum.xx2see.login.title') .
                '</div><xsl:apply-templates /></div>'
            );
        if ($this->functions->isEnable("login"))
            $config->tags->add("login2see_guest")->template =
                '<div class="xx2see login"><div class="xx2see_alert">' .
                $this->translator->trans(
                    'xypp-more-bbcode.forum.xx2see.login.deny',
                    array(
                        '{login}' => '<a class="login2see_login">' . $this->translator->trans('core.forum.header.log_in_link') . '</a>',
                    )
                ) . '</div></div>';


        //Like 2 See
        if ($this->functions->isEnable("like")) {
            $config->BBCodes->addCustom(
                '[LIKE]{TEXT}[/LIKE]',
                '<div class="xx2see like"><div class="xx2see_title">' .
                $this->translator->trans('xypp-more-bbcode.forum.xx2see.like.title')
                . '</div><xsl:apply-templates /></div>'
            );
            $config->tags->add("like2see_alert")->template =
                '<div class="xx2see like"><div class="xx2see_alert">' .
                $this->translator->trans(
                    'xypp-more-bbcode.forum.xx2see.like.deny',
                    ['like' => $this->translator->trans('flarum-likes.forum.post.like_link')]
                ) . '</div></div>';
        }
    }
}