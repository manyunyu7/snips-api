@push("script")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        let myFilter = "";

        function som() {
            var currentDate = new Date();
            // Get the current date and time in the format "YYYY-MM-DDTHH:mm"
            var dateString = currentDate.toISOString().substr(0, 16);
            // Set the value of the "end_date" input element to the current date and time
            document.querySelector('input[name="end_date"]').value = dateString;
        }

        function getStartDate() {
            let date = document.querySelector('input[name="start_date"]').value;
            return date
        }

        function getEndDate() {
            let date = document.querySelector('input[name="end_date"]').value;
            return date
        }

        // jumlah wakaf
        function renderTransactionCountChart() {
            $.ajax({
                url: '{{ url('/rexs') }}', // URL to fetch the data
                method: 'GET',
                data: {
                    "id": {{ $program->id }},
                    "startdate": getStartDate(),
                    "enddate": getEndDate(),
                },
                success: function (data) {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var ctx2 = document.getElementById('myChart2').getContext('2d');

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.map(function (d) {
                                return d.month;
                            }), // use the "month" property as the labels
                            datasets: [{
                                label: 'Jumlah Wakaf', // specify the label for the data series
                                data: data.map(function (d) {
                                    // format the "nominal_sum" value with a thousands separator
                                    return d.nominal_sum.toLocaleString();
                                }),
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                    var myChart2 = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: data.map(function (d) {
                                return d.month;
                            }), // use the "month" property as the labels
                            datasets: [{
                                label: 'Jumlah Transaksi', // specify the label for the data series
                                data: data.map(function (d) {
                                    // format the "nominal_sum" value with a thousands separator
                                    return d.data_count;
                                }),
                                backgroundColor: 'rgba(0, 0, 255, 0.2)', // set the background color to blue (rgba format)
                                borderColor: 'rgba(0, 0, 255, 1)', // set the border color to blue (rgba format)
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                }, error: function (xhr, status, error) {
                    alert('Error: ' + xhr.status + ' - ' + error);
                },
            });
        }


        function getStatusFilter() {
            return myFilter;
        }

        $(document).ready(function () {
            // Initialize DataTables
            reloadSummary()
            som();
            renderTransactionCountChart()


            $("#myForm").submit(function (e) {
                e.preventDefault(); // prevent the form from submitting normally

                showLoadingP()
                var formData = new FormData(this); // create a FormData object from the form



                // submit the form using AJAX
                $.ajax({
                    url: '{{ route('verif_transaction_ajax') }}', // URL to fetch the data
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        reloadSummary()
                        hideLoadingP()
                        $('#168trs').DataTable().ajax.reload();
                        showSuccessP("Alhamdulillah", "Perubahan berhasil disimpan")
                        var message = "";
                        var jumlahSedekah = $(".nominal_net").val();
                        var donaturName = $(".user-name").text();
                        var number = $(".mod-user-contact").text();
                        var namaProgram = "{{$programName}}"

                        var status = formData.get("status")

                        if (status == "1" || status == "3") {
                            message = "Hallo " + donaturName  +", Jazakallahu Khairan, Terima Kasih sudah bersedekah di Sodaqo.id, " +
                                "Sedekahmu berhasil diproses dengan nilai terverifikasi sejumlah " + jumlahSedekah + " pada program " + namaProgram;
                        } else if (status == "2") {
                            message = "Hallo " + donaturName + " " + number + " Jazakallahu Khairan, Terima Kasih sudah bersedekah di Sodaqo.id, " +
                                "pada program " + namaProgram + ".\n\nSaat ini status transaksimu ditolak karena adanya ketidaksesuaian antara bukti transfer dengan data transaksi";
                        }
                        if (status != null && status != "")
                            var popupWindow = window.open("https://api.whatsapp.com/send?phone=" + number + "&text=" + encodeURIComponent(message), "Popup Window", "height=500,width=500");


                    },
                    error: function (xhr, status, error) {
                        reloadSummary()
                        hideLoadingP()
                        showErrorP("Terjadi Kesalahan", "error")
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });


            $('#168trs').DataTable({
                processing: true, // Show the loading indicator
                processing: {
                    "color": "#00c0ef" // Set the color of the loading indicator
                },
                ordering: true,
                serverSide: true,
                initComplete: function () {
                    Swal.close();
                },
                columnDefs: [{
                    orderable: true,
                    targets: 0
                }],
                dom: 'B<"clear">Tlfrtip<"bottom">',
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                ajax: {
                    url: '{{ route('donations-data-ajax') }}', // URL to fetch the data
                    type: 'GET', // Use GET method to fetch the data,
                    "data": function (d) {
                        d.id = `{{ $program->id }}`;
                        d.startdate = getStartDate();
                        d.enddate = getEndDate();
                        d.statfilter = getStatusFilter();
                        _token: '{{ csrf_token() }}' // include the CSRF token
                    },
                },
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'payment_photo',
                        name: 'payment_photo',
                        render: function (data, type, row, meta) {
                            return `<img height="100px" style="border-radius: 20px; max-width: 100px; object-fit: contain" src='${data}' alt="">`;
                        }
                    },
                    {data: 'user_name', name: 'user_name'},
                    {
                        data: 'nominal',
                        name: 'nominal',
                        render: function (data, type, row, meta) {
                            // Format the nominal as Indonesian rupiah
                            var rupiah = data.toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            });

                            // Return the formatted value
                            return rupiah;
                        }
                    },
                    {
                        data: 'nominal_net',
                        name: 'nominal_net',
                        defaultContent: "",
                        render: function (data, type, row, meta) {
                            // Format the nominal as Indonesian rupiah
                            if (data != null) {
                                return data.toLocaleString('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                });
                            } else {
                                "-"
                            }
                        }
                    },
                    {data: 'payment_number', name: 'payment_number'},
                    {
                        data: ['status'],
                        name: 'payment',
                        render: function (data, type, row, meta) {
                            return data == 1 ? '<a href="javascript:void(0)" class="btn btn-outline-success btn-rounded light">Terverifikasi</a>' :
                                data == 0 ? '<a href="javascript:void(0)" class="btn btn-outline-danger btn-rounded light">Belum Diverifikasi</a>' :
                                    data == 2 ? '<a href="javascript:void(0)" class="btn btn-outline-warning btn-rounded light">Tidak Sesuai</a>' :
                                        data == 3 ? '<a href="javascript:void(0)" class="btn btn-outline-warning btn-rounded btn-xs light">Diterima Dengan Catatan</a>' :
                                            data;
                        }
                    },
                    {
                        data: null,
                        name: 'all_data_2',
                        render: function (data, type, row, meta) {
                            return `
                            <button type="button" class="btn btn-primary mb-2"
                                    data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"
                                    data-img-src='${data.payment_photo}'
                                    data-aidi='${data.id}'
                                    data-user-name='${data.user_name}'
                                    data-uscon='${data.user_contact}'
                                    data-nominal='${data.nominal.toLocaleString(undefined, {minimumFractionDigits: 2})}'
                                    data-qw='${data.payment_number}'
                                    data-er='${data.payment_name}'
                                    data-ty='${data.payment_merchant_name}'
                                    data-xss='${data.created_at}'
                                    data-created='${data.created_at}'
                                    data-razky='${data.user_photo}'
                                   data-nomnet='${data.nominal_net ? data.nominal_net : ''}'
                                    data-donm='${data.doa}'
                                    data-vvv='${data.notes_admin ? data.notes_admin : ''}'
                                    data-valid='${data.status}'>
                                Edit
                            </button>
                        `;
                        }
                    },
                    {data: 'created_at', name: 'created_at'},

                ],
                buttons: [
                    // {extend: 'colvis', className: 'btn btn-primary glyphicon glyphicon-duplicate'},
                    {extend: 'copy', className: 'btn btn-primary glyphicon glyphicon-duplicate'},
                    {extend: 'csv', className: 'btn btn-primary glyphicon glyphicon-save-file'},
                    {
                        extend: 'excel', className: 'btn btn-primary glyphicon glyphicon-list-alt',
                        exportOptions: {
                            stripHtml: true
                        }
                    },
                    {extend: 'pdf', className: 'btn btn-primary glyphicon glyphicon-file'},
                    {extend: 'print', className: 'btn btn-primary glyphicon glyphicon-print'}
                ],
            }).on('preXhr.dt', function (e, settings, data) {
                showLoadingP()
            }).on('draw.dt', function () {
                Swal.close();
            });

            $('.filter-verified').click(function () {
                myFilter = "verified"
                $('#168trs').DataTable().ajax.reload();
                reloadSummary()
            });
            $('.filter-verified-w').click(function () {
                myFilter = "verifiedw"
                $('#168trs').DataTable().ajax.reload();
                reloadSummary()
            });
            $('.filter-waiting').click(function () {
                myFilter = "waiting"
                $('#168trs').DataTable().ajax.reload();
                reloadSummary()
            });
            $('.filter-all').click(function () {
                myFilter = "all"
                $('#168trs').DataTable().ajax.reload();
                reloadSummary()
            });
            $('.filter-invalid').click(function () {
                myFilter = "invalid"
                $('#168trs').DataTable().ajax.reload();
                reloadSummary()
            });

        });

        function reloadSummary() {
            $.ajax({
                url: '{{ route('transaction_summary_ajax') }}', // URL to fetch the data
                method: 'GET',
                data: {
                    "id": {{ $program->id }},
                    "startdate": getStartDate(),
                    "enddate": getEndDate(),
                },
                success: function (response) {
                    // Set the text content of each <span> element using the data from the AJAX response
                    $('.tv-verified-count').text(response.verifiedCount);
                    $('.tv-verified-percent').text(response.verifiedPercent);
                    $('.pg-verified-percent').css('width', response.verifiedPercent + '%');

                    $('.tv-waiting-count').text(response.waitingCount);
                    $('.tv-waiting-percent').text(response.waitingPercent);
                    $('.pg-waiting-percent').css('width', response.waitingPercent + '%');

                    $('.tv-invalid-count').text(response.invalidCount);
                    $('.tv-invalid-percent').text(response.invalidPercent);
                    $('.pg-invalid-percent').css('width', response.invalidPercent + '%');


                    $('.pg-utama').css('width', response.fundraisingPercentage + '%');

                    $('.tv-terkumpul').text(response.formattedRupiah);
                    $('.tv-needed').text(response.remaining);
                    $('.tv-target').text(response.fundraisingTarget);
                    $('.tv-accumulated-net').text(response.formattedAccumulatedNet);
                    $('.tv-fee').text(response.feePercentage);

                    if (response.fundraisingTarget == null) {
                        $('.tv-target').text("(Tidak Ada Target)");
                    }
                    $('.tv-all-count').text(response.allCount);


                },
                error: function (xhr, status, error) {
                    alert(error);
                },
            })
        }

    </script>

    <script>
        $('.filter-invalid').click(function () {
            renderTransactionCountChart()
        });
    </script>


    <script>
        function showLoadingIndicator() {
            var loadingIndicator = document.querySelector('.loading-indicator');
            loadingIndicator.style.display = 'block';

            var element = document.querySelector('.mitmit');
            element.style.display = 'none';
        }

        document.querySelector('.bd-example-modal-lg.bd-example-modal-lg').addEventListener('show.bs.modal', function (e) {
            var imgSrc = e.relatedTarget.dataset.imgSrc;
            var userName = e.relatedTarget.dataset.userName;
            var nominal = e.relatedTarget.dataset.nominal;
            var donAccount = e.relatedTarget.dataset.qw;
            var donAccountName = e.relatedTarget.dataset.er;
            var donMerchant = e.relatedTarget.dataset.ty;
            var picUser = e.relatedTarget.dataset.razky;
            var doa = e.relatedTarget.dataset.donm;
            var nomNet = e.relatedTarget.dataset.nomnet;
            var aidi = e.relatedTarget.dataset.aidi;
            var notes = e.relatedTarget.dataset.vvv;
            var uscon = e.relatedTarget.dataset.uscon;

            this.querySelector('.modal-body .mod-donation-merch').textContent = donMerchant;
            this.querySelector('.modal-body .mod-user-contact').textContent = uscon;

            this.querySelector('.modal-body .mod-timer').textContent = getTimeDifference(e.relatedTarget.dataset.xss);
            this.querySelector('.modal-body .mod-date').textContent = e.relatedTarget.dataset.xss;


            document.getElementById('rejection-reason').value = notes;

            this.querySelector('.modal-body img').src = imgSrc;
            // this.querySelector('.modal-body .profx').src = picUser;
            this.querySelector('.modal-body .user-name').textContent = userName;
            this.querySelector('.modal-body .nominal').textContent = nominal;
            this.querySelector('.modal-body .modal-doa').textContent = doa;
            this.querySelector('.modal-body .mod-donation-account').textContent = donAccount;
            this.querySelector('.modal-body .nominal_net').value = nomNet;
            this.querySelector('.aidiz').setAttribute('value', aidi);
            this.querySelector('.modal-body .title-aidi').textContent = aidi;

            this.querySelector('.modal-body img').onerror = "this.onerror=null;this.src='https://avatarsb.s3.amazonaws.com/others/panda-black-toy1-31-min.png'"
        });

        function getTimeDifference(donCreatedx) {
            // Get the current date and time
            var currentDate = new Date();

            // Parse the donCreated date and time from the string
            var donCreated = new Date(donCreatedx);

            // Calculate the difference between the two dates in milliseconds
            var timeDifference = currentDate - donCreated;

            // Convert the time difference to minutes
            var timeDifferenceInMinutes = timeDifference / (60 * 1000);

            // Check if the time difference is less than 2 hours
            if (timeDifferenceInMinutes < 120) {
                // If it is, check if the time difference is less than 15 minutes
                if (timeDifferenceInMinutes < 15) {
                    // If it is, convert the time difference to seconds
                    var timeDifferenceInSeconds = timeDifference / 1000;
                    // Return the time difference in seconds
                    return "Ditransfer " + timeDifferenceInSeconds + " detik yang lalu";
                } else {
                    // If the time difference is more than 15 minutes but less than 2 hours, return the time difference in minutes
                    return "Ditransfer " + timeDifferenceInMinutes + " menit yang lalu";
                }
            } else {
                // If the time difference is more than 2 hours, convert the time difference to hours
                var timeDifferenceInHours = timeDifference / (60 * 60 * 1000);

                // Check if the time difference is less than 24 hours
                if (timeDifferenceInHours < 24) {
                    // If it is, round the number of hours down to the nearest integer
                    var hours = Math.floor(timeDifferenceInHours);

                    // Calculate the number of minutes
                    var minutes = Math.floor((timeDifferenceInHours - hours) * 60);

                    // Return the time difference in hours and minutes
                    return "Ditransfer " + hours + " jam " + minutes + " menit yang lalu";
                } else {
                    // If the time difference is more than 24 hours, convert the time difference to days
                    var timeDifferenceInDays = timeDifference / (24 * 60 * 60 * 1000);
                    // Round the number of days down to the nearest integer
                    var days = Math.floor(timeDifferenceInDays);

                    // Calculate the number of hours
                    var hours = Math.floor((timeDifferenceInDays - days) * 24)

                    // Return the time difference in days and hours
                    return "Ditransfer " + days + " hari " + hours + " jam yang lalu";
                }
            }
        }
    </script>

    <script>
        // Get the button that the user clicks to filter the table by date
        let btnFilterDate = document.querySelector('.filter-date');
        // Define the event listener for the click event on the button
        btnFilterDate.addEventListener('click', function () {
            // Get the values of the start and end date input fields
            let startDate = document.querySelector('input[name="start_date"]').value;
            let endDate = document.querySelector('input[name="end_date"]').value;

            // Check if the end date is higher than the start date
            if (startDate > endDate) {
                // Display error message or prevent the ajax call from being made
                Sweetalert2.fire({
                    title: 'Terjadi Kesalahan', // Title of the error message
                    text: 'Tanggal akhir harus lebih besar dari tanggal awal', // Indonesian text for the error message
                    icon: 'error', // Icon to display with the error message
                });
            } else {
                // Update the data being displayed in the table by making a new ajax call
                // with the start and end dates in the data object
                $('#168trs').DataTable().ajax.reload();
                reloadSummary()
            }
        });
    </script>
@endpush
