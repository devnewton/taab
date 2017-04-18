var taab_coincoin = new Vue({
    el: '#taab-coincoin',
    data: {
        posts: [
            {id: 2, time: 20170414131127, login: "dave", info: "ff", message: "nan dsl"},
            {id: 1, time: 20170414131127, login: "euro", info: "ie", message: "plop"}
        ]
    },
    methods: {
        post: function (e) {
            var self = this;
            var form = e.target;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        form.reset();
                        self.parseBackendResponse(xhr.responseText);
                    }
                }
            };
            var body = new FormData(form);
            xhr.open("POST", "post.php");
            xhr.send(body);
        },
        parseBackendResponse: function (responseText) {
            this.posts = responseText.split(/\r\n|\n/).map(function (line) {
                var post = line.split(/\t/);
                return {id: post[0], time: post[1], login: post[2], info: post[3], message: post[4]};
            });
        }
    },
    mounted: function () {
        var self = this;
        setInterval(function () {
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
        }, 5000);
    }
});