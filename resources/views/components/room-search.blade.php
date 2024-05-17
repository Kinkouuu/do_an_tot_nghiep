<div>
    <form id="form-search" class="col-md-12 mt-2">
        <div class="col-md-6 m-auto py-3 px-5 search-section">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="row">
                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Bạn muốn đi đâu?</span>
                            </label>
                            <select class="selectpicker col-md-10 p-0" name="" data-live-search="true" data-style="bg-white border border-left-0" style="height: 47px">
                               @foreach($branch_cities as $branch_city)
                                    <option class="text-capitalize">{{ $branch_city->first()->city }}</option>
                               @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-people-line"></i>
                                <span>Số người</span>
                            </label>
                            <div class="d-flex justify-content-center">
                                <input type="number" class="col-md-6 find-input border-right-0 rounded-left" placeholder="Người lớn">
                                <input type="number" class="col-md-6 find-input border-left-0 rounded-right" placeholder="Trẻ em">
                            </div>
                        </div>
                        <div class="col-md-6 pb-2">
                            <div class="row">
                                <div class="col-12">
                                    <label class="text-white">
                                        <i class="fa-solid fa-calendar-plus"></i>
                                        <span>Ngày nhận phòng</span>
                                    </label>
                                    <div class="d-flex justify-content-between">
                                        <input type="datetime-local" class="col-md-10 form-control find-input">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="text-white">
                                        <i class="fa-solid fa-calendar-minus"></i>
                                        <span>Ngày trả phòng</span>
                                    </label>
                                    <div class="d-flex justify-content-between">
                                        <input type="datetime-local" class="col-md-10 form-control find-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pb-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="text-white">
                                        <i class="fa-solid fa-hotel"></i>
                                        <span>Loại phòng</span>
                                    </label>
                                    <select class="selectpicker col-md-12 p-0" name="" data-live-search="true" data-style="bg-white border border-left-0" style="height: 47px">
                                       @foreach($types as $type)
                                           <option class="text-capitalize">{{ $type['name'] }}</option>
                                       @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 text-center pt-5">
                                    <button class="btn btn-warning text-white">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
