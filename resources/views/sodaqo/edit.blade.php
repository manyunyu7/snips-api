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

    <script>
        document.querySelector('.bd-example-modal-lg.bd-example-modal-lg').addEventListener('show.bs.modal', function (e) {
            var title = e.relatedTarget.dataset.title;
            var expense = e.relatedTarget.dataset.expense;
            var expenseAdmin = e.relatedTarget.expenseadmin;
            var contenty = e.relatedTarget.contentx;
            var id = e.relatedTarget.vvm;


            // Check if the expense variable is not null
            if (expense) {
                // Set the value of the element
                this.querySelector('.mt_expense').value = expense;
            }

            // Check if the expenseAdmin variable is not null
            if (expenseAdmin) {
                // Set the value of the element
                this.querySelector('.mt_expense_admin').value = expenseAdmin;
            }
            this.querySelector('.mt_title').value = title;
            $('.mt_story').val(contenty);
        });

    </script>


    <script>

        const input = document.getElementById('search-temlen');
        input.addEventListener('input', () => {
            var searchQuery = document.getElementById('search-temlen').value;
            var timelineItems = document.querySelectorAll('.temlen');
            var filteredTimelineItems = [];
            if (searchQuery.trim() === '') {
                // Show default timeline items when search query is empty
                filteredTimelineItems = timelineItems;
            } else {
                // Filter timeline items based on search query
                for (var i = 0; i < timelineItems.length; i++) {
                    var item = timelineItems[i];
                    if (item.textContent.toLowerCase().includes(searchQuery.toLowerCase())) {
                        filteredTimelineItems.push(item);
                    }
                }
            }
            var timelineContainer = document.querySelector('.card-body');
            timelineContainer.innerHTML = '';
            for (var i = 0; i < filteredTimelineItems.length; i++) {
                timelineContainer.appendChild(filteredTimelineItems[i]);
            }
        });

    </script>
@endpush

@section("page_content")
    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <div class="container-fluid">

            <!-- row -->
            <div class="row">
                <div class="col-12">
                    @include("168_component.alert_message.message")
                </div>

                <div class="col-xl-12 col-12">
                    <div class="mt-4">
                        <img src="{{$data->photo_path}}" style="max-height: 300px" alt=""
                             class="img-fluid mb-3 w-100 rounded">
                    </div>

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="profile-name px-lg-3 pt-2">
                                    <h1 class="text-primary mb-0">{{$data->name}}</h1>
                                    <h5 class="mt-2 text-dark">{{$data->category_name}}
                                        | {{$data->fundraising_target_formatted}}</h5>

                                    <a href="{{url('/sodaqo'.'/'.$data->id.'/transaction/manage')}}">
                                        <button class="btn btn-outline-dark me-2 mt-2">
                                            {{--                                        <span class="me-2"><i class="fa fa-heart"></i></span>--}}
                                            Lihat Transaksi dan Donasi
                                        </button>
                                    </a>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="#about-me" data-bs-toggle="tab"
                                                                    class="nav-link  active show">Tentang Program</a>
                                            </li>
                                            <li class="nav-item"><a href="#my-posts" data-bs-toggle="tab"
                                                                    class="nav-link">Timeline</a>
                                            </li>
                                            <li class="nav-item"><a href="#ganti_foto" data-bs-toggle="tab"
                                                                    class="nav-link">Foto</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="about-me" class="tab-pane fade active show">
                                                <div class="mt-4">
                                                    <img src="{{$data->photo_path}}" style="max-height: 300px" alt=""
                                                         class="img-fluid mb-3 w-100 rounded">
                                                </div>
                                                <div class="mt-4 mb-4">
                                                    <form action="{{ url('sodaqo/creation/update') }}"
                                                          enctype="multipart/form-data" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <textarea name="story" id="summernote" cols="30" rows="5"
                                                                  class="form-control bg-transparent"
                                                                  placeholder="Please type what you want....">{!! $data->story !!}</textarea>

                                                        <div class="row p-2 mt-4 m-2"
                                                             style="border: 2px solid; border-radius: 20px">

                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="basicInput">Nama
                                                                    Program</label>
                                                                <input id="inputName" type="text" name="name" required
                                                                       class="form-control"
                                                                       value="{{ old('name',$data->name) }}"
                                                                       placeholder="Judul/Nama Program">
                                                                <div class="form-text">Silakan isi nama program sesuai
                                                                    dengan
                                                                    data
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="basicInput">Batas Waktu
                                                                    Program</label>
                                                                <input id="inputDate" type="date" name="time_limit"
                                                                       class="form-control"
                                                                       value="{{ old('time_limit',$data->time_limit) }}"
                                                                       placeholder="Batas Waktu">
                                                                <div class="form-text">Kosongkan jika tidak ada batas
                                                                    waktu.
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="basicInput">Target
                                                                    Nominal
                                                                    Dana</label>
                                                                <input id="inputTarget" type="number" min="0.00"
                                                                       name="fundraising_target"
                                                                       class="form-control"
                                                                       value="{{ old('fundraising_target',$data->fundraising_target) }}"
                                                                       placeholder="Target Donasi">
                                                                <div class="form-text">Kosongkan jika tidak ada target
                                                                </div>
                                                            </div>


                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="basicInput">Persentase
                                                                    Biaya Admin
                                                                    (Jika Ada)</label>
                                                                <input id="inputFee" type="number"
                                                                       name="admin_fee"
                                                                       class="form-control"
                                                                       value="{{ old('admin_fee',$data->admin_fee_percentage) }}"
                                                                       placeholder="Admin Fee">
                                                                <div class="form-text">Contoh Input : 0.5 atau 5.0 atau
                                                                    2.5
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label" for="basicInput">Kategori
                                                                    Program</label>
                                                                <select
                                                                    class="form-control default-select form-control wide mb-3"
                                                                    name="merchant_id" id="" required>
                                                                    @forelse($categories as $x)
                                                                        <option

                                                                            @if($data->category_id == $x->id)
                                                                                selected
                                                                            @endif
                                                                            value="{{$x->id}}">

                                                                            {{$x->name}}</option>
                                                                    @empty

                                                                    @endforelse
                                                                </select>
                                                                <div class="form-text">Pilih salah satu kategori
                                                                    program
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 col-md-12">
                                                                <label class="form-label" for="basicInput">Status
                                                                    Program</label>
                                                                <select
                                                                    class="form-control default-select form-control wide mb-3"
                                                                    name="status" id="" required>
                                                                    <option value="1"
                                                                            @if($data->status=="1") selected @endif>
                                                                        Aktif
                                                                    </option>
                                                                    <option value="0"
                                                                            @if($data->status=="0") selected @endif>
                                                                        Tidak Aktif
                                                                    </option>
                                                                    <option value="3"
                                                                            @if($data->status=="3") selected @endif>
                                                                        Dihapus
                                                                    </option>
                                                                </select>
                                                                <div class="form-text">Pilih salah satu kategori
                                                                    program
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <button type="submit" class="btn btn-primary mt-2">Simpan
                                                            Perubahan
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div id="my-posts" class="tab-pane fade">
                                                <div class="pt-3">
                                                    <div class="settings-form">
                                                        <div class="accordion-item accordion-solid-bg">
                                                            <div class="accordion-header rounded-lg collapsed"
                                                                 id="accord-8One" data-bs-toggle="collapse"
                                                                 data-bs-target="#collapse8One"
                                                                 aria-controls="collapse8One"
                                                                 aria-expanded="false" role="button">
                                                                <span class="accordion-header-icon"></span>
                                                                <span class="accordion-header-text">Tambah Data Timeline (Admin)</span>
                                                                <span class="accordion-header-indicator"></span>
                                                            </div>
                                                            <div id="collapse8One" class="accordion__body collapse"
                                                                 aria-labelledby="accord-8One"
                                                                 data-bs-parent="#accordion-eight" style="">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <form
                                                                            action="{{ url('sodaqo/creation/timeline/store') }}"
                                                                            enctype="multipart/form-data" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="id"
                                                                                   value="{{$data->id}}">
                                                                            <div class="row">
                                                                                <div class="mb-3 col-md-6 col-12">
                                                                                    <label
                                                                                        class="form-label">Judul</label>
                                                                                    <input name="title" type="text"
                                                                                           placeholder="Judul"
                                                                                           class="form-control">
                                                                                </div>
                                                                                <div class="mb-3 col-md-6 col-12">
                                                                                    <label
                                                                                        class="form-label">Pengeluaran</label>
                                                                                    <input name="expense" type="text"
                                                                                           placeholder="Pengeluaran"
                                                                                           class="form-control">
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
                                                                                           class="form-control">
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
                                                                                              placeholder="Tambahkan Deskripsi Pengeluaran"></textarea>
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
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <div class="card">
                                                            <div class="card-header border-0 pb-0">
                                                                <h4 class="card-title">Timeline</h4>
                                                            </div>
                                                            <div class="card-body">


{{--                                                                <div class="input-group search-area">--}}
{{--                                                                    <input id="search-temlen" type="text" class="form-control" placeholder="Search here...">--}}
{{--                                                                    <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2 btn-search-temlen"></i></a></span>--}}
{{--                                                                </div>--}}


                                                            @forelse ($timelines as $item)
                                                                    <div class="mb-3 temlen"
                                                                         style="border: 2px solid lightgrey; border-radius: 20px; padding: 10px">
                                                                        <a target="_blank"
                                                                            href="{{url('sodaqo/timeline'.'/'.$item->id.'/change')}}">
                                                                            <button class="btn btn-outline-dark me-2 mt-2 mb-2">
                                                                                {{--                                        <span class="me-2"><i class="fa fa-heart"></i></span>--}}
                                                                                Edit Timeline
                                                                            </button>
                                                                        </a>
                                                                        <h4> {{$item->title}}</h4>
                                                                        <h3> {{$item->sub_title}}</h3>
                                                                        <hr>
                                                                        {!! $item->content  !!}
                                                                    </div>
                                                                @empty

                                                                @endforelse
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div id="ganti_foto" class="tab-pane fade">
                                                <div class="pt-3">
                                                    <form action="{{ url('sodaqo/creation/photo/edit') }}"
                                                          enctype="multipart/form-data"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4 class="card-title"></h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="basic-form">
                                                                    <div class="col-12">
                                                                        <img
                                                                            id="imgPreview"
                                                                            src="{{$data->photo_path}}"
                                                                            alt="image" class="me-3 rounded"
                                                                            width="275">
                                                                    </div>

                                                                    <label class="col-form-label mt-4">Foto Baru</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group">
                                                                            <div class="form-file">
                                                                                <input id="formFile168" type="file"
                                                                                       name="photo"
                                                                                       class="form-file-input form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary mt-5">
                                                                        Simpan Konten
                                                                    </button>
                                                                </div>
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
            </div>
        </div>


        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ url('sodaqo/creation/timeline/update') }}"
                      enctype="multipart/form-data" method="post">
                    @csrf
                    <input hidden class="aidiz" name="id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Data Donasi <span class="title-aidi"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input id="formIdTimeline" type="hidden" name="id" value="">
                            <div class="row">
                                <div class="mb-3 col-md-6 col-12">
                                    <label class="form-label">Judul</label>
                                    <input name="title" type="text"
                                           placeholder="Judul"
                                           class="form-control mt_title">
                                    <div class="form-text">
                                        Judul Timeline
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6 col-12">
                                    <label
                                        class="form-label">Pengeluaran</label>
                                    <input name="expense" type="text"
                                           placeholder="Pengeluaran"
                                           class="form-control mt_expense">
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
                                           class="form-control mt_expense_admin">
                                    <div class="form-text">
                                        Masukkan Jumlah pengeluaran
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
                                              cols="30"
                                              rows="5"
                                              class="form-control bg-transparent mt_story"
                                              placeholder="Tambahkan Deskripsi Pengeluaran"></textarea>
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
                                Simpan Perubahan
                            </button>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary mitmit " data-bs-dismiss="modal">Save changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!--**********************************
            Content body end
        ***********************************-->
@endsection



