/*
 * This file is part of Xypp/more-bbcode.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import app from 'flarum/common/app';
import { extend } from 'flarum/common/extend';
import TextEditor from "flarum/common/components/TextEditor";
import buttonBar from './components/buttonBar';
import TagCollector, { TagButtonGroup, Tags } from './helper/tagCollector';
import addTypographyButtons from './tags/typography';
import addUtilitiesTags from './tags/utilities';
import TextEditorButton from "flarum/common/components/TextEditorButton";
import { prioritySerial, showIf } from './utils/nodeUtil';
import addEmbedTags from './tags/embed';
import { addXX2SeeTags } from './tags/xx2see';
import align from './utils/hAlign';
import regSetting from './settings';
function checkDevice(target: "none" | "all" | "phone" | "tablet"): boolean {
  if (target == "none") return false;
  if (target == "all") return true;
  const current = app.screen();
  if (target === 'phone' && current === "phone") return true;
  if (target === "tablet" && (current === "phone" || current === "tablet")) return true;
  return false;
}
app.initializers.add('xypp/more-bbcode', () => {
  const tags = new TagCollector();
  const priority = prioritySerial(100, 100);
  addTypographyButtons(tags, priority);
  addUtilitiesTags(tags, priority);
  addEmbedTags(tags, priority);
  addXX2SeeTags(tags, priority);
  let hasAddCollectBtn = false;
  let showMoreBBcodeButtons = false;
  extend(buttonBar.prototype, "clickEvent", function (this: buttonBar, val: any, tag: Tags) {
    if (tag.type === "group") return;
    const close = (app.session?.user?.preferences() || {})["xypp-bbcode-more-auto-close"] || "phone";
    if (checkDevice(close)) {
      showMoreBBcodeButtons = false;
      m.redraw();
    }
  })
  extend(TextEditor.prototype, "toolbarItems", function (this: TextEditor, items) {
    const removeMd = checkDevice(app.forum.attribute("xypp-more-bbcode-remove_markdown"));
    const collectAll = checkDevice(app.forum.attribute("xypp-more-bbcode-collect_all"));
    if (removeMd) items.remove("markdown");
    if (collectAll) {
      if (!hasAddCollectBtn) tags.group(0, "collect", "fas fa-box-open", "xypp-more-bbcode.forum.collect", () => { });
      const collect = tags.item("collect") as TagButtonGroup;
      collect.tags.clear();
      Object.keys(items.toObject()).forEach(function (key) {
        if (key === "markdown") return;
        const p = items.getPriority(key);
        const item = items.get(key);
        items.remove(key);
        collect.tags.collect(0 - p, key, item);
      });
    } else if (hasAddCollectBtn) {
      tags.remove("collect");
    }
    items.add("xypp-more-bbcode", TextEditorButton.component({
      className: "bbcode-more-btn Button Button--icon Button--link",
      position: "bottom",
      onclick: (e: any) => {
        e.currentTarget.blur();
        showMoreBBcodeButtons = !showMoreBBcodeButtons;
        m.redraw();
      },
      icon: showIf(showMoreBBcodeButtons, "fa fa-minus", "fa fa-plus")
    }, app.translator.trans("xypp-more-bbcode.forum.name")));
    if (showMoreBBcodeButtons)
      items.add("xypp-more-bbcode-buttons", buttonBar.component({
        tagCollect: tags,
        className: "main-entry",
        textEditor: (this.attrs as any).composer.editor.el,
        bottom: 57
      }), -50000);
  });
  extend(TextEditor.prototype, ["onupdate", "oncreate"], function (this: TextEditor) {
    if (!showMoreBBcodeButtons) return;
    const btn = this.$(".bbcode-more-btn");
    const elem = this.$(".main-entry");
    align(btn, elem);
  });
  regSetting();
}, -50000);
