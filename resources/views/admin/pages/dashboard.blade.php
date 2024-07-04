@php
    use Carbon\Carbon;
@endphp
@extends('admin.layouts.main')

@section('content')
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-8">
                        <form class="row">
                            <div class="col-md-4">
                                <label>Chi nhánh</label>
                                <select class="col-md-12 form-control selectpicker border" name="branch" data-live-search="true">
                                    @foreach($branches as $branch)
                                        <option class="text-capitalize"
                                                {{ request()->get('branch') == $branch['id'] ? 'selected' : ''}}
                                                value="{{ $branch['id'] }}">{{ $branch['name'] . ' - ' . $branch['city'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Từ ngày</label>
                                <input type="date" name="from" class="form-control find-input"
                                       value="{{ request()->get('from') ?? null}}">
                            </div>
                            <div class="col-md-3">
                                <label>Đến ngày</label>
                                <input type="date" name="to" class="col-md-10 form-control find-input"
                                       value="{{ request()->get('to') ?? null}}">
                            </div>
                            <div class="col-2 mb-0 mt-auto p-0">
                                <button class="btn btn-success">
                                    <i class="fa-solid fa-chart-pie"></i>
                                    Thống kê
                                </button>
                            </div>
                        </form>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['booking']['total'] }}</h3>

                                <p>Số đơn đặt</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a class="small-box-footer" data-toggle="collapse" href="#booking-detail" role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Chi tiết
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $data['revenue']['total'] }}</h3>

                                <p>Doanh thu ước tính</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a class="small-box-footer" data-toggle="collapse" href="#revenue-detail" role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Chi tiết
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['user']['total'] }}</h3>

                                <p>Người dùng mới</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a class="small-box-footer" data-toggle="collapse" href="#user-detail" role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Chi tiết
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                        <div class="col-12 collapse" id="booking-detail">
                            <div class="card card-body">
                               <div class="row">
                                   <h3 class="text-center">
                                       THỐNG KÊ ĐƠN ĐẶT PHÒNG
                                   </h3>
                                   <div class="col-md-4">
                                       <ul>
                                           <li>
                                               Tổng số đơn: {{ $data['booking']['total'] }}
                                           </li>
                                           <li>
                                               Số đơn đặt qua website: {{ $data['booking']['on_web'] }}
                                               ( {{ $data['booking']['total'] >0 ? round($data['booking']['on_web'] / $data['booking']['total'], 4) * 100 :0  }}) %
                                           </li>
                                           <li>
                                               Đang chờ: {{ $data['booking']['awaiting'] }} đơn
                                           </li>
                                           <li>
                                               Đã xác nhận:  {{ $data['booking']['confirmed'] }} đơn
                                           </li>
                                           <li>
                                               Đã hoàn thành:  {{ $data['booking']['completed'] }} đơn
                                           </li>
                                           <li>
                                               Đã hủy:  {{ $data['booking']['canceled'] }} đơn
                                           </li>
                                       </ul>
                                   </div>
                                   <div class="col-md-8">
                                       <!-- -->
                                   </div>
                               </div>
                            </div>
                        </div>
                    <div class="col-12 collapse" id="revenue-detail">
                        <div class="card card-body">
                            <div class="row">
                                <h3 class="text-center">
                                    THỐNG KÊ DOANH THU
                                </h3>
                                <div class="col-md-4">
                                    <ul>
                                        <li>
                                            Tổng doanh thu: {{ number_format($data['revenue']['revenue'], 0 ,',', '.') }} VND
                                        </li>
                                        <li>
                                            Tiền thuê phòng: {{ number_format($data['revenue']['price'], 0 , ',','.') }} VND
                                        </li>
                                        <li>
                                            Phí nhận phòng sớm: {{ number_format($data['revenue']['early_fee'], 0 , ',','.') }} VND
                                        </li>
                                        <li>
                                            Phí trả phòng muộn:  {{ number_format($data['revenue']['lately_fee'], 0 , ',','.') }} VND
                                        </li>

                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <!-- -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 collapse" id="user-detail">
                        <div class="card card-body">
                            <div class="row">
                                <h3 class="text-center">
                                    THỐNG KÊ KHÁCH HÀNG
                                </h3>
                                <div class="col-md-4">
                                    <ul>
                                        <li>
                                            Số người dùng mới: {{ number_format($data['user']['total'], 0 ,',', '.') }} tài khoản
                                        </li>
                                        <li>
                                            Số người dùng đã đặt phòng: {{ number_format($data['user']['users_has_booked'], 0 , ',','.') }} người
                                        </li>
                                        <li>
                                            Phí người dùng đã xác thực tài khoản: {{ number_format($data['user']['users_verified'], 0 , ',','.') }} người
                                        </li>
                                        <li>
                                            Lượng khách thực tế:  {{ number_format($data['user']['adults_customers'], 0 , ',','.') }} người lớn và
                                            {{ number_format($data['user']['children_customers'], 0 , ',','.') }} trẻ em
                                        </li>

                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <!-- -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- Main row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
@endsection
