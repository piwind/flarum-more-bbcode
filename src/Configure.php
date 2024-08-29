<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Litalino\MoreBBCode;

use s9e\TextFormatter\Configurator;

class Configure
{
    public function __invoke(Configurator $config)
    {
        $this->addTagsFromRepositories($config);
        $this->adaptHighlightJs($config);
    }

    protected function addTagsFromRepositories(Configurator $config): void
    {
        // Allowed BBCode tags
        $config->BBCodes->addFromRepository('B');
        $config->BBCodes->addFromRepository('I');
        $config->BBCodes->addFromRepository('U');
        $config->BBCodes->addFromRepository('S');
        $config->BBCodes->addFromRepository('URL');
        $config->BBCodes->addFromRepository('IMG');
        $config->BBCodes->addFromRepository('EMAIL');
        $config->BBCodes->addFromRepository('CODE');
        $config->BBCodes->addFromRepository('QUOTE', 'default', [
            'authorStr' => '<xsl:value-of select="@author"/> <xsl:value-of select="$L_WROTE"/>'
        ]);
        $config->BBCodes->addFromRepository('LIST');
        //$config->BBCodes->addFromRepository('DEL');
        $config->BBCodes->addFromRepository('COLOR');
        $config->BBCodes->addFromRepository('CENTER');
        $config->BBCodes->addFromRepository('SIZE');
        $config->BBCodes->addFromRepository('*');
        //Allowed BBCode ADD
        $config->BBCodes->addFromRepository('ALIGN');
        $config->BBCodes->addFromRepository('LEFT');
        $config->BBCodes->addFromRepository('RIGHT');
        $config->BBCodes->addFromRepository('JUSTIFY');
        $config->BBCodes->addFromRepository('BACKGROUND');
        $config->BBCodes->addFromRepository('SUB');
        $config->BBCodes->addFromRepository('SUP');
        $config->BBCodes->addFromRepository('DEL');
        $config->BBCodes->addFromRepository('INS');
        $config->BBCodes->addFromRepository('VAR');
        $config->BBCodes->addFromRepository('DD');
        $config->BBCodes->addFromRepository('FLOAT');
        //$config->BBCodes->addFromRepository('MAGNET'); // NO
        //$config->BBCodes->addFromRepository('DL');
        //$config->BBCodes->addFromRepository('DT');
        //$config->BBCodes->addFromRepository('C');
        //$config->BBCodes->addFromRepository('INDENT');
        $config->BBCodes->addFromRepository('HR');
        //$config->BBCodes->addFromRepository('OL');
        //$config->BBCodes->addFromRepository('UL');
        $config->BBCodes->addFromRepository('ACRONYM');
        //$config->BBCodes->addFromRepository('NOPARSE');
        //$config->BBCodes->add('LI');

        // Allowed HTML tags
        //$config->HTMLElements->allowElement('hr');
        //$config->HTMLElements->allowElement('ol');
        //$config->HTMLElements->allowElement('ul');
        //$config->HTMLElements->allowElement('li');
        $config->HTMLElements->allowUnsafeElement('iframe');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'style');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'src');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'scrolling');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'allow');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'allowpaymentrequest');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'credentialless');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'csp');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'height');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'loading');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'name');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'referrerpolicy');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'sandbox');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'width');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'align');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'frameborder');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'longdesc');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'marginheight');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'marginwidth');
        $config->HTMLElements->allowUnsafeAttribute('iframe', 'scrolling');
    }

    /**
     * Fix for highlight JS not working after changing post content.
     *
     * @link https://github.com/flarum/framework/issues/3794
     */
    protected function adaptHighlightJs(Configurator $config): void
    {
        $codeTag = $config->tags->get('CODE');
        $script = '
                <script>
                    if(window.hljsLoader && !document.currentScript.parentNode.hasAttribute(\'data-s9e-livepreview-onupdate\')) {
                        window.hljsLoader.highlightBlocks(document.currentScript.parentNode);
                    }
                </script>';
        $codeTag->template = str_replace('</pre>', $script.'</pre>', $codeTag->template);
    }
}<?php

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