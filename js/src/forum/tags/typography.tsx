import TagCollector from "../helper/tagCollector";
import common from "../utils/commonReplaceUtil";
import { prioritySerial } from "../utils/nodeUtil";
import { selectBBCodeOrNormal } from "../utils/preferenceUtil";
import { bbcode, merge, pair, prefix } from "../utils/styleUtil";

export default function addTypographyButtons(tags: TagCollector, priority: () => number) {
    // Fonts
    tags.group(priority(), "fonts",
        "fas fa-bold",
        "piwind-more-bbcode.forum.fonts.title", (tags) => {
            const priority = prioritySerial(100, 100);
            //Bold
            tags.add(priority(), "bold",
                "fas fa-bold",
                "piwind-more-bbcode.forum.fonts.bold",
                selectBBCodeOrNormal(bbcode("[b]"), pair("**")));
            //Italic
            tags.add(priority(), "italic",
                "fas fa-italic",
                "piwind-more-bbcode.forum.fonts.italic",
                selectBBCodeOrNormal(bbcode("[i]"), pair("*")));
            // Strike through
            tags.add(priority(), "strike-through",
                "fas fa-strikethrough",
                "piwind-more-bbcode.forum.fonts.strike_through",
                selectBBCodeOrNormal(bbcode("[del]"), pair("~~")));
            // Underline
            tags.add(priority(), "underline",
                "fas fa-underline",
                "piwind-more-bbcode.forum.fonts.underline",
                bbcode("[ins]"));
        }
    );
    // Typography
    tags.group(priority(), "typography",
        "fas fa-paragraph",
        "piwind-more-bbcode.forum.typography.title", (tags) => {
            const priority = prioritySerial(100, 100);
            //Link
            tags.add(priority(), "url",
                "fas fa-link",
                "piwind-more-bbcode.forum.typography.link",
                selectBBCodeOrNormal(
                    bbcode(`[URL=${common("url")} title=${common("title")}]`),
                    merge(pair("[", "](" + common("url") + ")"), {
                        replaceNext: 'https://',
                        scanFor: 'https?://'
                    })));
            //Image
            tags.add(priority(), "image",
                "fas fa-image",
                "piwind-more-bbcode.forum.typography.image",
                selectBBCodeOrNormal(
                    prefix(`[IMG src="${common("url")}" title="${common("title")}" alt="${common("simple")}" height="auto" width="auto"]`),
                    merge(pair('![', '](' + common("url") + ')'), {
                        replaceNext: 'https://',
                        scanFor: 'https?://'
                    })));
            //Quote
            tags.add(priority(), "quote",
                "fas fa-quote-right",
                "piwind-more-bbcode.forum.typography.quote",
                selectBBCodeOrNormal(
                    merge(bbcode("[quote]"), {
                        multiline: true
                    }),
                    merge(prefix("> "), {
                        multiline: true,
                        surroundWithNewlines: true
                    })));
            //Code
            tags.add(priority(), "code",
                "fas fa-code",
                "piwind-more-bbcode.forum.typography.code",
                selectBBCodeOrNormal(
                    merge(bbcode(`[code lang=${common("any")}]`), {
                        multiline: true
                    }),
                    merge(pair("`", undefined, false), {
                        blockPrefix: '```',
                        blockSuffix: '```'
                    })));
            //Spoiler
            tags.add(priority(), "spoiler",
                "fas fa-eye-slash",
                "piwind-more-bbcode.forum.typography.spoiler",
                selectBBCodeOrNormal(
                    merge(bbcode(`[spoiler title=${common("title")}]`), {
                        multiline: true
                    }),
                    merge(pair(">!", "!<"), {
                        blockPrefix: '>! ',
                        multiline: true
                    })));
            //Dropcap
            tags.add(priority(), "dropcap",
                "fas fa-caret-right",
                "piwind-more-bbcode.forum.typography.dropcap",
                bbcode("[dropcap] "));
            tags.space(priority());
            //Horizontal Line
            tags.add(priority(), "horizontal-line",
                "fas fa-minus",
                "piwind-more-bbcode.forum.typography.horizontal_line",
                bbcode("[hr]"));
            //Table
            tags.add(priority(), "table",
                "fas fa-table",
                "piwind-more-bbcode.forum.typography.table",
                selectBBCodeOrNormal(
                    prefix(`
[TABLE]
    [THEAD]
        [TH]${common("column")}[TH]
        [TH]${common("column")}[TH]
        [TH]${common("any")}[TH]
    [/THEAD]
    [TBODY]
        [TR]
            [TD]${common("text")}[TD]
            [TD]${common("text")}[TD]
            [TD]${common("any")}[TD]
        [/TR]
    [/TBODY]
[/TABLE]
`),
                    prefix(`
| ${common("column")} | ${common("column")} | ${common("column")} | ${common("column")} |
|---|---|---|---|
| ${common("any")} | ${common("any")} | ${common("any")} | ${common("any")} |
`)
                ));
            //Unordered List
            tags.add(priority(), "list-ul",
                "fas fa-list-ul",
                "piwind-more-bbcode.forum.typography.unordered_list",
                selectBBCodeOrNormal(
                    prefix(`
[list]
[*]${common("any")}
[*]${common("any")}
[*]${common("any")}
[/list]
`),
                    merge(prefix("\n- "), {
                        multiline: true,
                        surroundWithNewlines: true
                    })));
            //Ordered List
            tags.add(priority(), "list-ol",
                "fas fa-list-ol",
                "piwind-more-bbcode.forum.typography.ordered_list",
                selectBBCodeOrNormal(
                    prefix(`
[list=1]
[*]${common("any")}
[*]${common("any")}
[*]${common("any")}
[/list]
`),
                    merge(prefix("\n1. "), {
                        multiline: true,
                        orderedList: true,
                        surroundWithNewlines: true
                    })));
        }
    )
    //Heading
    tags.group(priority(), "heading",
        "fas fa-heading",
        "piwind-more-bbcode.forum.heading.title",
        (tags) => {
            const priority = prioritySerial(100, 100);
            const levels = [1, 2, 3, 4, 5, 6];
            levels.forEach(level => {
                tags.add(priority(), "heading-" + level,
                    false,
                    { key: "piwind-more-bbcode.forum.heading.label", params: { level: level } },
                    selectBBCodeOrNormal(bbcode(`[H${level}]`), pair("#".repeat(level) + " ", " " + ("#".repeat(level)))));
            });
        }
    );
    //Aligns
    tags.group(priority(), "align",
        "fas fa-align-justify",
        "piwind-more-bbcode.forum.align.title", (tags) => {
            const priority = prioritySerial(100, 100);
            // + Align left
            tags.add(priority(), "align-left",
                "fas fa-align-left",
                "piwind-more-bbcode.forum.align.align_left",
                bbcode("[left]"));
            // + Align center
            tags.add(priority(), "align-center",
                "fas fa-align-center",
                "piwind-more-bbcode.forum.align.align_center",
                bbcode("[center]"));
            // + Align right
            tags.add(priority(), "align-right",
                "fas fa-align-right",
                "piwind-more-bbcode.forum.align.align_right",
                bbcode("[right]"));
            // + Justify
            tags.add(priority(), "justify",
                "fas fa-align-justify",
                "piwind-more-bbcode.forum.align.align_justify",
                bbcode("[justify]"));
            tags.space(priority());
            //Padding
            // + Padding Left
            tags.add(priority(), "padding-left",
                "fas fa-arrow-alt-circle-left",
                "piwind-more-bbcode.forum.align.padding_left",
                bbcode("[pleft]"));
            tags.add(priority(), "padding-right",
                "fas fa-arrow-alt-circle-right",
                "piwind-more-bbcode.forum.align.padding_right",
                bbcode("[pright]"));
            tags.space(priority());
            //Image Positioning
            //+ Image Left
            tags.add(priority(), "image-left",
                () => <div className="stackIcon">
                    <i className="fas fa-image main" />
                    <i className="fas fa-arrow-alt-circle-left lb-corner" />
                </div>,
                "piwind-more-bbcode.forum.align.image_left",
                bbcode("[ileft]"));
            //+ Image Center
            tags.add(priority(), "image-center",
                () => <div className="stackIcon">
                    <i className="fas fa-image main" />
                    <i className="fas fa-arrow-alt-circle-up cb-corner" />
                </div>,
                "piwind-more-bbcode.forum.align.image_center",
                bbcode("[icenter]"))
            //+ Image Right
            tags.add(priority(), "image-right",
                () => <div className="stackIcon">
                    <i className="fas fa-image main" />
                    <i className="fas fa-arrow-alt-circle-right rb-corner" />
                </div>,
                "piwind-more-bbcode.forum.align.image_right",
                bbcode("[iright]"));
        });
    //Size
    tags.group(priority(), "size",
        "fas fa-text-height",
        "piwind-more-bbcode.forum.size.title", (tags) => {
            const sizes = [18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40]
            const priority = prioritySerial(100, 100);
            sizes.forEach(size => {
                tags.add(priority(), "size-" + size,
                    false,
                    { key: "piwind-more-bbcode.forum.size.label", params: { size: size } },
                    bbcode(`[size=${size}]`));
            });
        }, 2
    );
    //Color
    tags.group(priority(), "color",
        "fas fa-palette",
        "piwind-more-bbcode.forum.color.title", (tags) => {
            const colors = [
                "grey", "green", "blue", "purple", "yellow", "orange",
                "red", "silver", "pink", "brown", "white", "black"]
            const priority = prioritySerial(100, 100);
            colors.forEach(color => {
                tags.add(priority(), "color-" + color,
                    () => <span style={`background:${color};`} className="color-indicator text">A</span>,
                    { key: "piwind-more-bbcode.forum.color.label", params: { color: color } },
                    bbcode(`[color=${color}]`));
            });
        }, 2
    )
    //BackGround
    tags.group(priority(), "background",
        () => <i className="fas fa-fill-drip" />,
        "piwind-more-bbcode.forum.background.title", (tags) => {
            const colors = [
                "grey", "green", "blue", "purple", "yellow", "orange",
                "red", "silver", "pink", "brown", "white", "black"]
            const priority = prioritySerial(100, 100);
            colors.forEach(color => {
                tags.add(priority(), "background-" + color,
                    () => <span style={`background:${color};`} className="color-indicator back"></span>,
                    { key: "piwind-more-bbcode.forum.background.label", params: { color: color } },
                    bbcode(`[background=${color}]`));
            });
        }, 2
    )
    //Sign
    tags.group(priority(), "sign",
        "fas fa-superscript",
        "piwind-more-bbcode.forum.sign.title", (tags) => {
            const priority = prioritySerial(100, 100);
            //Superscript
            tags.add(priority(), "superscript",
                "fas fa-superscript",
                "piwind-more-bbcode.forum.sign.superscript",
                bbcode("[sup]"));
            //Subscript
            tags.add(priority(), "subscript",
                "fas fa-subscript",
                "piwind-more-bbcode.forum.sign.subscript",
                bbcode("[sub]"));
            //Acronym
            tags.add(priority(), "acronym",
                "fas fa-question-circle",
                "piwind-more-bbcode.forum.sign.acronym",
                bbcode(`[acronym title=\"${common("title")}\"] ${common("describe")}`));
        }
    )
}