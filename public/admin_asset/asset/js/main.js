$(function() {

    //load ajax address
    $(document).on('change', '#city', function() {
        let urlRequest = $(this).data("url");
        let mythis = $(this);
        let value = $(this).val();
        let defaultCity = "<option value=''>Chọn thành phố</option>";
        let defaultDistrict = "<option value=''>Chọn quận huyện</option>";
        if (!value) {
            $('#district').html(defaultDistrict);
        } else {
            $.ajax({
                type: "GET",
                url: urlRequest,
                data: { 'cityId': value },
                success: function(data) {
                    if (data.code == 200) {
                        let html = defaultDistrict + data.data;
                        $('#district').html(html);
                    }
                }
            });
        }
    })
    

    // js load ảnh khi upload
    $(document).on('change', '.img-load-input', function() {
        let input = $(this);
        displayImage(input, '.wrap-load-image', '.img-load');
    });
    
    function displayImage(input, selectorWrap, selectorImg) {
    input.parents(selectorWrap).find(selectorImg).remove();

    let file = input.prop('files')[0];
    let reader = new FileReader();

    reader.addEventListener("load", function() {
        // convert image file to base64 string
        let img = $('<img />');
        img.attr({
            'src': reader.result,
            'alt': file.name,
        });
        input.parents(selectorWrap).append(img);
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}
    // js load nhiều ảnh khi upload
    $(document).on('change', '.img-load-input-multiple', function() {
        let input = $(this);
        displayMultipleImage(input, '.wrap-load-image', '.load-multiple-img');
    });
    // end js load ảnh khi upload

    // js render slug khi nhập tên
    $(document).on('change keyup', '#name', function() {
        let name = $(this).val();
        $('#slug').val(ChangeToSlug(name));
    });


    // js render slug khi nhập tên
    $(document).on('change keyup', '.nameChangeSlug', function() {
        let name = $(this).val();
        $(this).parents('.wrapChangeSlug').find('.resultSlug').val(ChangeToSlug(name));
    });
    // end js render slug khi nhập tên


    // function convert slug
        function ChangeToSlug(title) {
            let slug = title.toLowerCase();
            slug = slug.replace(/Ã¡|Ã |áº£|áº¡|Ã£|Äƒ|áº¯|áº±|áº³|áºµ|áº·|Ã¢|áº¥|áº§|áº©|áº«|áº­/gi, 'a');
            slug = slug.replace(/Ã©|Ã¨|áº»|áº½|áº¹|Ãª|áº¿|á»|á»ƒ|á»…|á»‡/gi, 'e');
            slug = slug.replace(/i|Ã­|Ã¬|á»‰|Ä©|á»‹/gi, 'i');
            slug = slug.replace(/Ã³|Ã²|á»|Ãµ|á»|Ã´|á»‘|á»“|á»•|á»—|á»™|Æ¡|á»›|á»|á»Ÿ|á»¡|á»£/gi, 'o');
            slug = slug.replace(/Ãº|Ã¹|á»§|Å©|á»¥|Æ°|á»©|á»«|á»­|á»¯|á»±/gi, 'u');
            slug = slug.replace(/Ã½|á»³|á»·|á»¹|á»µ/gi, 'y');
            slug = slug.replace(/Ä‘/gi, 'd');
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            slug = slug.replace(/ /gi, "-");
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            return slug;
        }
    

    // js  show childs category đệ quy
    $(document).on('click', '.lb-toggle', function() {
        $(this).parent().parent().parent('li').children('ul').slideToggle();
        $(this).find('i').toggleClass('fa-plus').toggleClass('fa-minus');
    });
    // end js  show childs category đệ quy

    // js create select tag
    // $(".tag-select-choose").select2({
    //     tags: true,
    //     tokenSeparators: [','],
    // });
    // $(".select-2-init").select2({
    //     placeholder: "--- Chọn danh mục ---",
    //     allowClear: true,
    // });
    // end create select tag

    // js tinymce
    let editor_config = {
        path_absolute: "/",
        selector: 'textarea.tinymce_editor_init',
        relative_urls: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback: function(callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            let cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    };
    if ($("textarea.tinymce_editor_init").length) {
        tinymce.init(editor_config);
    }

    // end  tinymce

    // js load change trạng thái hot và active
    // $(document).on('click', '.lb-active', function() {
    //     event.preventDefault();
    //     let wrapActive = $(this).parents('.wrap-load-active');
    //     let urlRequest = wrapActive.data("url");
    //     console.log(urlRequest);
    //     let value = $(this).data("value");
    //     let type = $(this).data("type");
    //     let title = '';
    //     if (value) {
    //         title = 'Bạn có chắc chắn muốn ẩn ' + type;
    //     } else {
    //         title = 'Bạn có chắc chắn muốn hiển thị ' + type;
    //     }
    //     Swal.fire({
    //         title: title,
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, next step!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 type: "GET",
    //                 url: urlRequest,
    //                 success: function(data) {
    //                     if (data.code == 200) {
    //                         let html = data.html;
    //                         wrapActive.html(html);
    //                     }
    //                 }
    //             });
    //         }
    //     })
    // });

    $(document).on("click", ".lb_delete", actionDelete);

        function actionDelete(event) {

            event.preventDefault();
            let urlRequest = $(this).data("url");
            let mythis = $(this);
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa',
                text: "Bạn sẽ không thể khôi phục điều này",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        success: function(data) {
                            if (data.code == 200) {

                                mythis.parents("tr").remove();
                            }
                        },
                        error: function() {

                        }
                    });
                    // Swal.fire(
                    // 'Deleted!',
                    // 'Your file has been deleted.',
                    // 'success'
                    // )
                }
            })
        }

    // js load change trạng thái hot và active
    $(document).on('click', '.lb-active', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-active');
        let urlRequest = wrapActive.data("url");
        console.log(urlRequest);
        let value = $(this).data("value");
        let type = $(this).data("type");
        let title = '';

        $.ajax({
            type: "GET",
            url: urlRequest,
            success: function(data) {
                if (data.code == 200) {
                    let html = data.html;
                    wrapActive.html(html);
                }
            }
        });
    });

    // js load change trạng thái hot và role
    $(document).on('click', '.lb-role', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-role');
        let urlRequest = wrapActive.data("url");

        $.ajax({
            type: "GET",
            url: urlRequest,
            success: function(data) {
                if (data.code == 200) {
                    let html = data.html;
                    wrapActive.html(html);
                }
            }
        });
    });

    $(document).on('click', '.lb-default', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-default');
        let urlRequest = wrapActive.data("url");
        let value = $(this).data("value");
        let type = $(this).data("type");
        let title = '';
        if (value) {
            title = 'Bạn có chắc chắn muốn bỏ mặc định' + type;
        } else {
            title = 'Bạn có chắc chắn muốn chuyển' + type + ' sang mặc định';
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, next step!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            wrapActive.html(html);
                        }
                    }
                });
            }
        })
    });

    $(document).on('click', '.lb-active-user', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-active');
        let urlRequest = wrapActive.data("url");
        let value = $(this).data("value");
        let type = $(this).data("type");
        let title = '';
        if (value) {
            title = 'Bạn có chắc chắn muốn ẩn ' + type;
        } else {
            title = 'Bạn có chắc chắn muốn kích hoạt ' + type;
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, next step!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            wrapActive.html(html);
                        }
                    }
                });
            }
        })
    });

    $(document).on('click', '.lb-hot', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-hot');
        let urlRequest = wrapActive.data("url");
        let value = $(this).data("value");
        let type = $(this).data("type");
        let title = '';
        if (value) {
            title = 'Bạn có chắc chắn muốn bỏ nổi bật ' + type;
        } else {
            title = 'Bạn có chắc chắn muốn chuyển ' + type + ' sang nổi bật';
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, next step!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            wrapActive.html(html);
                        }
                    }
                });
            }
        })
    });

    $(document).on('click', '.lb-thanhtoan', function() {
        event.preventDefault();
        let wrapActive = $(this).parents('.wrap-load-thanhtoan');
        let urlRequest = wrapActive.data("url");
        let value = $(this).data("value");
        let title = '';
        if (value) {
            title = 'Bạn có chắc chắn muốn chuyển đơn hàng sang trạng thái chưa thanh toán ';
        } else {
            title = 'Bạn có chắc chắn muốn chuyển  đơn hàng sang trạng thái đã thanh toán';
        }
        Swal.fire({
            title: title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tiếp tục!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            wrapActive.html(html);
                        }
                    }
                });
            }
        })
    });

    // js load change trạng thái hot và active
    $(document).on('change', '.lb-order', function() {
        event.preventDefault();
        let wrap = $(this);
        let urlRequest = wrap.data("url");
        let value = $(this).val();

        if (value !== '') {
            var number_regex = /([0-9]{1,})/;
            if (number_regex.test(value) == false) {
                alert('Số thứ tự của bạn không đúng định dạng!');
            } else {
                let title = '';
                title = 'Bạn có chắc chắn muốn đổi số thứ tự ';
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    data: { order: value },
                    dataType: "json",
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.html,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.html,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }

                        // console.log( response.html);
                    },
                    error: function(response) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.html,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        } else {
            alert('Bạn chưa điền số thứ tự');
        }


    });

    // end  js load change trạng thái hot và active

    // js chọn quyền
    $('.checkall').on('click', function() {
        $(this).parents('.wrap-permission').find('.check-children,.check-parent').prop('checked', $(this).prop('checked'));
    });
    $('.check-parent').on('click', function() {
        $(this).parents('.item-permission').find('.check-children').prop('checked', $(this).prop('checked'));
    });
    // end js chọn quyền

    // js load ajax đơn hàng
    $(document).on("click", "#btn-load-transaction-detail", function() {

        let contentWrap = $('#loadTransactionDetail');

        let urlRequest = $(this).data("url");
        $.ajax({
            type: "GET",
            url: urlRequest,
            success: function(data) {
                if (data.code == 200) {
                    let html = data.htmlTransactionDetail;
                    contentWrap.html(html);
                    $('#transactionDetail').modal('show');
                }
            }
        });
    });
    // end js load ajax đơn hàng

    // js load ajax chuyển trạng thái đơn hàng
    $(document).on("click", ".status span", loadNextStepStatus);

    function loadNextStepStatus(event) {
        event.preventDefault();
        let statusWrap = $(this).parents('.status');
        // get url load ajax
        let urlRequest = statusWrap.data("url");
        // get giá trị status hiện tại
        let statusCurrent = parseInt($(this).data("status"));

        // set giá trị các trạng thái
        let arrListStatus = [
            { status: 'hủy bỏ', nextstep: 'Đơn hàng đã bị hủy bỏ không thể chuyển đến trạng thái tiếp theo' },
            { status: 'Đặt hàng thành công chờ xử lý', nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái đã tiếp nhận đơn hàng' },
            { status: 'Đã tiếp nhận', nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái đang vận chuyển' },
            { status: 'Đang vận chuyển', nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái hoàn thành' },
            { status: 'Hoàn thành', nextstep: 'Đơn hàng đã hoàn thành' },
        ]

        let swalOption = {
            //  title: "test",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            // confirmButtonText: 'Yes, next step!'
        }
        if (statusCurrent > 0 && statusCurrent < 4) {
            swalOption.confirmButtonText = 'Yes, next step!';
            swalOption.title = arrListStatus[statusCurrent].nextstep;
        } else if (statusCurrent < 0) {
            swalOption.title = arrListStatus[0].nextstep;
            swalOption.showCancelButton = false;
        } else {
            swalOption.title = arrListStatus[statusCurrent].nextstep;
            swalOption.showCancelButton = false;
            swalOption.icon = 'success';
        }

        Swal.fire(swalOption).then((result) => {
            if (result.isConfirmed && statusCurrent > 0 && statusCurrent < 4) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.htmlStatus;
                            statusWrap.html(html);
                        }
                    }
                });
            }
        })
    }
    // end js load ajax chuyển trạng thái đơn hàng


    // js load ajax chuyển trạng thái thông tin liên hệ
    $(document).on("click", ".status-2 span", loadNextStepStatus_2);

    function loadNextStepStatus_2(event) {
        event.preventDefault();
        let statusWrap = $(this).parents('.status-2');
        // get url load ajax
        let urlRequest = statusWrap.data("url");
        // get giá trị status hiện tại
        let statusCurrent = parseInt($(this).data("status"));

        // set giá trị các trạng thái
        let arrListStatus = [
            { status: 'hủy bỏ', nextstep: 'Thông tin đã bị hủy bỏ không thể chuyển đến trạng thái tiếp theo' },
            { status: 'Đặt hàng thành công chờ xử lý', nextstep: 'Bạn có muốn chuyển sang trạng thái hoàn thành' },
            { status: 'Hoàn thành', nextstep: 'Thông tin liên hệ đã hoàn thành' },
        ]

        let swalOption = {
            //  title: "test",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            // confirmButtonText: 'Yes, next step!'
        }
        if (statusCurrent > 0 && statusCurrent < 4) {
            swalOption.confirmButtonText = 'Yes, next step!';
            swalOption.title = arrListStatus[statusCurrent].nextstep;
        } else if (statusCurrent < 0) {
            swalOption.title = arrListStatus[0].nextstep;
            swalOption.showCancelButton = false;
        } else {
            swalOption.title = arrListStatus[statusCurrent].nextstep;
            swalOption.showCancelButton = false;
            swalOption.icon = 'success';
        }

        Swal.fire(swalOption).then((result) => {
            if (result.isConfirmed && statusCurrent > 0 && statusCurrent < 4) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.htmlStatus;
                            statusWrap.html(html);
                        }
                    }
                });
            }
        })
    }
    // end js load ajax chuyển trạng thái liên hệ
});