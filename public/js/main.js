const App = {
    headers: {
        'Content-Type': 'application/json'
    },

    observer: function () {
        let scene = jQuery('.scene');
        let cube  = jQuery('.scene .cube');

        jQuery(document).ready(function () {
            jQuery('#scene-settings input').each(function (index, item) {
                let val = jQuery(item).val();
                let css = jQuery(item).prop('id');

                if (jQuery(item).data('ident') === 'scene') {
                    scene.css(css, val);
                    return true;
                }

                cube.css(css, val);
            });
        });

        jQuery('#scene-settings input').bind('change keyup', function (el) {
             let val = jQuery(el.target).val();
             let css = jQuery(el.target).prop('id');

             if (jQuery(el.target).data('ident') === 'scene') {
                 scene.css(css, val);
                 localStorage.setItem(css, val);

                 return true;
             }

             cube.css(css, val);

             localStorage.setItem(css, val);
        });
    },

    start: async function (el) {
        this.moving();
        jQuery(el).prop('disabled', true);
        jQuery('#stop').prop('disabled', false);


        let settingScene = this.getSceneSettings();

        for (let key in settingScene) {
            if (!settingScene.hasOwnProperty(key)) {
                continue;
            }

            let setting = settingScene[key];

            jQuery('.game-scene').css(key, setting);
        }

        let settingsCube = this.getSettingsCube();
        for (let key in settingsCube) {
            if (!settingsCube.hasOwnProperty(key)) {
                continue;
            }

            let setting = settingsCube[key];

            jQuery('.game-scene .cube').css(key, setting);
        }

        //this.doDisplayQuestion();
    },

    moving: function () {
        let start = Date.now();
        let time  = localStorage.getItem('time');
        time = parseInt(time.replace(':', '')) * 1000;

        let radius = jQuery('.game-scene').height() / 2 - 50;
        let width  = jQuery('.game-scene').width() / 2 - 50;

        let speed = localStorage.getItem('speed');

        let $ = {
            radius: radius,
            speed: 20
        };

        let circle = this.getRandomInt(180, 360);

        let f = 0;
        let s = speed * Math.PI / circle;

        let timer = setInterval(function() {
            let timePassed = Date.now() - start;
            let timeOut = Math.ceil((time - timePassed) / 1000);

            if (timeOut < 60) {
                timeOut = '00.' + timeOut;
            }

            if (timeOut > 60) {
                timeOut = (timeOut / 60).toFixed(2);
            }

            timeOut = timeOut.replace('.', ':');

            jQuery('#game-time').html(timeOut);

            f += s;

            if (timePassed >= time) {
                clearInterval(timer);
                return;
            }

            jQuery('.game-scene>.cube').css('left', width + width * Math.sin(f) + 'px');
            jQuery('.game-scene>.cube').css('top', radius + $.radius * Math.cos(f) + 'px');

        }, $.speed)
    },

    doDisplayQuestion: function () {
        setInterval(() => {
            let question  = this.getQuestion();
            let answer = parseInt(this.getAnswer(question));
            jQuery('.question').html('<h3>' + question + '</h3>');
            jQuery('.answer').html('<h3>' + answer + '</h3>');
        }, 3000);
    },

    getAnswer: function (question) {
        let symbol = {
            '9': '-',
            '10': '+'
        };

        return parseInt(question) + symbol[this.getRandomInt(9, 11)] + parseInt(this.getRandomInt(0, 20));
    },

    getQuestion: function () {
        let symbol = {
            '9': '-',
            '10': '+'
        };

        return this.getRandomInt(0, 10) + symbol[this.getRandomInt(9, 11)] + this.getRandomInt(0, 10);
    },

    getRandomInt: function (min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
    },

    getSettingsCube: function () {
        let settings = {
            'border-color': localStorage.getItem('border-color'),
            'border-width': localStorage.getItem('border-width'),
            'height': localStorage.getItem('height'),
            'width': localStorage.getItem('width'),
        };

        return settings;
    },

    getSceneSettings: function () {
        let settings = {
            'background': localStorage.getItem('background-color'),
            'color': localStorage.getItem('color')
        };

        return settings;
    },

    addTask: function () {
        let data = this.getFormObj('form-addTask');
        this.post('tasks/add', data).then((res) => {
            if (res.hasOwnProperty('error') && res.error === true) {
                jQuery('#addTask .alert').addClass('alert-danger').addClass('show');
                jQuery('#addTask .modal-error').html(res.message);
                return false;
            }

            jQuery('#addTask .alert').addClass('alert-success').addClass('show');
            jQuery('#addTask .modal-error').html(res.message);

            setTimeout(function () {
                document.location.reload(true);
            }, 200)
        });
    },

    getFormObj: function (formId) {
        let formObj = {};
        let inputs = jQuery('#'+formId).serializeArray();

        jQuery.each(inputs, function (i, input) {
            formObj[input.name] = input.value;
        });

        return formObj;
    },

    post: async function (url = '', data = {}) {
        const response = await fetch(url, {
            method: 'POST',
            headers: this.headers,
            body: JSON.stringify(data)
        });

        return await response.json();
    },
}