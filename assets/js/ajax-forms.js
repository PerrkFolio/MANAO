const ajax_url = ajax.url;
const XHR = new XMLHttpRequest();

let count_exec = 0;

function formSubmited(e) {
    var form = e.target;
    let button_text = '';
    try{
        form.button.disabled = true;
        button_text = form.button.value;
        form.button.value = "Загрузка...";
    }catch(err){
        console.log(err); // при загрузке странице выводится ошибка, проверить
    }

    if (form.hasAttribute('data-ajax')) {
        e.preventDefault();

        var data = new FormData(form); //init request data

        //form nonce
        var wpnonce = form.querySelector('#_wpnonce');
        wpnonce = wpnonce ? wpnonce : document.querySelector('#_wpnonce');
        if (wpnonce) {
            data.append('_wpnonce', wpnonce.value);
        }

        //form action
        if(form.querySelector('input[name="action"]') == null){
            var action = form.getAttribute('data-action');
            if (action == null || action == '') {
                data.append('action', action);
            }
        }

        let xhr = new XMLHttpRequest();

        //sending request
        xhr.addEventListener('load', function(){
            try{
                form.button.value = button_text;
                form.button.disabled = false;
            }catch(err){

            }
            if(xhr.status == 200){
                responseHandler(xhr.response, form);
            }
        });
        xhr.open('POST', ajax_url);
        xhr.send(data);
    }
}

function responseHandler(responseText, form) {
    var response = JSON.parse(responseText);
    var responseData = response.data;
    var message = responseData.message;
    var html = responseData.html;

    //setting message
    if(message != undefined && form.querySelector('.form__info') != null){
        form.querySelector('.form__info').innerHTML = message;
    }
    if (response.success) {
        var successRedirect = form.getAttribute('data-success_redirect');
        var successReload = form.getAttribute('data-success_reload');
        var successEvent = form.getAttribute('data-success_event');

        var successRedirectDelay = form.getAttribute('data-success_delay');
        if (successRedirectDelay == null) {
            successRedirectDelay = 0;
        }

        // html fill container
        var htmlContainer = document.querySelector(form.getAttribute('data-fill'));
        if (htmlContainer != null && html != undefined) {
            console.log('htmlContainer');
            htmlContainer.innerHTML = html;
        }

        //redirect | delay if enabled
        if (successRedirect) {
            setTimeout(() => {
                if (window.location.href != successRedirect) {
                    window.location.href = successRedirect;
                }
            }, successRedirectDelay);
        }

        if(successEvent != null){

            document.dispatchEvent(new CustomEvent(successEvent, {
                detail: responseData
            }));

            return false;
        }

        //reload
        if(successReload != null){
            window.location.reload();
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    //init events
    document.querySelectorAll('form').forEach(el => {
        el.addEventListener("submit", formSubmited);
    });
});

document.addEventListener('DOMSubtreeModified', function () {
    //init events
    document.querySelectorAll('form').forEach(el => {
        el.addEventListener("submit", formSubmited);
    });
});

// jQuery(document).on('submit', 'form', (e) => {
//     console.log('+', e);
//     e.preventDefault();
//     formSubmited(e);
// });