<div>
    <form id="form-search" class="col-md-12 mt-2" action="{{ route('search') }}" method="">
        @csrf
        <div class="col-md-6 m-auto py-3 px-5 search-section">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="row">
                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Bạn muốn đi đâu?</span>
                            </label>
                            <select class="col-md-10 form-control" name="city">
                                @foreach($branchCities as $branch_city)
                                    <option class="text-capitalize "
                                            {{ request()->get('city') == $branch_city ? 'selected' : ''}}
                                            value="{{ $branch_city }}">{{ $branch_city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-people-line"></i>
                                <span>Số người</span><span class="text-warning" style="font-size: 11px"> *Mỗi người lớn tối đa đi cùng 2 trẻ em </span>
                            </label>
                            <div class="d-flex justify-content-center">
                                <div class=" col-md-6 input-with-icon">
                                    <i class="fa-solid fa-person"></i>
                                    <input type="number" name="adults"
                                           class="w-100 find-input border-right-0 rounded-left" placeholder="Người lớn"
                                           required value="{{ request()->get('adults') ?? null}}"
                                           min="0" wire:change="setMaxChildren($event.target.value)">
                                </div>
                                <div class=" col-md-6 input-with-icon">
                                    <i class="fa-solid fa-children"></i>
                                    <input type="number" name="children" min="0" max="{{ $maxChildren }}"
                                           class="w-100 find-input border-left-0 rounded-right" placeholder="Trẻ em"
                                           value="{{ request()->get('children') ?? null}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-calendar-plus"></i>
                                <span>Ngày nhận phòng</span>
                            </label>
                            <input type="datetime-local" name="checkin" class="col-md-10 form-control find-input"
                                   min="{{ $minCheckin }}" wire:change="setMinCheckOut($event.target.value)"
                                   value="{{ request()->get('checkin') ?? null}}" required>

                        </div>
                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-calendar-minus"></i>
                                <span>Ngày trả phòng</span>
                            </label>
                            <input type="datetime-local" name="checkout" class="w-100 form-control find-input"
                                   value="{{ request()->get('checkout') ?? null}}" min="{{ $minCheckout }}" required>
                        </div>
                        <div class="col-md-12 pb-2">
                            <div class="col-md-12 text-center pt-2">
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
    </form>
</div>
