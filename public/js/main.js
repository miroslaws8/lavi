const App = {
    token: null,
    mover: null,
    cancel: false,
    stopped: false,
    settings: null,
    time: null,
    timer: null,
    cursorOut: 0,
    success: [],
    outSide: {top: 0, bottom: 0, left: 0, right: 0},
    headers: {
        'Content-Type': 'application/json',
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

        jQuery('#scene-settings input, #scene-settings select').bind('change keyup', function (el) {
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
        this.observerCube();

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
            this.time = this.time - 1000;

            let htmlTime = this.time / 1000;

            document.getElementById('game-time').innerHTML = this.getHtmlTime(htmlTime);

            if (this.time <= 0) {
                this.cancel = true;
                this.stop();
                return true;
            }
        }, 1000);

        let q = setInterval(() => {
            this.doDisplayQuestion();
            if (this.time <= 0) {
                clearInterval(q);
            }
        }, 30000)
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

            let data = {
                'outside': this.outSide,
                'success': this.success
            };

            this.addEndGame(data);
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
        let question = this.setQuestion();
        let answer   = this.setAnswer();

        jQuery('.question').html('<h3>' + question + '</h3>');
        jQuery('.answer').html('<h3>' + answer + '</h3>');
    },

    setAnswer: function () {
        let x = this.getRandomInt(0, 10);
        let y = this.getRandomInt(-10, 20);

        this.answer = parseInt(x) + parseInt(y);

        return this.answer;
    },

    setQuestion: function () {
        let symbol = {
            '1': '+',
            '2': '-'
        };

        let x = this.getRandomInt(0, 10);
        let y = this.getRandomInt(0, 10);

        this.questHtml = parseInt(x) + symbol[this.getRandomInt(1, 3)] + parseInt(y);
        this.quest = eval(this.questHtml);

        return this.questHtml
    },

    getRandomInt: function (min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
    },

    getSettingsCube: function () {
        let settings = {
            'border-color': this.settings['border-color'],
            'border-width': this.settings['border-width'],
            'height': this.settings['height'],
            'width': this.settings['width'],
        };

        return settings;
    },

    getSceneSettings: function () {
        let settings = {
            'background': this.settings['background'],
            'color': this.settings['color'],
        };

        return settings;
    },

    observerCube: function () {
        const handler = (event) => {
            if (this.stopped === true) {
                return;
            }

            if (event.type === 'mouseover') {
                event.target.style.background = 'pink';
                document.getElementById('game-scene').style.background = localStorage.getItem('background-color');
            }
            if (event.type === 'mouseout') {
                this.setOutSide(event.clientX, event.clientY);
                document.getElementById('cursorError').innerHTML = this.cursorOut;
                event.target.style.background = '';
                document.getElementById('game-scene').style.background = localStorage.getItem('background-color-error');
            }
        };

        let cube = document.getElementById('cube');
        cube.onmouseover = cube.onmouseout = handler;

        const handlerClick = (event) => {
            if (this.stopped === true) {
                return;
            }
            let res = this.spaceship(this.answer, this.quest);

            if (event.which === 1 && res === 1) {
                this.success.push('true');
            } else if (event.which === 2 && res === 0) {
                this.success.push('true');
            } else if (event.which === 3 && res === -1) {
                this.success.push('true');
            } else {
                this.success.push('false');
            }

            this.doDisplayQuestion();
        };

        document.oncontextmenu = () => false;
        document.getElementById('game-scene').onmousedown = handlerClick;
    },

    setOutSide: function(mouseX, mouseY) {
        this.cursorOut++;

        let cube = document.getElementById('cube');
        let coords = cube.getBoundingClientRect();

        if (mouseX < coords.left) {
            this.outSide.left++;
            return;
        }

        if (mouseX > coords.left + coords.width) {
            this.outSide.right++;
            return;
        }

        if (mouseY < coords.top) {
            this.outSide.top++;
            return;
        }

        if (mouseY > coords.top + coords.height) {
            this.outSide.bottom++;
            return;
        }
    },

    spaceship: function(a, b) {
        if (a > b) {
            return 1;
        }

        if (a === b) {
            return 0;
        }

        return -1;
    },

    addEndGame: function (data) {
        this.headers['access-token'] = this.token;
        this.post('endgame/add', data).then((res) => {
            if (res.hasOwnProperty('error') && res.error === true) {
                return false;
            }

            console.log(res);

            window.location = `/endgame/${res.id_game}`;
        });
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
        let speed = Math.round((delta / this.pixels_per_second) * 150 ) / 100;

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