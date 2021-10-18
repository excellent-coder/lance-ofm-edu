const toggleDisabled = (eleClass)=> {
    // console.log('i have started');
    var input = document.querySelectorAll(eleClass);
    if (input[0].hasAttribute('disabled')) {
        // console.log('removing disabled');
        input.forEach(el => {
            el.removeAttribute('disabled');
        })
    } else {
        // console.log('adding disbaled')
        input.forEach(el => {
            el.setAttribute('disabled', true);
        })

    }
}

const oldValues = (form)=>{
    $(form).find('.form-control').each((index, item) => {
        let e = $(item);
        if (e.data('value') !== undefined) {
            $(e).val(e.data('value'));
        } else {
            $(e).val('');
        }
        if (e.hasClass('select2')) {
            e.trigger('change');
        }
        if (e.data('checked')) {
            item.checked = true;
        }
    })

    $(form).find('input[type=checkbox]').each((index, item) => {
        let e = $(item);
        if (e.data('checked')) {
            item.checked = true;
        }
    })
}

const totalSelected= ()=>{
    let checked = 0;
    let checking = document.querySelectorAll('.checking');
    let display = document.querySelectorAll('.total-selected');
    let bulkActions = document.querySelectorAll('.bulk-action');
    let bulkIds = '';

    checking.forEach(checkbox => {
        if (checkbox.checked) {
            bulkIds += checkbox.value + ',';
            checked++;
        }
    });

    display.forEach(e => {
        e.textContent = checked;
    });

    bulkActions.forEach(b => {
        b.dataset.id = bulkIds;
    })

  return checked;
}

export {toggleDisabled, oldValues, totalSelected}
