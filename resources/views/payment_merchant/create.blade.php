@extends('main.app')

@section('page-breadcrumb')
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Payment Merchant</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item text-muted active" aria-current="page">Payment Merchant</li>
                        <li class="breadcrumb-item text-muted" aria-current="page">Add</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="customize-input float-right">

            </div>
        </div>
    </div>
@endsection

@section('page-wrapper')
    @include('main.components.message')

    <form action="{{ url('payment-merchant/store') }}" enctype="multipart/form-data" method="post">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Tambah Data Payment Merchant</h3>

                        <img src="https://i.stack.imgur.com/y9DpT.jpg"
                             style="border-radius: 20px" height="100px; !important" id="imgPreview"
                             class="img"  alt="Responsive image">

                        <div class="form-group">
                            <label for="formFile" class="form-label">Logo Payment Merchant</label>
                            <input name="photo" class="form-control" type="file" id="formFile">
                        </div>

                        <div class="form-group">
                            <label for="basicInput">Nama Payment Merchant</label>
                            <input type="text" name="name" required class="form-control"
                                   value="{{ old('name') }}"
                                   placeholder="Nama Merchant, misal OVO">
                        </div>

                        <div class="form-group">
                            <label for="">Status</label>
                            <select class="form-control" name="status" id="">
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif/Dihapus ( Tidak Ditampilkan di Pengguna)</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <textarea class="form-control" name="m_description" id="textarea" rows="10"
                                      placeholder="Deskripsi">{{old('m_description')}}</textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-primary">Tambahkan Merchant</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">



                    </div>
                </div>

            </div>



        </div>
    </form>





@endsection


@section('app-script')

    <script src="{{ URL::to('bootstrap_ui') }}/assets/libs/tinymce/tinymce.min.js"></script>
    <script src="{{ URL::to('bootstrap_ui') }}/assets/libs/tinymce/plugins/code/plugin.min.js"></script>
    <script>
        tinymce.init({selector: '#textarea'});
        tinymce.init({
            selector: '#dark',
            toolbar: 'undo redo styleselect bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
            plugins: 'code'
        });
    </script>

    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/r-2.2.7/sb-1.0.1/sp-1.2.2/datatables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js">
    </script>
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js">
    </script>

    <script>
        var el = document.getElementById('formFile');
        el.onchange = function () {
            var fileReader = new FileReader();
            fileReader.readAsDataURL(document.getElementById("formFile").files[0])
            fileReader.onload = function (oFREvent) {
                document.getElementById("imgPreview").src = oFREvent.target.result;
            };
        }


        $(document).ready(function () {
            $.myfunction = function () {
                $("#previewName").text($("#inputTitle").val());
                var title = $.trim($("#inputTitle").val())
                if (title == "") {
                    $("#previewName").text("Judul")
                }
            };

            $("#inputTitle").keyup(function () {
                $.myfunction();
            });

        });
    </script>





@endsection
