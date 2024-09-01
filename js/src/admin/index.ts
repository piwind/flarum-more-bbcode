import app from 'flarum/admin/app';
import adminPage from './adminPage';

app.initializers.add('xypp/flarum-more-bbcode', () => {
  app.extensionData
    .for('xypp-more-bbcode')
    .registerPage(adminPage)
    .registerPermission(
      {
        icon: 'fas fa-eye-slash',
        label: app.translator.trans('xypp-more-bbcode.admin.permissions.bypass_reply_label'),
        permission: 'post.bypassReplyRequirement',
      },
      "view"
    )
    .registerPermission(
      {
        icon: "fas fa-eye-slash",
        label: app.translator.trans("xypp-more-bbcode.admin.permissions.bypass_like_label"),
        permission: "post.bypassLikeRequirement",
      },
      "view"
    );
});
