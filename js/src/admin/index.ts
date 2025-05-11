import app from 'flarum/admin/app';
import adminPage from './adminPage';

app.initializers.add('piwind/flarum-more-bbcode', () => {
  app.extensionData
    .for('piwind-more-bbcode')
    .registerPage(adminPage)
    .registerPermission(
      {
        icon: 'fas fa-eye-slash',
        label: app.translator.trans('piwind-more-bbcode.admin.permissions.bypass_reply_label'),
        permission: 'post.bypassReplyRequirement',
      },
      "view"
    )
    .registerPermission(
      {
        icon: "fas fa-eye-slash",
        label: app.translator.trans("piwind-more-bbcode.admin.permissions.bypass_like_label"),
        permission: "post.bypassLikeRequirement",
      },
      "view"
    );
});
