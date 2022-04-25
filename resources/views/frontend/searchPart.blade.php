<style>
    .start-containt-search select {
        width: 100%;
    }
    .contain-sec .search-btn {
        width: 100%;
    }
</style>
<div class="row start-containt-search py-2">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form>
            <div class="row">
                <div class="col-6">
                    <select name="country_id" id="country_id" required>
                        <option selected hidden>الدولة</option>
                        @forelse (\App\Models\Country::whereStatus('1')->get(['id', 'name']) as $country)
                            <option value="{{ $country->id }}"
                                {{ old('country_id') == $country->id ? 'selected' : null }}>
                                {{ $country->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="col-6">
                    <select name="state_id" id="state_id" class="form-control" required>
                    </select>
                </div>
                <div class="col-6 mt-3">
                    <select name="city_id" id="city_id" class="form-control" required>
                    </select>
                </div>
                <div class="col-6 mt-3">
                    <button class="search-btn"> بحث</button>
                </div>
            </div>
        </form>
    </div>
</div>





