import app from 'flarum/admin/app';

app.initializers.add('xypp/flarum-more-bbcode', () => {
  app.extensionData
    .for('xypp-more-bbcode')
    .registerPermission(
      {
        icon: 'fas fa-eye-slash',
        label: app.translator.trans('xypp-more-bbcode.admin.permissions.bypass_reply_label'),
        permission: 'post.bypassReplyRequirement',
      },
      'view'
    );
});
