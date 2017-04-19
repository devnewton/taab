<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/blaze.css">
        <link rel="stylesheet" href="css/taab.css">
    </head>
    <body class="c-text">
        <main id="taab-coincoin" class="o-container o-container--large u-pillar-box--small" v-on:click="clicked" v-on:mouseover="mouseEntered" v-on:mouseout="mouseLeaved">
            <form class="c-input-group" v-on:submit.prevent="post" accept-charset="UTF-8" autofocus>
                <div class="o-field">
                    <input v-model="message" ref="message" name="message" placeholder="message or command (/nick)" class="c-field" spellcheck="true">
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
        <footer class="o-container o-container--xsmall u-pillar-box--xsmall u-xsmall">Discussion powered by <a href="https://github.com/devnewton/taab">taab</a></footer>
        <script src="js/vue.js" defer></script>
        <script src="js/taab-backend2html.js" defer></script>
        <script src="js/taab.js" defer></script>
    </body>
</html>
