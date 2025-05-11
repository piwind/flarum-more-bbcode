
import CommentPost from "flarum/forum/components/CommentPost";
import DiscussionPage from "flarum/forum/components/DiscussionPage";
import DiscussionControls from "flarum/forum/utils/DiscussionControls";
import LogInModal from "flarum/forum/components/LogInModal";
import TagCollector from "../helper/tagCollector";
import { prioritySerial } from "../utils/nodeUtil";
import { bbcode } from "../utils/styleUtil";
import app from "flarum/forum/app";
import { extend } from "flarum/common/extend";
import Alert from "flarum/common/components/Alert";
import setRouteWithForcedRefresh from "flarum/common/utils/setRouteWithForcedRefresh";


export function addXX2SeeTags(tags: TagCollector, priority: () => number) {
    //xx2see
    tags.group(priority(), "xx2see",
        "fas fa-eye",
        "piwind-more-bbcode.forum.xx2see.title", (tags) => {
            const priority = prioritySerial(100, 100);
            //Login 2 See
            tags.add(priority(), "login2see",
                "fas fa-user",
                "piwind-more-bbcode.forum.xx2see.login.title",
                bbcode("[login]")
            );

            //Reply 2 See
            tags.add(priority(), "reply2see",
                "fas fa-reply",
                "piwind-more-bbcode.forum.xx2see.reply.title",
                bbcode("[reply]")
            );

            //Like 2 See
            tags.add(priority(), "like2see",
                "fas fa-heart",
                "piwind-more-bbcode.forum.xx2see.like.title",
                bbcode("[like]")
            );
        }
    );


    extend(CommentPost.prototype, "content", function () {
        if (app.session.user && app.current.matches(DiscussionPage)) {
            $(".reply2see_reply")
                .off("click")
                .on("click", () =>
                    DiscussionControls.replyAction.call(
                        app.current.get("discussion"),
                        true,
                        false
                    )
                );
        } else {
            $(".reply2see_reply")
                .off("click")
                .on("click", () => app.modal.show(LogInModal));
            $(".login2see_login")
                .off("click")
                .on("click", () => app.modal.show(LogInModal));
        }
    });
}