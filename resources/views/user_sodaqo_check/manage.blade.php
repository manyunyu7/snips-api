@extends('168_template')


@section("header_name")
    Daftar Transaksi
@endsection

@push('css')
    <!-- Datatable -->
    <link href="{{asset('/168_res')}}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Daterange picker -->
    <link href="{{asset('/168_res')}}/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Clockpicker -->
    <link href="{{asset('/168_res')}}/vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <!-- asColorpicker -->
    <link href="{{asset('/168_res')}}/vendor/jquery-asColorPicker/css/asColorPicker.min.css" rel="stylesheet">
    <!-- Material color picker -->
    <link href="{{asset('/168_res')}}/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

    <!-- Pick date -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push("script")

    <script>
        let xaxaxa = "";
        let programNamex = `{{$programName}}`
    </script>

@endpush

@push('css_content')
    .buttons-columnVisibility {
    font-family: Nunito, sans-serif;
    font-size: medium;
    font-style: normal;
    border-radius: 20px;
    padding-left: 3px;
    padding-right: 3px;
    font-size: larger;
    font-weight: bold;
    }

    .buttons-columnVisibility.active{
    padding-right: 3px;
    font-weight: normal;
    padding-left: 3px;
    padding-right: 3px;
    }

    .modal-body img {
    max-width: 100%;
    max-height : 500px;
    height: auto;
    display: block;
    margin: 0 auto;
    }
@endpush

@push('script')
    <!-- Datatable -->
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.js"></script>

    <!-- Chart ChartJS plugin files -->
    <script src="{{ asset('/168_res') }}/vendor/chart.js/Chart.bundle.min.js"></script>

    <!-- Daterangepicker -->
    <script src="{{ asset('/168_res') }}/js/plugins-init/bs-daterange-picker-init.js"></script>

    <script src="{{ asset('/168_res') }}/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

    <script>

        function showSuccessP(title,message){
            Swal.fire(
                title,
                message,
                'success'
            )
        }
        function hideLoadingP() {
            Swal.close()
        }

        function showErrorP(title,message){
            Swal.fire({
                icon: 'error',
                title: title,
                text: message,
                // footer: '<a href="">Why do I have this issue?</a>'
            })
        }


        function showLoadingP() {
            Swal.fire({
                title: 'Tunggu sebentar ya !',
                html: 'Sodaqo.id sedang menyiapkan data untukmu',// add html attribute if you want or remove
                allowOutsideClick: true,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
        }
    </script>
@endpush



@section("page_content")
    <div class="content-body" style="min-height: 798px;">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"> Daftar Transaksi
                        </a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{$programName}}</a></li>
                </ol>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Filter Tanggal</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3  col-xl-6 col-md-12">
                                    <label class="form-label">Tanggal Awal</label>
                                    <input type="datetime-local" name="start_date" class="form-control"
                                           placeholder="" value="2000-01-01T00:00">
                                </div>


                                <div class="col-xl-6 col-md-12">
                                    <label class="form-label">Tanggal Akhir</label>
                                    <input type="datetime-local" name="end_date" class="form-control"
                                           placeholder="" >
                                </div>



                                <button  type="button" class="btn btn-xs btn-outline-dark btn-block filter-date">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <h4 class="card-title">Transaksi Terverifikasi</h4>
                            <h3 class="tv-verified-count"></h3>
                            <div class="progress mb-2">
                                <div class="pg-verified-percent progress-bar progress-animated bg-primary"
                                     ></div>
                            </div>
                            <small><span class="tv-verified-percent"> </span> % dari Total Transaksi</small>
                            <button  type="button" class="btn btn-xs btn-outline-dark filter-verified">Terverifikasi</button>
                            <button  type="button" class="btn btn-xs btn-outline-dark mr-2 filter-verified-w">Dengan Catatan</button>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <h4 class="card-title">Menunggu Verifikasi</h4>
                            <h3 class="tv-waiting-count"></h3>
                            <div class="progress mb-2">
                                <div class="pg-waiting-percent progress-bar progress-animated bg-warning"></div>
                            </div>
                            <small><span class="tv-waiting-percent"></span> % dari Total Transaksi</small>
                            <button type="button" class="btn btn-xs btn-outline-dark filter-waiting">Tampilkan</button>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-xxl-4 col-lg-6 col-sm-6">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <h4 class="card-title">Tidak Valid</h4>
                            <h3 class="tv-invalid-count"></h3>
                            <div class="progress mb-2">
                                <div class="pg-invalid-percent progress-bar progress-animated bg-danger"></div>
                            </div>
                            <small><span class="tv-invalid-percent"></span> % dari Total Transaksi</small>
                            <button type="button" class="btn btn-xs btn-outline-dark filter-invalid">Tampilkan</button>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-4 col-12">
                    <div class="widget-stat card bg-primary">
                        <div class="card-body  p-4">
                            <div class="media">
									<span class="me-3">
										<i class="la la-users"></i>
									</span>
                                <div class="media-body text-white">
                                    <p class="mb-1">Jumlah Transaksi</p>
                                    <h3 class="text-white tv-all-count"></h3>
                                    <small class="mb-2"></small>
                                    <button  type="button" class="btn btn-xs btn-outline-dark mr-2 filter-all">Tampilkan Semua</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-4 col-12">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <h4 class="card-title">Total Dana Terkumpul</h4>
                            <h3 class="tv-terkumpul"></h3>
                            <div class="progress mb-2">
                                <div class="pg-utama progress-bar progress-animated bg-primary"></div>
                            </div>

                            <small>

                                @if($program->fundraising_target!="")
                                    Terkumpul dana sejumlah <span
                                        class="text-dark tv-terkumpul">  </span> dari total
                                    Kebutuhan <span class="text-dark tv-target"> (Tidak Ada)  </span> <br>
                                    Masih dibutuhkan dana sejumlah <span class="tv-needed"> {{$needed}}</span>
                                @else
                                    Terkumpul dana sejumlah <span class="tv-terkumpul">
                                @endif

                            </small>

                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-4 col-12">
                    <div class="widget-stat card">
                        <div class="card-body p-4">
                            <h4 class="card-title">Donasi Bersih</h4>
                            <h3 class="tv-accumulated-net"></h3>

                            <small>
                               Donasi Bersih dipotong dengan persentase biaya admin sebesar
                                <span class="text-blue tv-fee"></span>
                            </small>

                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Jumlah Sedekah</h4>
                        </div>
                        <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="myChart"  style="display: block; width: 513px; height: 256px;" width="513" height="256" class="mychart chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Jumlah Transaksi</h4>
                        </div>
                        <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="myChart2"  style="display: block; width: 513px; height: 256px;" width="513" height="256" class="mychart chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> Daftar Transaksi {{$programName}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style='font-family: Nunito, sans-serif '>
                                <table id="168trs" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th data-sortable="">No</th>
                                        <th data-sortable="">Img</th>
                                        <th data-sortable="">Nama</th>
                                        <th data-sortable="">Nominal Donasi</th>
                                        <th data-sortable="">Terverifikasi</th>
                                        <th data-sortable="">Account</th>
                                        <th data-sortable="">Status</th>
                                        <th data-sortable=""></th>
                                        <th data-sortable="">Diinput Pada</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>


        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="myForm" action='{{ url("transaction/update") }}'
                      enctype="multipart/form-data" method="post">
                    @csrf
                    <input hidden class="aidiz" name="id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Data Donasi <span class="title-aidi"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <img style="border-radius: 20px" class="col-6"
                                     src="" alt="User image">

                                <div class="col-6 text-black">
                                    <div class="media pt-3 pb-3"
                                         style="border: 0.5px dashed lightgrey; padding: 10px; border-radius: 20px">
                                        <div class="media-body">
                                            <h5 class="m-b-5"><a class="text-black">Nama Donatur : <span
                                                        class="user-name"></span></a></h5>
                                            <p class="mb-0">Nominal : Rp.<small class="text-end font-w400"> <span
                                                        class="nominal"></span></small></p>
                                            <p class="mb-0"><span class="modal-doa"></span></p>
                                        </div>
                                    </div>

                                    <div class="mt-3"
                                         style="border: 0.5px dashed lightgrey; padding: 10px; border-radius: 20px">
                                        <h6 class="">Donasi </h6>
                                        <p>Nama Program : {{$programName}}</p>
                                        <p>Nomor Donatur: <span class="mod-user-contact"></span></p>
                                        <p>E-Wallet/Rekening: <span class="mod-donation-merch"></span></p>
                                        <p>Rekening/Nomer : <span class="mod-donation-account"></span></p>
                                        <p>Tanggal Transfer : <span class="mod-date"></span></p>
                                        <p><span class="mod-timer"></span></p>
                                    </div>
                                </div>


                                <div class="col-12 mt-4"
                                     style="border: 0.5px dashed lightgrey; padding: 10px; border-radius: 20px">
                                    <!-- Dropdown for verification status -->
                                    <div class="form-group">
                                        <label for="verification-status">Ubah Status</label>
                                        <select name="status" class="form-control default-select wide"
                                                id="verification-status">
                                            <option value="">Pilih Status</option>
                                            <option value="1">Diterima</option>
                                            <option value="3">Diterima Dengan Catatan</option>
                                            <option value="2">Tidak Sesuai</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Nominal Terverifikasi</label>
                                        <input type="text" class="nominal_net form-control" name="nominal_net"
                                               placeholder="Jumlah Donasi Terverifikasi">
                                    </div>

                                    <!-- Textarea for rejection reason -->
                                    <div class="form-group" id="rejection-reason-group">
                                        <label for="rejection-reason">Catatan:</label>
                                        <textarea name="notes" class="notez form-control"
                                                  id="rejection-reason"></textarea>
                                    </div>


                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary mitmit "  data-bs-dismiss="modal">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('user_sodaqo_check.script')

@endsection






