<?php include_once "config.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>taab</title>
        <link rel="stylesheet" href="css/blaze.css">
        <link rel="stylesheet" href="css/taab.css">
    </head>
    <body class="c-text">
        <div id="taab-app">
            <taab-coincoin></taab-coincoin>
        </div>
        <template id="taab-coincoin">
            <main class="o-container o-container--super u-window-box--tiny" v-on:click="clicked" v-on:mouseover="mouseEntered" v-on:mouseout="mouseLeaved">
                <form class="c-input-group" v-on:submit.prevent="post" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded" autofocus>
                    <div v-if="room" class="c-button">#{{ room }}</div>
                    <div class="o-field">
                        <input v-model="message" ref="message" name="message" placeholder="message or command (/nick, /join)" class="c-field" spellcheck="true">
                    </div>
                    <button type="submit" class="c-button c-button--info">Post</button>
                </form>
                <transition-group name="posts" tag="div">
                    <template v-for="post of posts">
                        <article v-bind:key="post.id">
                            <time v-bind:title="post.time">{{ post.time.substr(11) }}</time>
                            <cite v-bind:title="post.info">{{ post.login || post.info }}</cite>
                            <p v-html="post.message"></p>
                        </article>
                    </template>
                </transition-group>
            </main>
        </template>
        <footer class="o-container o-container--xsmall u-pillar-box--xsmall u-xsmall">Discussion powered by <a href="https://github.com/devnewton/taab">taab</a></footer>
        <?php if (TAAB_DEV): ?>
            <script src="js/vue-dev.js" defer></script>
        <?php else: ?>
            <script src="js/vue.js" defer></script>
        <?php endif; ?>
        <script src="js/peg-0.10.0.js" defer></script>
        <script id="taab-backend2html" type="text/peg">
            <?php readfile("peg/backend2html.pegjs") ?>
        </script>
        <script src="js/taab.js" defer></script>
    </body>
</html>
