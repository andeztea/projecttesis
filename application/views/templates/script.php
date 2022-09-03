<!-- jQuery -->
<script src="<?= base_url('assets/plugins') ?>/jquery/jquery.min.js"></script>

<script src="<?= base_url('assets/plugins') ?>/sweetalert2/sweetalert2.all.min.js"></script>

<script src="<?= base_url('assets/plugins') ?>/select2/js/select2.full.min.js"></script>

<script src="<?= base_url('assets/plugins') ?>/datatables/jquery.dataTables.min.js"></script>

<script src="<?= base_url('assets/plugins') ?>/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= base_url('assets/plugins') ?>/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= base_url('assets/plugins') ?>/datatables-select/js/dataTables.select.min.js"></script>

<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/plugins') ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist') ?>/js/adminlte.min.js"></script>

<script>
    $(document).on('click', '#logout', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: $(this).attr('href'),
                    dataType: "JSON",
                    success: function(res) {
                        if (res.code == 0) {
                            window.location.href = res.url
                        }
                    }
                });
            }
        })
    })

    let nontifikasi = $('.nontifikasi');
    let count_notif = $('.count_notif');

    <?php if ($_SESSION['id_role'] == 'Superadmin' || $_SESSION['id_role'] == 'Admin') { ?>
    $.ajax({
        type: "GET",
        url: "<?= site_url('PesanController') ?>",
        dataType: "JSON",
        success: function(res) {
            $.each(res, function(index, value) {
                var title = value.title.split('/');

                if (value.id_role == 'Admin') {
                    var link = '<?= site_url('PesanController/confirm_perti') ?>';
                } else if (value.id_role == 'Mahasiswa') {
                    var link = '<?= site_url('PesanController/confirm_mahasiswa') ?>';
                } else {
                    var link = '<?= site_url('PesanController/confirm_masyarakat') ?>';
                }

                nontifikasi.append('<a href="' + link + '/' + value.id_user +
                    '"class="dropdown-item modal_xl">' +
                    '<div class="media">' +
                    '<img src="<?= base_url('uploads/') ?>' + value.userfile + '"class="img-size-50 img-circle mr-3" style="height:30px;width:30px;">' +
                    '<div class="media-body">' +
                    '<h3 class="dropdown-item-title name_notif">' + title[0] + '</h3>' +
                    '<p class="text-sm">' + title[1] + '</p></div></div></a>');

            });

            count_notif.text(res.length)
        }
    });
    <?php }?>

    $(document).on('click', '.modal_xl', function(e) {
        e.preventDefault();
        $('.modal-dialog').removeClass('modal-xxl');
        $('.modal-dialog').addClass('modal-xl');
        $('.modal-content').load($(this).attr('href'));
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    })

    $(document).on('click', '.modal_xxl', function(e) {
        e.preventDefault();
        $('.modal-dialog').removeClass('modal-xl');
        $('.modal-dialog').addClass('modal-xxl');
        $('.modal-content').load($(this).attr('href'));
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    function toasts_success(icons, titles) {
        Swal.fire({
            position: 'top-end',
            icon: icons,
            title: titles,
            showConfirmButton: false,
            timer: 1500
        })
    }

    function form_submit(selector, table, table2 = false) {
        $(document).on('submit', selector, function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: new FormData(form),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(form).find('small.text-danger').html();
                },
                success: function(res) {
                    if (res.error) {
                        $.each(res.error, function(prefix, val) {
                            $(form).find('small.' + prefix).html(val)
                        })
                    } else {
                        if (table2 != false) {
                            $(table2).DataTable().ajax.reload(null, false);
                        }
                        $(table).DataTable().ajax.reload(null, false);
                        $(form)[0].reset();
                        $('#myModal').modal('hide')
                        toasts_success(res.icon, res.title)
                    }
                }
            });
        })
    }

    function swal_delete(selector, table, table2 = false) {
        $(document).on('click', selector, function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: $(this).attr('href'),
                        dataType: "JSON",
                        success: function(res) {
                            console.log(res);
                            if (table2 != false) $(table2).DataTable().ajax.reload(null, false);
                            $(table).DataTable().ajax.reload(null, false);
                            toasts_success(res.icon, res.title)
                        }
                    });
                }
            })
        })
    }

    function regionSelect2(params) {
        $('.provinsi').select2({
            theme: "bootstrap4",
            dropdownParent: $(".myModal"),
            placeholder: 'Pilih Provinsi',
            ajax: {
                type: "POST",
                url: '<?= site_url('RegionController/provinsi') ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        }).on('select2:select', function(evt) {
            var provID = $(".provinsi option:selected").val();
            $('.kabupaten').removeAttr('disabled')

            $('.kabupaten').select2({
                theme: "bootstrap4",
                dropdownParent: $(".myModal"),
                placeholder: 'Pilih Kabupaten',
                ajax: {
                    type: "POST",
                    url: '<?= site_url('RegionController/kabupaten') ?>',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            provID: provID,
                            search: params.term
                        }
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(evt) {
                var kabID = $(".kabupaten option:selected").val();
                $('.kecamatan').removeAttr('disabled')

                $('.kecamatan').select2({
                    theme: "bootstrap4",
                    dropdownParent: $(".myModal"),
                    placeholder: 'Pilih Kecamatan',
                    ajax: {
                        type: "POST",
                        url: '<?= site_url('RegionController/kecamatan') ?>',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                kabID: kabID,
                                search: params.term
                            }
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                })
            });
        });
    }
</script>