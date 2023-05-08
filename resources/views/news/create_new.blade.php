@extends('168_template')
@include('168_component.util.wyswyig')


@section("header_name")
    Tambah Konten Baru
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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Buat Konten</a></li>
                </ol>
            </div>
            <!-- row -->
            <form action="{{ url('news/store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        @include("168_component.alert_message.message")
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Data Konten</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="form-label">Judul Konten</label>
                                            <input type="text" name="title" required class="form-control"
                                                   value="{{ old('title') }}"
                                                   placeholder="Judul Berita">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="form-label">Penulis/Sumber Konten</label>
                                            <input type="text" name="author" required class="form-control"
                                                   value="{{ old('author') }}"
                                                   placeholder="Sumber Berita">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Tipe Konten</label>
                                            <select class="form-control default-select form-control wide mb-3" name="type" required id="">
                                                <option>Pilih Jenis Konten</option>
                                                <option value="1">Berita</option>
                                                <option value="2">Kajian</option>
                                                <option value="3">Informasi Event</option>
                                                <option value="4">Tentang Aplikasi</option>
                                                <option value="5">Quran/Hadits</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label class="col-form-label">ID Kegiatan/Konten Terkait</label>
                                        <input name="reff" type="text" class="form-control"
                                               placeholder="Content Referral">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="col-12">
                                        <img
                                            id="imgPreview"
                                            src="https://i.stack.imgur.com/y9DpT.jpg" alt="image" class="me-3 rounded"
                                            width="275">
                                    </div>

                                    <label class="col-form-label mt-4">Foto Baru</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="form-file">
                                                <input id="formFile168" type="file" name="photo"
                                                       class="form-file-input form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Content</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="mb-3 col-md-12">
                                        <label for="">Deskripsi</label>
                                        <textarea class="form-control" name="news_content" id="summernote" rows="10"
                                                  placeholder="Deskripsi">{{old('news_content')}}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-5">Simpan Konten</button>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </form>
        </div>
    </div>
@endsection
