<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/blaze.css">
        <link rel="stylesheet" href="css/taab.css">
    </head>
    <body class="c-text">
        <main id="taab-coincoin" class="o-container o-container--large u-pillar-box--small">
            <form class="c-input-group" v-on:submit.prevent="post" accept-charset="UTF-8" autofocus>
                <div class="o-field">
                    <input v-model="message" ref="message" name="message" class="c-field">
                </div>
                <button type="submit" class="c-button c-button--info">Post</button>
            </form>
            <template v-for="post of posts">
                <article v-bind:id="post.id">
                    <time v-bind:title="post.time" v-on:click.prevent="norlogeClicked">{{ post.time.substr(11) }}</time>
                    <cite v-bind:title="post.info">{{ post.login || post.info }}</cite>
                    <p v-html="post.message"></p>
                </article>
            </template>
        </main>
        <script src="js/vue.js" defer></script>
        <script src="js/taab-backend2html.js" defer></script>
        <script src="js/taab.js" defer></script>
    </body>
</html>
