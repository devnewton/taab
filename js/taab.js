document.addEventListener('DOMContentLoaded', function () {

    var taab_backend2html = peg.generate(document.getElementById("taab-backend2html").textContent);

    new Vue({
        el: '#taab-coincoin',
        data: {
            message: "",
            posts: []
        },
        methods: {
            post: function (e) {
                if (this.handleCommand()) {
                    this.message = "";
                } else {
                    var self = this;
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                self.parseBackendResponse(xhr.responseText);
                                self.message = "";
                            }
                        }
                    };
                    xhr.open("POST", "post.php");
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    var params = "message=" + encodeURIComponent(this.message).replace(/%20/g, '+');
                    var login = localStorage.login;
                    if (login) {
                        params += "&login=" + encodeURIComponent(login).replace(/%20/g, '+');
                    }
                    params += "&lastId=" + self.getLastId();
                    xhr.send(params);
                }
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
                xhr.open("GET", "get.php?lastId=" + encodeURIComponent(self.getLastId()));
                xhr.send();
            },
            handleCommand: function () {
                return this.handleCommandNick();
            },
            handleCommandNick: function () {
                var result = /\/nick (.*)/.exec(this.message);
                if (result && result.length === 2) {
                    localStorage.login = result[1];
                    return true;
                } else {
                    return false;
                }
            },
            clicked: function (e) {
                switch (e.target.tagName) {
                    case 'TIME':
                        if (e.target.title) {
                            this.message += e.target.title + " ";
                            this.$refs.message.focus();
                        }
                        break;
                    case 'CITE':
                        if (e.target.innerText) {
                            this.message += e.target.innerText + "< ";
                            this.$refs.message.focus();
                        }
                        break;
                    case 'MARK':
                        e.target.classList.toggle('revealed-spoiler');
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
                var newPosts = responseText.split(/\r\n|\n/).map(function (line) {
                    var post = line.split(/\t/);
                    if (post.length >= 5) {
                        var time = post[1];
                        var formattedTime = time.substr(0, 4) + "-" + time.substr(4, 2) + "-" + time.substr(6, 2) + "T" + time.substr(8, 2) + ":" + time.substr(10, 2) + ":" + time.substr(12, 2);
                        var htmlMessage = taab_backend2html.parse(post[4]);
                        return {id: post[0], time: formattedTime, info: post[2], login: post[3], message: htmlMessage};
                    } else {
                        return false;
                    }
                }).filter(function (post) {
                    return post && post.id && post.time && post.message;
                }).concat(this.posts);
                this.posts = newPosts.sort(function (a, b) {
                    return b.id - a.id;
                }).filter(function (elem, pos) {
                    return newPosts.indexOf(elem) === pos;
                });
            },
            getLastId: function () {
                return this.posts.reduce(function (acc, val) {
                    return Math.max(acc, val.id);
                }, 0);
            }
        },
        mounted: function () {
            var self = this;
            self.get();
            setInterval(function () {
                self.get();
            }, 30000);
        }
    });

});