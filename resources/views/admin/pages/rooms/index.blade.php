@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-3 d-flex align-items-center">
            <h4 class="text-left m-0 text-bold text-uppercase">{{$title}}</h4>
        </div>
        <form class="col-md-9 d-flex justify-content-around align-items-center" method="GET">
            <div class="col-md-12 p-0">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <span class="mr-2">Sắp xếp theo: </span>
                        <select class="form-control w-25" name="by">
                            <option value="id" {{ (request()->input('by') == 'id') ? 'selected' : '' }}>ID</option>
                            <option value="name" {{ (request()->input('by') == 'name') ? 'selected' : '' }}>Tên</option>
                            <option
                                value="room_type" {{ (request()->input('by') == 'room_type') ? 'selected' : '' }}>
                                Loại phòng
                            </option>
                            <option value="branch" {{ (request()->input('by') == 'branch') ? 'selected' : '' }}>
                                Chi nhánh
                            </option>
                            <option value="city" {{ (request()->input('by') == 'city') ? 'selected' : '' }}>
                               Thành phố
                            </option>
                        </select>
                        <select class="form-control w-25" name="sort">
                            <option value="0" {{ (request()->input('sort') == '0') ? 'selected' : '' }}>Tăng dần
                            </option>
                            <option value="1" {{ (request()->input('sort') == '1') ? 'selected' : '' }}> Giảm dần
                            </option>
                        </select>
                        <button type="submit" class="btn btn-info">
                            <i class="fa-solid fa-filter"></i>
                            Lọc
                        </button>
                    </div>

                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <span class="mr-2">Trạng thái: </span>
                            @foreach(\App\Enums\Room\RoomStatus::asArray() as $key=>$status)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="status[]"
                                           value="{{ $status['key'] }}" id="defaultCheck{{$key}}"
                                        {{ request()->get('status') === null || in_array($status['key'], request()->get('status')) ? 'checked' : ''  }}>
                                    <label class="form-check-label" for="defaultCheck{{$key}}">
                                        {{ $status['value'] }}
                                    </label>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark text-center">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên phòng</th>
            <th scope="col">Phân loại phòng</th>
            <th scope="col">Chi nhánh</th>
            <th scope="col">Trạng thái</th>
            <th>
                <a class="btn btn-primary" href="{{ route('admin.room.create') }}">
                    <i class="fa-solid fa-square-plus"></i>
                    Thêm phòng
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
            <tr>
                <th scope="row">{{ $room['id'] }}</th>
                <td class="text-capitalize">{{ $room['name'] }}</td>
                <td class="text-capitalize">{{ $room['room_type']}}</td>
                <td class="text-capitalize">{{ $room['branch'] . ' - ' . $room['city']}}</td>

                <td class="text-capitalize">
                    @livewire('room.room-status', ['roomId' => $room['id']])
                </td>
                <td>
                    <a type="button" class="btn btn-success mb-1" href="{{ route('admin.room.edit', $room['id']) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <a type="button" class="btn btn-info mb-1" href="{{ route('admin.room.devices', $room['id']) }}">
                        <i class="fa-regular fa-hard-drive"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $rooms->links('pagination::bootstrap-4') !!}
@endsection

