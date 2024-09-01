import app from "flarum/forum/app";
export type COMMON_KEY = "describe" | "title" | "text" | "Put" | "url" | "size" | "file" | "any" | "column" | "simple";
export default function common(key: COMMON_KEY): string {
    return app.translator.trans("xypp-more-bbcode.forum.common." + key) + ""
}