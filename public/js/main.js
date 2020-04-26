const App = {
    mover: null,
    cancel: false,
    stopped: false,
    time: null,
    timer: null,
    headers: {
        'Content-Type': 'application/json'
    },

    observer: function () {
        this.observeKeydown();
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

    observeKeydown() {
        jQuery(document).keydown((event) => {
            if (event.code === 'Space') {
                if (this.stopped === false) {
                    this.stop();
                    this.stopped = true;
                    return true;
                }

                this.start(document.getElementById('start'));
                this.stopped = false;
                return true;
            }

            if (event.code === 'Escape') {
                window.location = '/settings'
                return true;
            }
        });
    },

    start: async function (el) {
        if (this.cancel === false) {
            this.time = parseInt(localStorage.getItem('time').replace(':', '')) * 1000;
        }

        this.setMover();
        this.mover.start();
        this.startTimer();

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

    startTimer: function() {
        this.timer = setInterval(() => {
            this.doDisplayQuestion();
            this.time = this.time - 1000;

            let htmlTime = this.time / 1000;

            document.getElementById('game-time').innerHTML = this.getHtmlTime(htmlTime);

            if (this.time <= 0) {
                this.cancel = true;
                this.stop();
                return true;
            }
        }, 1000);
    },

    getHtmlTime: function(time) {
        return time.toString().padStart(4, "0").replace(/(\d{1,2}(?=(?:\d\d)+(?!\d)))/g, "$1" + ':');
    },

    stopTimer: function() {
        if (this.timer === null) {
            return;
        }

        clearInterval(this.timer);
    },

    stop: function (el) {
        this.mover.stop();
        this.stopTimer();

        if (this.cancel === true) {
            this.time = parseInt(localStorage.getItem('time').replace(':', '')) * 1000;
            this.timer = null;

            window.location = '/endgame'
        }

        jQuery(el).prop('disabled', true);
        jQuery('#start').prop('disabled', false);
    },

    setMover: function() {
        if (this.mover !== null) {
            return this.mover;
        }

        this.mover = new Mover(
            document.getElementById('cube'), document.getElementById('game-scene')
        );

        return this.mover;
    },

    doDisplayQuestion: function () {
        let question  = this.getQuestion();
        let answer = parseInt(this.getAnswer(question));
        jQuery('.question').html('<h3>' + question + '</h3>');
        jQuery('.answer').html('<h3>' + answer + '</h3>');
    },

    getAnswer: function (question) {
        let symbol = {
            '9': '-',
            '10': '+'
        };

        return parseInt(question) + parseInt(this.getRandomInt(-20, 20));
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

class Mover {
    constructor(obj, container) {
        this.$object = obj;
        this.$container = container;
        this.container_is_window = container === window;
        this.pixels_per_second = 250;
        this.current_position = { x: 0, y: 0 };
        this.is_running = false;
    }

    _getContainerDimensions() {
        if (this.$container === window) {
            return {
                'height' : this.$container.innerHeight,
                'width' : this.$container.innerWidth
            };
        } else {
            return {
                'height' : this.$container.clientHeight - this.$object.clientHeight,
                'width' : this.$container.clientWidth - this.$object.clientWidth
            };
        }
    }

    _generateNewPosition() {
        // Get container dimensions minus div size
        let containerSize = this._getContainerDimensions();
        let availableHeight = containerSize.height - this.$object.clientHeight;
        let availableWidth = containerSize.width - this.$object.clientHeight;

        // Pick a random place in the space
        let y = Math.floor(Math.random() * availableHeight);
        let x = Math.floor(Math.random() * availableWidth);

        return { x: x, y: y };
    }

    _calcDelta(a, b) {
        let dx   = a.x - b.x;
        let dy   = a.y - b.y;
        let dist = Math.sqrt( dx*dx + dy*dy );

        return dist;
    }

    _moveOnce() {
        // Pick a new spot on the page
        let next = this._generateNewPosition();

        // How far do we have to move?
        let delta = this._calcDelta(this.current_position, next);

        // Speed of this transition, rounded to 2DP
        let speed = Math.round((delta / this.pixels_per_second) * 100) / 100;

        this.$object.style.transition='transform '+speed+'s linear';
        this.$object.style.transform='translate3d('+next.x+'px, '+next.y+'px, 0)';

        // Save this new position ready for the next call.
        this.current_position = next;

    };

    start() {
        if (this.is_running) {
            return;
        }

        // Make sure our object has the right css set
        this.$object.willChange = 'transform';
        this.$object.pointerEvents = 'auto';

        this.boundEvent = this._moveOnce.bind(this)

        // Bind callback to keep things moving
        this.$object.addEventListener('transitionend', this.boundEvent);

        // Start it moving
        this._moveOnce();

        this.is_running = true;
    }

    stop() {
        if (!this.is_running) {
            return;
        }

        this.$object.removeEventListener('transitionend', this.boundEvent);

        this.is_running = false;
    }
}