@extends('168_template')
@include('168_component.util.wyswyig')


@section("header_name")
    Timeline
@endsection

@push("script")
    <script>
        var el = document.getElementById('formFile168');
        el.onchange = function () {
            var fileReader = new FileReader();
            fileReader.readAsDataURL(document.getElementById("formFile168").files[0])
            fileReader.onload = function (oFREvent) {
                document.getElementById("imgPreview").src = oFREvent.target.result;
            };
        }
    </script>
@endpush

@section("page_content")
    <div class="content-body" style="min-height: 798px;">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Konten</a></li>
                    <li class="breadcrumb-item active"><a href="#">{{$data->title}}</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
                </ol>
            </div>
            <!-- row -->
            <form action="{{ url('sodaqo/creation/timeline/update') }}"
                  enctype="multipart/form-data" method="post">
                @csrf
                <input hidden name="id" value="{{$data->id}}">
                <div class="row">
                    <div class="col-12">
                        @include("168_component.alert_message.message")
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Konten</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <div class="mb-3 col-md-6 col-12">
                                            <label
                                                class="form-label">Judul</label>
                                            <input name="title" type="text"
                                                   placeholder="Judul"
                                                   class="form-control" value="{{$data->title}}">
                                        </div>
                                        <div class="mb-3 col-md-6 col-12">
                                            <label
                                                class="form-label">Pengeluaran</label>
                                            <input name="expense" type="text"
                                                   placeholder="Pengeluaran"
                                                   class="form-control" value="{{$data->expense}}">
                                            <div class="form-text">Masukkan
                                                Jumlah
                                                pengeluaran
                                                jika pada
                                                timeline ini terdapat
                                                pengeluaran
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-6 col-12">
                                            <label class="form-label">Biaya
                                                Operasional/Admin</label>
                                            <input name="expense_admin"
                                                   type="text"
                                                   placeholder="Masukkan jika ada"
                                                   class="form-control" value="{{$data->expense_admin}}">
                                            <div class="form-text">Masukkan
                                                Jumlah
                                                pengeluaran
                                                operasional/admin jika pada
                                                timeline ini
                                                terdapat
                                                pengeluaran
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label
                                                class="form-label">Timeline</label>
                                            <textarea name="story"
                                                      id="summernote3"
                                                      cols="30"
                                                      rows="5"
                                                      class="form-control bg-transparent"
                                                      placeholder="Tambahkan Deskripsi Pengeluaran">{!! $data->content !!}</textarea>
                                            <div class="form-text">Story
                                                Timeline,
                                                Jelaskan
                                                kegiatan
                                                yang dilakukan jika ada,
                                                misalnya
                                                pembagian
                                                makanan
                                                atau lainnya
                                            </div>
                                        </div>


                                    </div>

                                    <button class="btn btn-primary"
                                            type="submit">
                                        Tambahkan
                                        Timeline
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </form>
        </div>
    </div>
@endsection
