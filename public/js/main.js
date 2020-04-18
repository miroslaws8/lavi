const App = {
    headers: {
        'Content-Type': 'application/json'
    },

    observer: function () {
        let scene = jQuery('.scene');
        let cube  = jQuery('.scene .cube');

        jQuery('#scene-settings input').change(function (el) {
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

            console.log(w);
            let x = ev.clientX - parentOffset.left - w/2;
            let y = ev.clientY - parentOffset.top - h/2;

            jQuery('.game-scene>.cube').css('top', y);
            jQuery('.game-scene>.cube').css('left', x);
        });
    },

    start: async function () {
        let tick  = 1;
        let timer = setInterval(function () {
            jQuery('.start-game').html('<h3>' + tick + '</h3>');
            tick++;
            if (tick > 3) {
                jQuery('.start-game').remove();
                jQuery('.game-scene').show();
                clearInterval(timer);
            }
        }, 1000);

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
            let question = this.getRandomInt(0, 10) + '+' + this.getRandomInt(0, 10);
            jQuery('.question').css('top', '20');
            jQuery('.question').css('left', '20');
            jQuery('.question').html('<h3>' + question + '</h3>');
        }, 3000);
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