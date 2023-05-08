@extends('168_template')
@include('168_component.util.wyswyig')


@section("header_name")
    {{$data->title}}
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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{$data->title}}</a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="post-details">
                                <h2 class="mb-2 text-black text-bold">{{$data->title}}</h2>
                                <ul class="post-meta d-flex flex-wrap">
                                    <li class="post-author me-3">{{$data->author}}</li>
                                    <li class="post-date me-3"><i class="fa fa-calender"></i>{{$data->created_at}}</li>
                                    {{-- <li class="post-comment"><i class="fa fa-comments-o"></i> 28</li>--}}
                                </ul>
                                <img src="{{$data->img_path}}" alt="" class="img-fluid mb-3 w-100 rounded">
                                <a href="javascript:void(0);" class="btn btn-primary mt-2 light btn-xs mb-1">{{$data->type_desc}}</a>
                                <hr>
                                <div class="">
                                    {!! $data->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
