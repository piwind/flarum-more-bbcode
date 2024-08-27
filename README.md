# Imeepo/flarum-more-bbcode

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/xypp/flarum-more-bbcode.svg)](https://packagist.org/packages/xypp/flarum-more-bbcode) [![Total Downloads](https://img.shields.io/packagist/dt/xypp/flarum-more-bbcode.svg)](https://packagist.org/packages/xypp/flarum-more-bbcode)

一个 [Flarum](http://flarum.org) 拓展. 添加了一些常用的 BBCode，如登录可见、回复可见、网盘样式等。

## 关于此分支

此分支 Fork 自`imeepo/flarum-more-bbcode`并对其后端代码进行大幅修改（重写）以修复一些常年存在的 bug。

本项目所用样式以及图标等资产均来自原项目。感谢 [imeepo](https://github.com/imeepo) 对flarum和原项目的贡献！

原项目请访问 [GitHub](https://github.com/imeepo/flarum-more-bbcode)

## 安装

使用 composer 进行安装:

```sh
composer require xypp/flarum-more-bbcode:"*"
```

## 如何使用

### 登录/回复可见

当创建/编辑一篇文章时，你可以简单地使用[reply]BBCode 使它对其他用户隐藏，只有回复的用户才可以看到隐藏内容。

```bbcode
[login]这里的内容登录可见[/login]
[reply]这里的内容回复可见[/reply]
```

### 网盘样式

很优雅的分享网盘链接，或 Github/Gitee 仓库链接(如果没有密码可以不填写)

```bbcode
[cloud type=lz title=标题 url=链接]密码[/cloud]
[cloud type=123 title=标题 url=链接]密码[/cloud]
[cloud type=ali title=标题 url=链接]密码[/cloud]
[cloud type=bd title=标题 url=链接]密码[/cloud]
[cloud type=ty title=标题 url=链接]密码[/cloud]
[cloud type=360 title=标题 url=链接]密码[/cloud]
[cloud type=ct title=标题 url=链接]密码[/cloud]
[cloud type=tx title=标题 url=链接]密码[/cloud]
[cloud type=kk title=标题 url=链接]密码[/cloud]
[cloud type=other title=标题 url=链接]密码[/cloud]
[cloud type=github title=标题 url=链接]v1.0.0[/cloud]
[cloud type=gitee title=标题 url=链接]v1.0.0[/cloud]
```

## 已知问题

按理来说全部解决了，这里应该等着填新问题了（）

## 更新

```sh
composer update xypp/flarum-more-bbcode:"*"
php flarum cache:clear
```

## 更新内容

### v1.0.0

- 完全重写后端代码，在 Render 过程中进行判断，解决了权限问题，预览问题等
- 有可能还解决了样式丢失问题（不确定，需要测试）

## 链接

- [Packagist](https://packagist.org/packages/xypp/flarum-more-bbcode)
- [GitHub](https://github.com/zxy19/flarum-more-bbcode)

## 原版更新日志

### 1.0.3

- 修复了 en.yml（[Litalino 修复](https://github.com/imeepo/flarum-more-bbcode/pull/2/commits/5ac34546d7a6c372af65471c22c2304943c3f0f0)）
- 为 other 下载添加了语言

### 1.0.2

- 修复帖子作者在编辑的时候，网盘下载地址会点击不了（[zxy19 修复](https://github.com/imeepo/flarum-more-bbcode/commit/c1e4cfcde7c1de0314be5656306fe9c7c81b9e2b)）
- 新增夸克网盘

## 链接

- [Packagist](https://packagist.org/packages/imeepo/flarum-more-bbcode)
- [GitHub](https://github.com/imeepo/flarum-more-bbcode)
