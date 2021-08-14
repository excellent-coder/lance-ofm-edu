const requiredFilled = (element, id = false) => {
    let requiredFields = [];

    if (id) {
        element = $('#' + id);
    }
    // validate all fields with required
    $(element).find(".required").each(function (item, index) {
        let value = $(this).val();
        let type = typeof (value);

        if (value === null || type == 'string' && !value.trim().length || type=='object' && !value.length) {
            // Get the offset of the first required field
            requiredFields.push($(this).offset().top);

            // Add a class of invalid to the field with required if its empty
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");

            // Add event listner to make it change
            // to is valid class if user has fill up the required field
            $(this).on("change keyup", function () {
                if ($(this).val().length) {
                    $(this).addClass("is-valid");
                    $(this).removeClass("is-invalid");
                } else {
                    $(this).addClass("is-invalid");
                    $(this).removeClass("is-valid");
                }
            });
        }
    });

    // Check if all required fields are filled up
    if (requiredFields.length > 0) {
        $("html").stop()
            .animate({
                    scrollTop: requiredFields[0] - 200
                },
                1000,
                "swing",
                function () {
                    notify(
                        { title: 'Some required fields are mising' },
                        { type: 'danger', timeout:4000});
                });
        return false;
    }
    return true;
}

const isLoading = (loading = true) => {
    let preloader = document.getElementById("preloader");
    if (!preloader) {
        return;
    }
    if (loading) {
        preloader.style.display = 'block';
    } else {
        preloader.style.display = 'none';
    }
}

const handleModal = (id, show) => {
    // hide all other open modals

    let modals = document.querySelectorAll('.main-modal');

    // console.log([id, show]);

    let modal = document.getElementById(id);
    let newClass = "fadeIn";
    let oldClass = "fadeout";
    if (show) {
        modal.classList.remove(oldClass);
        modal.classList.add(newClass);

        modals.forEach(item => {
            if (item.id != id) {
                item.classList.add('fadeout');
            }
        })
        return;
    }
    modal.classList.remove(newClass);
    modal.classList.add(oldClass);
    return;
}

export {
    requiredFilled,
    isLoading,
    handleModal
}
