const App = {
    headers: {
        'Content-Type': 'application/json'
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