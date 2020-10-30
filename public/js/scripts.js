// Wait for document loaded (in jQuery)
$(document).ready(function () {
    var simplemde = new SimpleMDE({element: document.getElementById("post_text")});
    $(document).on('click', '.upload-area', function (e){
        $(this).siblings('input').trigger('click');
    });
    $('[data-toggle="datepicker"]').flatpickr({dateFormat:'m/d/Y H:i', enableTime: true});
});


function readUrl(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.addEventListener('load', () => {
            let imgName = input.files[0].name;
            $(input).siblings('.upload-area').html("<a>"+imgName+"</a>");
        });

        reader.readAsDataURL(input.files[0]);
    }
}

let selectInputs = document.querySelectorAll('.selectInput');
let buttonClose = document.querySelectorAll('.buttonClose');

buttonClose.forEach(function (e) {
    e.addEventListener('click', close);
});

selectInputs.forEach(function (e) {
    e.addEventListener('click', selector);
})

function selector(e) {
    let permissionDisplay = e.target.classList.add('d-none');
    let selector = e.target.nextSibling.nextSibling.classList.remove('d-none');
}

function close(e) {
    let displayPermission = e.target.parentNode.parentNode.parentNode.parentNode.parentNode.childNodes[1];
    let removeSelectOptions = e.target.parentNode.parentNode.parentNode.parentNode;

    displayPermission.classList.remove('d-none');
    removeSelectOptions.classList.add('d-none');
}