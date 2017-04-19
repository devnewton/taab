var taab_coincoin = new Vue({
    el: '#taab-coincoin',
    data: {
        message: "",
        posts: []
    },
    methods: {
        post: function (e) {
            var self = this;
            var form = e.target;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        self.parseBackendResponse(xhr.responseText);
                        self.message = "";
                    }
                }
            };
            var body = new FormData(form);
            xhr.open("POST", "post.php");
            xhr.send(body);
        },
        get: function () {
            var self = this;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        self.parseBackendResponse(xhr.responseText);
                    }
                }
            };
            xhr.open("GET", "get.php");
            xhr.send();
        },
        clicked: function (e) {
            switch (e.target.tagName) {
                case 'TIME':
                    if (e.target.title) {
                        this.message += e.target.title + " ";
                        this.$refs.message.focus();
                    }
                    break;
            }
        },
        mouseEntered: function (e) {
            switch (e.target.tagName) {
                case 'TIME':
                    if (e.target.title) {
                        var times = document.getElementsByTagName('time');
                        for (var i = 0; i < times.length; i++) {
                            var time = times[i];
                            if (time.title === e.target.title) {
                                time.className = "highlighted";
                            }
                        }
                    }
                    break;
            }
        },
        mouseLeaved: function (e) {
            switch (e.target.tagName) {
                case 'TIME':
                    if (e.target.title) {
                        var times = document.getElementsByTagName('time');
                        for (var i = 0; i < times.length; i++) {
                            var time = times[i];
                            time.className = "";
                        }
                    }
                    break;
            }
        },
        parseBackendResponse: function (responseText) {
            this.posts = responseText.split(/\r\n|\n/).map(function (line) {
                var post = line.split(/\t/);
                if (post.length >= 5) {
                    var time = post[1];
                    var formattedTime = time.substr(0, 4) + "-" + time.substr(4, 2) + "-" + time.substr(6, 2) + "T" + time.substr(8, 2) + ":" + time.substr(10, 2) + ":" + time.substr(12, 2);
                    var htmlMessage = taab_backend2html.parse(post[4]);
                    return {id: post[0], time: formattedTime, login: post[2], info: post[3], message: htmlMessage};
                } else {
                    return false;
                }
            }).filter(function (post) {
                return !!post;
            });
        },
    },
    mounted: function () {
        var self = this;
        self.get();
        setInterval(function () {
            self.get();
        }, 5000);
    }
});