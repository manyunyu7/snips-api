@extends('168_template')
@include('168_component.util.wyswyig')


@section("header_name")
    Tambah Program Baru
@endsection

@push("css")
    <!-- Form step -->
    <link href="{{asset("/168_res")}}/vendor/jquery-smartwizard/dist/css/smart_wizard.min.css" rel="stylesheet">
@endpush

@push("script")
    <script src="{{asset("/168_res")}}/vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js"></script>
    <script src="{{asset("/168_res")}}/vendor/jquery-steps/build/jquery.steps.min.js"></script>
    <script src="{{asset("/168_res")}}/vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="{{asset("/168_res")}}/js/plugins-init/jquery.validate-init.js"></script>

    <script>


        var el = document.getElementById('formFile168');
        el.onchange = function () {
            var fileReader = new FileReader();
            fileReader.readAsDataURL(document.getElementById("formFile168").files[0])
            fileReader.onload = function (oFREvent) {
                document.getElementById("imgPreview").src = oFREvent.target.result;
                document.getElementById("imgConf").src = oFREvent.target.result;
            };
        }
    </script>

    <script>
        $(document).ready(function () {

            function activaTab(tab) {
                $('.nav-tabs a[href="#' + tab + '"]').tab('show');
            };

            $("#next1").click(function () {
                var isError = false;
                if ($.trim($('#inputName').val()) == '') {
                    isError = true
                    swal("Perhatian!", "Lengkapi nama program terlebih dahulu", "warning");
                }

                if (isError) {
                } else {
                    activaTab("home2")
                }
            });
            $("#next2").click(function () {
                activaTab("home3")
            });
            $("#next3").click(function () {
                var isError = false;
                if ($.trim($("#formFile168").val()).length == 0) {
                    isError = true
                    swal("Perhatian!", "Lengkapi foto terlebih dahulu", "warning");
                }

                if (isError) {
                    swal("Perhatian!", "Lengkapi foto program", "warning");
                } else {
                    activaTab("home4")
                }
            });

            $.myfunction = function () {
                if($("#inputName").val()!==""){
                    $("#reviewName").text($("#inputName").val());
                }

                if($("#inputTarget").val()!==""){
                    $("#reviewFundraisingTarget").text($("#inputTarget").val());
                }

                if($("#inputDate").val()!==""){
                    $("#reviewTimeLimit").text($("#inputDate").val());
                }

                if($("#inputFee").val()!==""){
                    $("#reviewPercentage").text($("#inputFee").val());
                }


                var start = new Date().toLocaleDateString()
                var end = $("#inputDateDate").datepicker("getDate");
                days = (end - start) / (1000 * 60 * 60 * 24);

                $("#reviewDurasi").text(Math.round(days));


            };

            $("#inputDate").change(function () {
                $.myfunction();
            });
            $("#inputFee").change(function () {
                $.myfunction();
            });
            $("#inputTarget").keyup(function () {
                $.myfunction();
            })
            $("#inputName").keyup(function () {
                $.myfunction();
            })
        });
    </script>

    <script>
        $(document).ready(function () {
            // SmartWizard initialize
            $('#smartwizard').smartWizard();
        });
    </script>
    <script>

        var form = document.querySelector('form');

        // Listen for the submit event on the form
        form.addEventListener("submit", function(event) {
            // Prevent the form from being submitted
            event.preventDefault();
            showConfirmationPrompt()
        });



        function showConfirmationPrompt() {

            var form = document.querySelector('form');

            // Check the validity of the form
            if (form.checkValidity()) {
                // Use the Swal.fire() method to show the confirmation prompt
                Swal.fire({
                    title: 'Anda Yakin ?',
                    text: 'Periksa kembali data anda',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.value) {
                        // If the user clicks "OK", submit the form
                        form.submit()
                        return true;
                    } else {
                        // If the user clicks "Cancel", prevent the form from being submitted
                        return false;
                    }
                });
            } else {
                // If the form is invalid, don't show the confirmation prompt
                // and let the browser handle the validation error
                Swal.fire({
                    title: 'Error!',
                    text: 'Lengkapi Form terlebih dahulu',
                    type: 'error'
                });
                return false;
            }


        }
    </script>
@endpush

@section("page_content")
    <div class="content-body" style="min-height: 798px;">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{url("sodaqo/me")}}">Program</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tambah Baru</a></li>
                </ol>
            </div>
            <!-- row -->
            <form action="{{ url('sodaqo/store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        @include("168_component.alert_message.message")
                    </div>

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#home1">
                                                <i class="las la-info-circle me-2"></i></i>Judul</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#home2">
                                                <i class="las la-money-bill"></i> Target</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#home3">
                                                <i class="las la-photo-video me-2"></i></i> Foto</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#home4">
                                                <i class="las la-tasks me-2"></i></i> Konfirmasi</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="home1" role="tabpanel">
                                            <div class="pt-4">
                                                <div class="basic-form row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="basicInput">Kategori
                                                            Program</label>
                                                        <select
                                                            class="form-control default-select form-control wide mb-3"
                                                            name="merchant_id" id="" required>
                                                            @forelse($categories as $data)
                                                                <option value="{{$data->id}}">

                                                                    {{$data->name}}</option>
                                                            @empty

                                                            @endforelse
                                                        </select>
                                                        <div class="form-text">Pilih salah satu kategori program</div>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="basicInput">Nama Program</label>
                                                        <input id="inputName" type="text" name="name" required
                                                               class="form-control"
                                                               value="{{ old('name') }}"
                                                               placeholder="Judul/Nama Program">
                                                        <div class="form-text">Silakan isi nama program sesuai dengan
                                                            data
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label" for="">Deskripsi/Narasi
                                                            Program</label>
                                                        <textarea class="form-control" name="m_description"
                                                                  id="summernote" rows="10"
                                                                  placeholder="Deskripsi">{{old('m_description')}}</textarea>
                                                    </div>

                                                    <button id="next1" type="button"
                                                            class="btn btn-outline-primary mt-5">Selanjutnya
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="home2">
                                            <div class="pt-4">
                                                <div class="basic-form row">

                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="basicInput">Batas Waktu
                                                            Program</label>
                                                        <input id="inputDate" type="date" name="time_limit"
                                                               class="form-control"
                                                               value="{{ old('time_limit') }}"
                                                               placeholder="Batas Waktu">
                                                        <div class="form-text">Kosongkan jika tidak ada batas waktu.
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="basicInput">Target Nominal
                                                            Dana</label>
                                                        <input id="inputTarget" type="number" min="0.00"
                                                               name="fundraising_target"
                                                                class="form-control"
                                                               value="{{ old('fundraising_target') }}"
                                                               placeholder="Target Donasi">
                                                        <div class="form-text">Kosongkan jika tidak ada target</div>
                                                    </div>


                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="basicInput">Persentase bIAYA Admin
                                                            (Jika Ada)</label>
                                                        <input id="inputFee" type="number" min="0.00"
                                                               name="admin_fee"
                                                               class="form-control"
                                                               value="{{ old('admin_fee') }}"
                                                               placeholder="Admin Fee">
                                                        <div class="form-text">Contoh Input : 0.5 atau 5.0 atau 2.5
                                                        </div>
                                                    </div>


                                                    <button id="next2" type="button"
                                                            class="btn btn-outline-primary mt-5">Selanjutnya
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="home3">
                                            <div class="pt-4">
                                                <div class="basic-form row">

                                                    <div class="mb-3 row">

                                                        <div class="col-12 d-flex justify-content-center">
                                                            <img
                                                                id="imgPreview"
                                                                src="https://i.stack.imgur.com/y9DpT.jpg" alt="image"
                                                                class="me-3 rounded"
                                                                width="275">
                                                        </div>

                                                        <label class="col-form-label mt-4">Foto Baru</label>
                                                        <div class="col-12">
                                                            <div class="input-group">
                                                                <div class="form-file">
                                                                    <input id="formFile168" type="file" name="photo"
                                                                           class="form-file-input form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button id="next3" type="button"
                                                            class="btn btn-outline-primary mt-5 col-md-6 col-12">
                                                        Selanjutnya
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="home4">
                                            <div class="pt-4">
                                                <h4>Konfirmasi Program</h4>
                                                <p>Pastikan data berikut sudah sesuai
                                                </p>
                                                <br>
                                                <div class="col-12 d-flex justify-content-center">
                                                    <img
                                                        id="imgConf"
                                                        src="https://i.stack.imgur.com/y9DpT.jpg" alt="image"
                                                        class="me-3 rounded"
                                                        width="275">
                                                </div>

                                                <p><span class="text-black"> Program</span> : <span
                                                        id="reviewName">-</span></p>
                                                <p><span class="text-black"> Target Donasi</span> : <span
                                                        id="reviewFundraisingTarget">Tidak Ada Target</span></p>
                                                <p><span class="text-black"> Batas Akhir Donasi</span> : <span
                                                        id="reviewTimeLimit">Tidak Ada Batas Akhir</span></p>
                                                <p><span class="text-black">Biaya Admin</span> : <span
                                                        id="reviewPercentage">Tidak Ada Biaya Admin</span></p>
                                                <p><span class="text-black"> Durasi</span> : <span
                                                        id="reviewDurasi">Tidak Ada Durasi</span></p>

                                                <button type="submit" class="btn btn-primary mt-5">Tambah Program
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
