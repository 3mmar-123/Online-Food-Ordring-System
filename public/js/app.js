function formControlsSetUp() {
    $('.form-control').each(function(elem){
        if($(this).is('input[type="date"]')) {
            $(this).addClass('active')
            return;
        }
        if(this.value !== ''){
            $(this).addClass('active')
        }
        else {
            $(this).removeClass('active')

        }
        $(this).on('change', function(val,value){
            console.log(this.value);
            if(this.value !== ''){
                $(this).addClass('active')
            }
            else {
                $(this).removeClass('active')
            }
            if(this.classList.contains('is-invalid'))
                this.classList.remove('is-invalid');

        });
    })

}
formControlsSetUp()
function createRipple(event) {
    const button = event.currentTarget;

    const circle = document.createElement("span");
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
    circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
    circle.classList.add("ripple");

    const ripple = button.getElementsByClassName("ripple")[0];

    if (ripple) {
        ripple.remove();
    }

    button.appendChild(circle);
}

const buttons = document.querySelectorAll("*[data-mdb-ripple-init]");
for (const button of buttons) {

    button.addEventListener("click", createRipple);
}





function showConfirmAlert(url,csrf=null, callback=null, entryId=null, tableId=null, message = 'هل أنت متأكد من رغبتك في الحذف؟') {
    message =message|| 'هل أنت متأكد من رغبتك في الحذف؟';
    const modalContainer = document.createElement('div');
    modalContainer.classList.add('confirmation-modal-container');
    const confirmationAlert = document.createElement('div');
    confirmationAlert.classList.add('confirmation-alert');
    confirmationAlert.classList.add('fadeIn');
    confirmationAlert.innerHTML = `
    <h2>رسالة تأكيد قبل الحذف<br>✉️</h2>
    <p> <b>${message}</b> </p>
    <button id="main-alert-confirm" class="btn btn-danger">تأكيد✅</button>
    <button id="main-alert-cancel"  class="btn btn-dark" >إلغاء❌</button>
  `;

    modalContainer.appendChild(confirmationAlert);
    document.body.appendChild(modalContainer);
    $(confirmationAlert).focus();
    modalContainer.classList.add('visible');

    document.getElementById('main-alert-confirm').addEventListener('click', function () {
        closeModal();
        if( url ) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data:{_token:document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
                success: function (responseData) {

                    console.log(responseData);
                    showToast(responseData.status || 'نجح', responseData.message || 'updating successes')
                   if(responseData.reload){
                       location.reload();
                   }
                   else if(responseData.route){
                       //The responseData has a session messages how send the session messages with new route
                       sessionStorage.setItem(responseData.status, responseData.message);
                       location.href=responseData.route;

                   }

                    if (responseData.error||responseData.status=="error") {
                        console.error('errors', responseData);
                        showError(`<p>*${responseData.message || responseData.responseJSON?.message}<br/> ${responseData.error?.xdebug_message || responseData.responseText}`);
                    }
                    if (responseData.errors) {
                        const errors = responseData.errors;
                        for (const fieldName in errors) {
                            showError(`<p>*${fieldName}: ${errors[fieldName]} </p><br/>`);
                        }

                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Request failed:', jqXHR, textStatus, errorThrown);
                    showToast('فشل', jqXHR.message || jqXHR.responseJSON?.message || jqXHR.responseText || 'deleting failed');
                    showError(jqXHR.responseText || jqXHR.message || jqXHR);
                }
            });
        }else if(typeof callback == 'function'){
        }
    });
    document.getElementById('main-alert-cancel').addEventListener('click', closeModal);

    function closeModal() {
        modalContainer.classList.remove('visible');
        confirmationAlert.classList.remove('fadeIn');
        confirmationAlert.classList.add('fadeOut');
        setTimeout(() => {
            document.body.removeChild(modalContainer);
        }, 900);
    }
}


function showError(data) {
    let error_container = document.getElementById('errors-container');
    let start = '<br/>'+error_container.innerHTML;
    error_container.innerHTML = data+start;

    // if (error_container.firstElementChild) {
    //     $(error_container.firstChild).before(data);
    // } else {
    //     error_container.innerHTML = data;
    // }
    // $('#errors-container').append(data);
    // mainModal.show()
}
function clearErrorsContainer() {
    // showError('new data<br/>');
    $('#errors-container').html('');

    // mainModal.show()
}

function showToast(type, message, duration = 5000) {
    var toast = document.createElement('div'); // Create a new div element for the toast
    toast.className = 'toast fixed-top-center'; // Set the class name for the fixed top-center toast
    toast.setAttribute('role', 'alert'); // Set the role attribute
    toast.setAttribute('aria-live', 'assertive'); // Set the aria-live attribute
    toast.setAttribute('aria-atomic', 'true'); // Set the aria-atomic attribute

    // Create the header element with the app name, timestamp, and dynamic close button
    var toastHeader = document.createElement('div');
    toastHeader.className = 'toast-header';

    var appName = document.createElement('strong');
    appName.className = 'me-auto';
    appName.innerText = 'MADD';
    toastHeader.appendChild(appName);

    var timestamp = document.createElement('small');
    timestamp.className = 'text-muted';
    timestamp.innerText = 'just now';
    toastHeader.appendChild(timestamp);

    var closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.className = 'btn-close';
    closeButton.setAttribute('data-bs-dismiss', 'toast');
    closeButton.setAttribute('aria-label', 'Close');
    toastHeader.appendChild(closeButton);

    toast.appendChild(toastHeader); // Add the header element to the toast

    // Create the body element with the toast message and progress bar
    var toastBody = document.createElement('div');
    toastBody.className = 'toast-body';
    toastBody.innerText = message;
    if (type === 'success') {
        toastHeader.classList.add('bg-success', 'text-white');
        toastBody.innerText = message;
    } else if (type === 'error') {
        toastHeader.classList.add('bg-danger', 'text-white');
        toastBody.innerText = message;
    } else if (type === 'warning') {
        toastHeader.classList.add('bg-warning', 'text-dark');
        toastBody.innerText = message;
    } else {
        toastHeader.classList.add('bg-info', 'text-white');
        toastBody.innerText = message;
    }
    var progressBar = document.createElement('div');
    progressBar.className = 'progress';
    progressBar.style.height = '4px';
    var progressBarIndicator = document.createElement('div');
    progressBarIndicator.className = 'progress-bar';
    progressBarIndicator.setAttribute('role', 'progressbar');
    progressBarIndicator.setAttribute('aria-valuemin', '0');
    progressBarIndicator.setAttribute('aria-valuemax', '100');
    progressBarIndicator.setAttribute('aria-valuenow', '0');
    progressBarIndicator.style.width = '0%';

    progressBar.appendChild(progressBarIndicator);
    toastBody.appendChild(progressBar);

    toast.appendChild(toastBody); // Add the body element to the toast
    document.body.appendChild(toast); // Add the toast to the body of the page

    var myToast = new bootstrap.Toast(toast); // Create a new Toast instance

    myToast.show(); // Show the toast
    toast.classList.add('slide-down');


    // Update the progress bar every 100ms until it reaches 100%
    var intervalId = setInterval(function () {
        var progressBarIndicator = toast.querySelector('.progress-bar');
        var currentValue = parseInt(progressBarIndicator.getAttribute('aria-valuenow'));
        if (currentValue < 100) {
            progressBarIndicator.setAttribute('aria-valuenow', currentValue + 10);
            progressBarIndicator.style.width = (currentValue + 10) + '%';
        } else {
            clearInterval(intervalId);
        }
    }, duration / 10);

    // Remove the toast and clear the interval when it is hidden
    let toasts = $('.toast-fixed-container');
    if (!toasts.length) {
        toasts = $(document.createElement('div'));
        toasts.addClass('toast-fixed-container');
        $('body').append(toasts);
    }
    toasts.append(toast)
    var myToast = new bootstrap.Toast(toast); // Create a new Toast instance
    toast.classList.add('slide-down');
    myToast.show(); // Show the toast

    // Update the progress bar every 100ms until it reaches 100%
    var intervalId = setInterval(function () {
        var progressBarIndicator = toast.querySelector('.progress-bar');
        var currentValue = parseInt(progressBarIndicator.getAttribute('aria-valuenow'));
        if (currentValue < 100) {
            progressBarIndicator.setAttribute('aria-valuenow', currentValue + 10);
            progressBarIndicator.style.width = (currentValue + 10) + '%';
        } else {
            clearInterval(intervalId);
        }
    }, duration / 10);
    // Remove the toast and clear the interval when it is hidden
    toast.addEventListener('hidden.bs.toast', function () {
        toast.remove();
        if (!toasts.length)
            toasts.remove();
        clearInterval(intervalId);
    });

    // Add a nice animation to the toast when it is shown and hidden
    setTimeout(function () {
        toast.classList.remove('slide-down');
        toast.classList.add('slide-up');
        toast.remove();
        if (!toasts.length)
            toasts.remove();
    }, duration - 500);
}


