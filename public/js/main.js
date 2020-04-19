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

        jQuery('.game-scene').mousemove(function (ev) {
            let parentOffset = jQuery('.game-scene').parent().offset();

            let w =  jQuery('.game-scene>.cube').width();
            let h =  jQuery('.game-scene>.cube').height();

            let x = ev.clientX - parentOffset.left - w/2;
            let y = ev.clientY - parentOffset.top - h - 30;

            jQuery('.game-scene>.cube').css('top', y);
            jQuery('.game-scene>.cube').css('left', x);
        });
    },

    start: async function (el) {
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

        this.doDisplayQuestion();
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