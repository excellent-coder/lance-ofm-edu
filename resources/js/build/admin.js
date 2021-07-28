require('../bootstrap');

import {
    createApp
} from 'vue';

import router from '../routes';
import {
    store
} from '../store/apps/admin';

// impoering componenets
import App from '../components/App.vue';
import MultiSelect from '../npm/vue-multiselect/src';

import {
    isLoading
} from '../utils/validate';
import {
    reactive
} from 'vue';
import axios from 'axios';

const app = createApp({
    data() {
        return {
            files: {}, // for uploading files
            uploading: [], //fils that are being uploaded
            uploadingDone: [], // completed uploads
            uploadIndex: 0,
            file_parent_id: 0,
            validEmail: false,
            redirect_after_file: false,
            cancelToken: axios.CancelToken.source(),

            updateSlug: true,
            slug: '',
            slugTitle: "",
            slug: "",
            imageFile: "",
            hide_modal: false,

            form: {type:'text'},
            // shop categories
            parentShopCats: [],
            shopCats: [],
            products: [],
            // super_cat: {id:1,name:"updated"},
            price: '',
            highPrice: '',
            perDiscount: 0,
        }
    },
    components: {
        MultiSelect
    },
    methods: {
        submit(event, files = []) {
            let form = event.target;
            let url = form.getAttribute('action');

            //validate all required fields
            if (!requiredFilled(form)) {
                return;
            }
            // start loading animation
            isLoading();
            let formData = new FormData(form);

            // upload formdata using axios
            // show upload progress
            axios.post(url, formData).then(res => {
                let data = res.data;

                let type = data.type;
                let title = data.message;
                let description = data.desc;
                let timeout = data.timeout;

                if (data.status == 200) {
                    type = type ? type : 'success';
                    notify({
                        title,
                        description
                    }, {
                        type,
                        timeout
                    });
                    isLoading(false);

                    if (data.parent_id) {
                        this.file_parent_id = data.parent_id;
                    }

                    if (files.length && this.files[files[0]] !== undefined) {
                        notify({
                            title: `Files are being uploaded, please don't leave this page`
                        }, {
                            type: 'info',
                            timeout: 999999
                        });

                        if (data.to) {
                            this.redirect_after_file = data.to;
                        }

                        this.uploading = files;
                        this.uploadFile(files[0], 0);
                        return;
                    }

                    if (type == 'success') {
                        form.reset();
                        oldValues(form);
                        if (Vm.data.hide_modal) {
                            $(Vm.data.hide_modal).modal('hide');
                        }
                    }


                    data.to ? window.location.href = data.to : '';
                    data.reload ? window.location.reload() : ''
                }

                if (data.errors) {
                    let errors;
                    switch (typeof data.errors) {
                        case 'object':
                            errors = Object.values(data.errors);
                            description = '';
                            errors.forEach(e => {
                                description += `* ${e}`;
                            });
                            break
                        default:
                            description = data.errors;
                            break;
                    }
                    // ret
                    notify({
                        title,
                        description
                    }, {
                        type: 'error',
                        timeout
                    });
                }
                return isLoading(false);

            }).catch(err => {
                console.log(err);
                if (err.response) {
                    return this.processResponse(err.response.data);
                }
                isLoading(false);
                notify({
                    title: 'Something went wrong'
                }, {
                    type: 'error'
                });
            });
        },
        previewSelected($event, id, url) {
            let files = $event.target.files;

            if (!url) {
                this.files[id] = [];
            }

            if (!this.files[id]) {
                this.files[id] = [];
            }

            for (let i = 0; i < files.length; i++) {
                this.files[id].push({
                    file: files[i],
                    color: 'primary',
                    url: url,
                    progress: 0,
                    removeable: 1,
                    uploading: 0,
                    canceled: false,
                    featured: 0,
                    order: 'order-1'
                });
            }
            if (url) {
                $event.target.value = '';
            }
        },

        fileSrc(file) {
            return URL.createObjectURL(file)
        },

        size(size) {
            let v = Math.ceil(size);
            let s = v + "B";

            if (v > 1000) {
                v = Math.ceil(size / 1024);
                s = v + "KB";
            }

            if (v > 1000) {
                v = Math.ceil(v / 1024);
                s = v + "MB";
            }

            if (v > 1000) {
                v = Math.ceil(v / 1024) + "GB";
                s = v + "GB";
            }

            return s;
        },

        cancelUpload(id, index) {
            if (this.files[id][index].progress == 100) {
                return notify({
                    title: `${this.files[id][index].file.name} has been Uploaded successfully`
                });
            }
            notify({
                title: `${this.files[id][index].file.name} upload canceled`
            });

            this.cancelToken.cancel();

            this.files[id][index] = {
                file: this.files[id][index].file,
                color: "danger",
                progress: this.files[id][index].progress,
                removeale: 0,
                uploading: 1,
                canceled: 1,
                featured: 0
            };
        },
        removeFile(id, index) {
            let file = this.files[id][index];
            if (!file.url) {
                document.getElementById(id).value = '';
            }
            return this.files[id].splice(index, 1);
        },

        loopUpload(id, index) {
            let files = this.files[id];

            if (!id || !files[index]) {
                // upload has completed
                return
            }

            let file = files[index];

            if (!file || file.progress > 0) {
                // uploading in progress or canceled or completed
                return this.uploadFile(id, index + 1);
            }

            let form = new FormData();

            // attache the file to be uploaded
            form.append('file', file.file);
            form.append('featured', file.featured);
            form.append('parent_id', this.file_parent_id);
            // generate a new cancel token
            this.cancelToken = axios.CancelToken.source();
            // create axios config
            let config = {
                onUploadProgress: progressEvent => {
                    let complete = (progressEvent.loaded / progressEvent.total * 100 | 0);
                    this.files[id][index] = {
                        file: this.files[id][index].file,
                        color: complete > 100 ? 'primary' : 'success',
                        url: this.files[id][index].url,
                        featured: this.files[id][index].featured,
                        progress: complete,
                        removeable: 0,
                        uploading: 1,
                        order: this.files[id][index].order,
                        canceled: false
                    };
                },
                cancelToken: this.cancelToken.token
            }
            // post data to backend
            axios.post(file.url, form, config).then(res => {

                let data = res.data;

                notify({
                    title: data.message
                }, {
                    type: data.type
                });

                this.uploadFile(id, index + 1);

            }).catch(err => {
                console.log(err);
                let title = 'Something went wrong';
                let type = 'error';
                this.uploadFile(id, index++);

                if (axios.isCancel(err)) {
                    title = `${file.name} upload canceled`;
                }

                if (!navigator.onLine) {
                    title = 'Network error, upload canceled!';
                }

                notify({
                    title
                }, {
                    type,
                    timeout: 10000
                });

            });
        },

        uploadFile(id, index) {
            if (!id) {
                // all files uploaded
                isLoading(false);
                notify({
                    title: 'Files uploaded successfully'
                }, {
                    type: 'success',
                    timeout: 4000
                });
                if (this.redirect_after_file) {
                    window.location.href = this.redirect_after_file;
                    return
                }
                if (this.reload_after_file) {
                    window.location.reload();
                }
                return

            }

            let files = this.files[id];

            if (!files[index]) {
                this.uploading.shift();
                index = 0;
            }

            if (!this.uploading.length) {
                isLoading(false);
                notify({
                    title: 'All Files uploaded successfully'
                }, {
                    type: 'success',
                    timeout: 4000
                }, );
                if (this.redirect_after_file) {
                    window.location.href = this.redirect_after_file;
                    return
                }
                if (this.reload_after_file) {
                    window.location.reload();
                }
                return
            }

            id = this.uploading[0];
            files = this.files[id];

            if (!files || !files.length) {
                this.uploading.shift();
                return this.uploadFile(this.uploading[0], 0);
            }


            if (index < files.length) {
                this.loopUpload(id, index);
            } else {
                this.uploading.shift();
                this.uploadFile(this.uploading[0], 0);
            }

        },
        destroy(el) {
            let b = $(el);
            // let ids = b.data('id')+',';
            // let url = b.data('action');
            let title = "<strong>Do you want to delete this item?</strong>";
            let html = `<b style=" color:red">This action cannot be <u> undone</u></b>
            <br><h5>Proceed</h5>`;

            if (b.hasClass('bulk-delete')) {
                ids = "";
                title = `<strong>You are about making bulk delete</strong>`

                // $('.checking').each(function () {
                //     if(this.checked){
                //         ids += $(this).val() + ",";
                //     }
                // });
            }
            // ids = ids.substr(0, ids.length - 1);

            Swal.fire({
                title,
                icon: 'info',
                html,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> YES!',
                confirmButtonAriaLabel: 'Thumbs up, Yes!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            }).then(result => {
                if (result.isConfirmed) {
                    this.deleteItem(el);
                }
            });

        },
        deleteItem(el) {
            isLoading();
            let url = el.dataset.action;
            let ids = el.dataset.id;
            let rowId = el.dataset.rowid;
            // return;
            axios.delete(url, {
                data: {
                    ids
                }
            }).then(res => {
                isLoading(false);
                let {
                    data
                } = res;
                if (data.status == 200 && rowId) {
                    $(rowId).remove();
                }
                notify({
                    title: data.message,
                    description: data.desc
                }, {
                    type: data.type ? data.type : 'default'
                });
            }).catch(error => {
                isLoading(false);
                notify({
                    title: 'Something went wrong',
                    description: 'Please try again'
                }, {
                    type: 'danger'
                });
            });
        },
        modalEdit(el, newForm = false) {
            $(el.dataset.target).modal('show');

            let form = document.getElementById(el.dataset.form);
            if ($(el).hasClass('preview')) {
                let item = JSON.parse(el.dataset.item);
                let itemKeys = Object.keys(item);
                itemKeys.forEach(id => {
                    let tag = $(`#preview-${id}`);
                    if (!tag) {
                        return
                    }
                    let before = `<span class="badge badge-info">${id.replace('_', ' ')}</span><br/>`;
                    tag.before(before);
                    tag.html(item[id]);
                })

                return false;
            }
            $(form).find('.required').removeClass('is-invalid');
            if (newForm) {

                Vm.data.hide_modal = false;
                form.querySelector('button[type="submit"]').textContent = 'SAVE';
                form.action = el.dataset.store_route;
                form.reset();
                oldValues(form);
                return
            }
            let updater = document.getElementById('form-updater');
            if (updater) {
                updater.dataset.items = el.dataset.item;
                setTimeout(() => {
                    return $('#form-updater').trigger('click');
                }, 500);
            }

            Vm.data.hide_modal = el.dataset.target;
            form.action = el.dataset.update_route;
            form.querySelector('button[type="submit"]').textContent = 'UPDATE';

            let item = JSON.parse(el.dataset.item);
            let itemKeys = Object.keys(item);
            // return;
            itemKeys.forEach(id => {
                let input = $(form).find(`#editing-${id}`);
                if (!input) {
                    return
                }
                if (input.attr('type') == 'file') {
                    return;
                }

                input.val(item[id]);

                if (input.hasClass('tinymce')) {
                    tinymce.get(`editing-${id}`).setContent(item[id]);
                }

                if (input.hasClass('select2')) {
                    input.trigger('change');
                }

                // console.log(item[id]);
            })

        },
        activate(el) {
            let route = el.dataset.route;

            if (!route) {
                return;
            }

            isLoading();

            axios.post(route).then(res => {
                if (res.data.add_class) {

                    if (res.data.toggle) {
                        $('.activate-btn').find('i')
                            .removeClass(res.data.add_class)
                            .addClass(res.data.remove_class);
                    }

                    $(el).find('i').removeClass(res.data.remove_class)
                        .addClass(res.data.add_class);
                }

                if (res.data.img) {
                    $('.preview-file').removeClass(res.data.add_class);
                    if (res.data.add_class) {
                        $(el).closest('div').addClass(res.data.add_class);
                    }
                }
                return this.processResponse(res.data);
            }).catch(err => {
                console.log(err);
                if (err.response) {
                    return this.processResponse(err.response.data);
                }
                isLoading(false);
                notify({
                    title: 'something went wrong'
                }, {
                    'type': 'danger'
                });
            })
        },

        processResponse(data) {
            let type = data.type;
            let title = data.message;
            let description = data.desc;
            let timeout = data.timeout;

            if (data.status == 200) {

                notify({
                    title,
                    description
                }, {
                    type,
                    timeout
                });

                if (data.to) {
                    window.location.href = data.to;
                    return;
                }

                if (data.reload) {
                    window.location.reload()
                    return
                }
            }

            if (data.errors) {
                let errors;
                title = title ? title : 'You have some errors';
                type = 'danger';

                switch (typeof data.errors) {
                    case 'object':
                        errors = Object.values(data.errors);
                        description = '';
                        errors.forEach(e => {
                            description += `* ${e}`;
                        });
                        break
                    default:
                        description = data.errors;
                        break;
                }

                notify({
                    title,
                    description
                }, {
                    type,
                    timeout
                });
            }

            isLoading(false);
            return
        },

        getShopCats(event, part, action, clear = true) {
            let id = event.id;
            switch (part) {
                case 'super':
                    this.form.super_parent_id = id;

                    if (clear) {
                        this.form.parent_id = '';
                        this.form.parent_cat = null;
                        this.form.product_cat = null;
                        this.form.product_cat_id = '';
                        this.shopCats = [];
                        this.parentShopCats = [];
                    }


                    break;
                case 'parent':
                    if (clear) {
                        this.form.parent_id = id;

                        this.form.product_cat_id = '';
                        this.form.product_cat = null;
                        this.shopCats = [];
                    }
                    break;
                case 'product_cat':
                    this.form.product_cat_id = id;

                    this.form.product_id = '';
                    this.products = [];
                    this.form.product = null;
                    break;
                case 'product':
                    this.form.product_id = id;
                    break;
            }

            axios.get(`${action}?part=${part}&id=${id}`).then((res) => {
                switch (part) {
                    case 'super':
                        this.parentShopCats = res.data;
                        break;
                    case 'parent':
                        this.shopCats = res.data;
                        break;
                    case 'product_cat':
                        this.products = res.data;
                        break;
                    default:
                        break;
                }
            })
        },

        removeShopCat(part) {
            switch (part) {
                case 'super':
                    this.form.super_parent_id = '';

                    this.form.parent_id = '';
                    this.form.product_cat_id = '';

                    this.shopCats = [];
                    this.parentShopCats = [];

                    this.form.parent_cat = null;
                    this.form.product_cat = null;
                    break;
                case 'parent':
                    this.form.parent_id = '';

                    this.form.product_cat_id = '';
                    this.form.product_cat = null;
                    this.shopCats = [];
                    break;
                case 'product_cat':
                    this.form.product_cat_id = '';

                    this.products = [];
                    this.form.product_id = '';
                    this.form.product = null;

                    break;
            }
        },

        updateForm(event) {
            let btn = event.target;
            let items = btn.dataset.items;
            items = JSON.parse(items);
            let itemKeys = Object.keys(items);
            itemKeys.forEach(v => {
                this.form[v] = items[v];
            })

            if (this.form.super_parent_id != null) {
                this.getShopCats({
                        id: this.form.super_parent_id
                    },
                    'super',
                    '/admin/product-cats/children',
                    false
                );
            }

            if (this.form.parent_id != null) {
                this.getShopCats({
                        id: this.form.parent_id
                    },
                    'parent',
                    '/admin/product-cats/children',
                    false
                );
            }

            let mains = btn.dataset.mains;
            if (mains) {
                mains = JSON.parse(mains);
                let mainKeys = Object.keys(mains);
                mainKeys.forEach(x => {
                    this[x] = mains[x];
                });
            }

        }
    },
    watch: {
        slugTitle(newValue) {
            if (!this.updateSlug) {
                return;
            }
            this.slug = newValue.replace(/\W+/g, '-').toLowerCase();
        },

        price(newValue) {
            let divisor = Number(newValue);
            if (!newValue) {
                divisor = 1;
            }
            if (Number(this.highPrice)) {
                this.perDiscount = Math.ceil(((Number(this.highPrice) - Number(newValue)) / divisor) * 100);
            }
        },

        highPrice(newValue) {
            if (Number(this.price)) {
                this.perDiscount = Math.ceil((((Number(this.highPrice) - Number(this.price))) / Number(this.price)) * 100);
            }
        }
    },
    mounted() {}

});
app.use(store);
app.use(router);

notify({
    title: 'Loading Completed'
}, {
    timeout: 4000
});



// router.afterEach((to, from, failure) => {
//     store.dispatch('bindJQPkgs');
// })
// app.use()

// store.commit('increment');
window.Vm = app._component;
app.config.globalProperties.window = window;

app.mount('#adminApp')
isLoading(false);
