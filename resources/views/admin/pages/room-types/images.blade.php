@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}} <strong class="text-secondary">[ {{ $type_room['name'] }} ]</strong></h1>
    @error('fileUpload')
        <div class="error mt-3">{{ $message }}</div>
    @enderror
    <div class="col-md-11 mt-5 mx-auto">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5">
                    <h3 class="text-uppercase text-center">Ảnh đại diện</h3>
                    <div class="row mx-auto mt-5">
                        @if($thumbnail)
                            <form id="thumb-form" enctype="multipart/form-data" class="position-relative w-100 p-0"
                                  action="{{ route('admin.room-type.images.thumb', ['typeRoom' => $type_room]) }}"
                                  method="POST">
                                @csrf
                                <img class="mx-auto mb-2 w-100" src="{{ asset($thumbnail->path) }}"
                                     alt="Click nút bên trên để đổi ảnh">
                                <input id="thumb-upload" type="file" name="fileUpload" accept="image/*" hidden/>
                                <label for="thumb-upload">
                                    <span id="update-thumb" class="image-delete-btn w-100">Thay Ảnh Mới</span>
                                </label>
                            </form>
                        @else
                            <form id="thumb-form" class="w-100 d-flex image-area"
                                  action="{{ route('admin.room-type.images.thumb', ['typeRoom' => $type_room]) }}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <input id="thumb-upload" type="file" name="fileUpload" accept="image/*" hidden=""/>
                                <label for="thumb-upload" id="file-drag"
                                       class="w-100 d-flex align-items-center justify-content-center">
                            <span id="file-upload-btn" class="btn btn-primary">
                                <i class="fa-sharp fa-solid fa-image"></i>
                                 Chọn 1 file ảnh
                            </span>
                                </label>
                            </form>
                        @endif

                    </div>
                </div>

                <div class="col-md-7">
                    <h3 class="text-uppercase text-center">Ảnh chi tiết</h3>
                    <div class="col-md-12 mt-5">
                        <div class="row">
                            @foreach($details as $image)
                                <form class="position-relative col-md-5 p-0 mx-auto" method="POST"
                                      action="{{ route('admin.room-type.images.delete', $image) }}">
                                    @csrf @method('DELETE')
                                    <img class="mx-auto mb-1 w-100" style="height: 150px" src="{{asset( $image->path )}}" alt="Click nút bên dưới để xóa ảnh">
                                    <label>
                                        <button type="submit" class="image-delete-btn w-100">Xóa</button>
                                    </label>
                                </form>
                            @endforeach
                            @if(count($details) < config('constants.max_room_img'))
                                <form class="col-md-5 d-flex image-area mx-auto" style="height: 150px" method="POST"
                                      id="detail-form" enctype="multipart/form-data" action="{{ route('admin.room-type.images.detail', $type_room) }}">
                                    @csrf
                                    <input id="detail-upload" type="file" name="fileUpload" accept="image/*" hidden=""/>
                                    <label for="detail-upload" id="file-drag"
                                           class="w-100 d-flex align-items-center justify-content-center">
                                    <span id="file-upload-btn" class="btn btn-primary">
                                        <i class="fa-sharp fa-solid fa-image"></i>
                                        Chọn 1 file ảnh
                                    </span>
                                    </label>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#thumb-upload').change(function () {
                $('#thumb-form').submit();
            });
        });

        $(document).ready(function () {
            $('#detail-upload').change(function () {
                $('#detail-form').submit();
            });
        });
    </script>
@endpush
