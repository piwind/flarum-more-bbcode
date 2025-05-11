# piwind/flarum-more-bbcode

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/piwind/flarum-more-bbcode.svg)](https://packagist.org/packages/piwind/flarum-more-bbcode) [![Total Downloads](https://img.shields.io/packagist/dt/piwind/flarum-more-bbcode.svg)](https://packagist.org/packages/piwind/flarum-more-bbcode)

## 关于此分支

此分支 Fork 自 `xypp/flarum-more-bbcode`，仅做了一个逻辑修复，调整了默认配置。

### 补充说明

- 开启这个插件，顺便把官方插件flarum/markdown中不支持的**markdown表格**的问题解决了，因为这个插件支持渲染markdown语法的表格。
- 默认设置关闭了iframe和gdoc功能

## 原作者xypp留的信息

此分支 Fork 自`Litalino/flarum-more-bbcode`和`imeepo/flarum-more-bbcode`并重写了所有代码以改善体验

本项目所用样式以及图标等资产均来自原项目。感谢 [imeepo](https://github.com/imeepo)和[Litalino](https://github.com/Litalino) 对flarum和原项目的贡献！

原项目请访问 [imeepo版](https://github.com/imeepo/flarum-more-bbcode)，[Litalino版](https://github.com/Litalino/flarum-more-bbcode)

### 改进

本项目为原项目提供了下列改善

+ 更好的样式支持（多级列表浮窗）更接近flarum原版样式
+ 移动端支持
+ 功能开关
+ 语言样式改善，优化了代码中几乎所有的硬编码文本
+ 渲染逻辑优化，解决了权限问题
+ CloudBox支持自定义类型和图标
+ 代码结构改善（一个extend.php 500行，坐的住.jpg）


### 问题

由于本人不懂越南语，所以无法保留原作者的VI语言文件。对此表示非常抱歉。

GDoc代码经测试存在不明问题，故移除了前端按钮。

Iframe移除了部分属性支持以解决安全性问题**（事实上该特性不推荐开启，建议安装后直接到管理面板关闭）**

快捷键功能在此版本暂未实现。将来视需求添加。

## 截图

![1725161790295.png](https://cdn-fusion.imgimg.cc/i/2024/25282f80e406b4d9.png)

![1725161837360.png](https://cdn-fusion.imgimg.cc/i/2024/c5d29a362831258b.png)

## 安装和更新

使用 composer 进行安装：

```bash
composer require piwind/flarum-more-bbcode:"*"
```

更新：

```bash
composer update piwind/flarum-more-bbcode:"*"
php flarum assets:publish
php flarum cache:clear
```

## 更新内容

### v2.1.9

- 修复云盘框列表中的删除按钮的反逻辑
- 调整了默认配置，并默认关闭iframe和gdoc功能
- 修改源码中的包名、作者信息

### v2.0.5

+ 添加了BBCode和Markdown的切换功能
+ 【注意】调整了默认配置。现在默认会输入BBCode而不是Markdown。该设置可以由用户修改

### v2.0.0

- 合入了Litalino的Fork
- 完全重写了前端代码

以下feature也在此版本引入

+ 更好的样式支持（多级列表浮窗）更接近flarum原版样式
+ 移动端支持
+ 功能开关
+ 语言样式改善，优化了代码中几乎所有的硬编码文本
+ 渲染逻辑优化，解决了权限问题
+ CloudBox支持自定义类型和图标
+ 代码结构改善

### v1.0.0

- 完全重写后端代码，在 Render 过程中进行判断，解决了权限问题，预览问题等
- 有可能还解决了样式丢失问题（不确定，需要测试）

## 链接

- [Packagist](https://packagist.org/packages/piwind/flarum-more-bbcode)
- [GitHub](https://github.com/piwind/flarum-more-bbcode)

