<?php

namespace Xypp\MoreBBCode;

/*
 * This file is part of imeepo/flarum-more-bbcode.
 *
 * Copyright (c) 2024 小鱼飘飘
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use DOMDocument;
use DOMElement;
use Flarum\Discussion\Discussion;
use Flarum\Http\RequestUtil;
use Flarum\Post\CommentPost;
use Flarum\Post\Post;
use Flarum\User\Guest;
use Flarum\User\User;
use Psr\Http\Message\ServerRequestInterface;
use s9e\TextFormatter\Renderer;
use Symfony\Component\Config\Util\XmlUtils;

class Rendering
{
    public function __invoke(Renderer $renderer, $context, string $xml, ?ServerRequestInterface $request)
    {
        $post = $context;
        if (!($post instanceof CommentPost)) {
            return $xml;
        }
        $document = XmlUtils::parse($xml);
        if ($request)
            $actor = RequestUtil::getActor($request);
        else
            $actor = new Guest();
        $this->login2seeProcess($actor, $document);
        $this->reply2seeProcess($actor, $document, $post->discussion);
        $this->like2seeProcess($actor, $document, $post);
        $xml = $document->saveXML();
        $xml = preg_replace("/<\?xml[^>]*>/", "", $xml);
        return $xml;
    }
    protected function extractNodes($tags){
        $list = [];
        foreach ($tags->getIterator() as $tag) {
            $list[] = $tag;
        }
        return $list;
    }

    protected function login2seeProcess(User $actor, DOMDocument $document)
    {
        if ($actor->isGuest()) {
            $tags = $this->extractNodes($document->getElementsByTagName('LOGIN'));
            /**
             * @var DOMElement|DOMNameSpaceNode|DOMNode $tag
             */
            foreach ($tags as $tag) {
                $tag->after($document->createElement("LOGIN2SEE_GUEST"));
                $tag->remove();
            }
        }
    }

    protected function reply2seeProcess(User $actor, DOMDocument $document, Discussion $discussion)
    {
        if ($actor->hasPermission('post.bypassReplyRequirement')) {
            return;
        }
        if (!$actor->isGuest()) {
            if ($discussion->participants()->where("user_id", $actor->id)->exists()) {
                return;
            }
        }
        $tags = $this->extractNodes($document->getElementsByTagName('REPLY'));
        /**
         * @var DOMElement|DOMNameSpaceNode|DOMNode $tag
         */
        foreach ($tags as $tag) {
            $tag->after($document->createElement("REPLY2SEE_ALERT"));
            $tag->remove();
        }
    }

    protected function like2seeProcess(User $actor, DOMDocument $document, Post $post)
    {
        if ($actor->hasPermission('post.bypassLikeRequirement')) {
            return;
        }
        if (!$actor->isGuest()) {
            if ($post->user_id == $actor->id) {
                return;
            }
            if ($post->likes()->where('user_id', $actor->id)->exists()) {
                return;
            }
        }
        $tags = $this->extractNodes($document->getElementsByTagName('LIKE'));
        /**
         * @var DOMElement|DOMNameSpaceNode|DOMNode $tag
         */
        foreach ($tags as $tag) {
            $tag->after($document->createElement("LIKE2SEE_ALERT"));
            $tag->remove();
        }
    }
}