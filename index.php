<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/blaze.css">
    </head>
    <body class="c-text">
        <main id="taab-coincoin" class="o-container o-container--large u-pillar-box--small">
            <form class="c-input-group" v-on:submit.prevent="post" accept-charset="UTF-8">
                <div class="o-field">
                    <input name="message" class="c-field">
                </div>
                <button type="submit" class="c-button c-button--info">Post</button>
            </form>
            <template v-for="post of posts">
                <div v-bind:id="post.id" class="taab-post" >
                    <span class="taab-post-time">{{ post.time }}</span>
                    <span class="taab-post-nickname" v-bind:title="post.info">{{ post.login || post.info }}</span>
                    <span class="taab-post-message">{{ post.message}}</span>
                </div>
            </template>
        </main>
        <script src="js/vue.js" defer></script>
        <script src="js/taab.js" defer></script>
    </body>
</html>
