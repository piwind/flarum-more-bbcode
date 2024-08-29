/*
 * This file is part of MathRen.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

app.initializers.add("xypp/more-bbcode", () => {
  extend(TextEditor.prototype, "toolbarItems", function (items) {
    items.add(
      "reply-to-see",
      <TextEditorButton
        onclick={() => {
          this.attrs.composer.editor.insertAtCursor("[reply][/reply]");
          const range = this.attrs.composer.editor.getSelectionRange();
          this.attrs.composer.editor.moveCursorTo(range[1] - 8);
        }}
        icon="fa fa-comment-medical"
      >
        {app.translator.trans("xypp-more-bbcode.forum.button_tooltip_reply")}
      </TextEditorButton>
    );
    items.add(
      "login-to-see",
      <TextEditorButton
        onclick={() => {
          this.attrs.composer.editor.insertAtCursor("[login][/login]");
          const range = this.attrs.composer.editor.getSelectionRange();
          this.attrs.composer.editor.moveCursorTo(range[1] - 8);
        }}
        icon="fas fa-sign-in-alt"
      >
        {app.translator.trans("xypp-more-bbcode.forum.button_tooltip_login")}
      </TextEditorButton>
    );
    items.add(
      "imeepo-cloud",
      <TextEditorButton
        onclick={() => {
          this.attrs.composer.editor.insertAtCursor('[cloud type=other title=' + app.translator.trans("xypp-more-bbcode.forum.cloud_title") +' url=' + app.translator.trans("xypp-more-bbcode.forum.cloud_url") +']' + app.translator.trans("xypp-more-bbcode.forum.cloud_password") +'[/cloud]');
          const range = this.attrs.composer.editor.getSelectionRange();
          this.attrs.composer.editor.moveCursorTo(range[1] - 8);
        }}
        icon="fas fa-download"
      >
        {app.translator.trans("xypp-more-bbcode.forum.button_tooltip_cloud")}
      </TextEditorButton>
    );
  });
import app from 'flarum/common/app';
import addTextEditorButton from './addTextEditorButton';

app.initializers.add(
  'litalino-more-bbcode',
  () => {
    // Add text editor buttons.
    addTextEditorButton();
     
  },
  -500 // since we're overriding things...
);
