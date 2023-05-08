@extends('168_template')


@section("header_name")
    Edit Merchant
@endsection

@section("breadcumb")

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
    @include('168_component.util.wyswyig')
@endpush

@section("page_content")
    <div class="content-body" style="min-height: 798px;">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Payment Merchant</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{$data->name}}</a></li>
                </ol>
            </div>

            <div class="row">
                @include('168_component.alert_message.message')
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="tab-content">
                                    <div id="profile-settings" class="tab-pane fade active show">
                                        <form action='{{ url("payment-merchant/$data->id/update") }}' enctype="multipart/form-data" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$data->id}}">
                                            <div class="pt-0">
                                                <div class="settings-form">
                                                    <div class="row">

                                                        <div class="col-12">
                                                            <img
                                                                style="width: 108px!important; height: 108px !important;" id="imgPreview"
                                                                src="{{asset($data->photo)}}"
                                                                class="img-thumbnail" alt="">

                                                            <h4 class="text-primary mt-3">{{$data->name}}</h4>

                                                        </div>

                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Foto</label>
                                                            <div class="input-group">
                                                                <div class="form-file">
                                                                    <input id="formFile168" type="file" accept="image/*" name="photo"
                                                                           class="form-file-input form-control">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label" for="basicInput">Nama
                                                                Merchant</label>
                                                            <input type="text" name="name" required
                                                                   class="form-control"
                                                                   value="{{ old('name',$data->name) }}"
                                                                   placeholder="Nama Merchant">
                                                        </div>

                                                        <div class="mb-3 col-md-6">
                                                            <label for="">Status</label>
                                                            <select
                                                                class="form-control default-select form-control wide mb-3"
                                                                name="status" required id="">
                                                                <option>Pilih Status</option>
                                                                <option @if($data->status==1) selected
                                                                        @endif value="1">Aktif
                                                                </option>
                                                                <option @if($data->status==2) selected
                                                                        @endif value="2">Non-Aktif / Dihapus
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3 col-md-12">
                                                            <label for="">Deskripsi</label>
                                                            <textarea class="form-control" name="m_description" id="summernote" rows="10"
                                                                      placeholder="Deskripsi">{!!  old('m_description',$data->m_description)!!}</textarea>
                                                        </div>

                                                    </div>

                                                    <button class="btn btn-primary" type="submit">
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
