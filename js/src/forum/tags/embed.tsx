import app from "flarum/forum/app";
import TagCollector, { StyleArgs } from "../helper/tagCollector";
import { prioritySerial } from "../utils/nodeUtil";
import cloudPreviewModal from "../components/cloudPreviewModal";
import { bbcode, prefix } from "../utils/styleUtil";
import common from "../utils/commonReplaceUtil";

export default function addEmbedTags(tags: TagCollector, priority: () => number) {
    tags.group(priority(), "embed",
        "fas fa-sitemap",
        "xypp-more-bbcode.forum.embed.title",
        (tags) => {
            const priority = prioritySerial(100, 100);
            //Cloud
            tags.add(priority(), "cloud",
                "fas fa-cloud",
                "xypp-more-bbcode.forum.embed.cloud",
                makeCloud
            );
            //Down
            tags.add(priority(), "down",
                "fas fa-download",
                "xypp-more-bbcode.forum.embed.down",
                prefix(`[down link="${common("url")}" size="${common("size")}" name="${common("file")}"]`)
            );
            //Audio
            tags.add(priority(), "audio",
                "fas fa-file-audio",
                "xypp-more-bbcode.forum.embed.audio",
                prefix(`[audio mp3="${common("url")}"]`)
            );
            //Clip
            tags.add(priority(), "clip",
                "fas fa-file-video",
                "xypp-more-bbcode.forum.embed.clip",
                prefix(`[clip mp4="${common("url")}"]`)
            );


        }
    );

}
function makeCloud() {
    return new Promise<Partial<StyleArgs>>((resolve, reject) => {
        app.modal.show(cloudPreviewModal, {
            onsubmit: resolve,
            oncancel: reject
        });
    })
}
