<script>
    AOS.init();
</script>

<script src="{{ asset('frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.js') }}"></script>

{{-- <script>
    $(function() {
        populateGetStates();
        populateGetCities();
        $("#country_id").change(function() {
            populateGetStates();
            populateGetCities();
            return false;
        });
        $("#state_id").change(function() {
            populateGetCities();
            return false;
        });

        function populateGetStates() {
            let countryIdVal = $('#country_id').val() != null ? $('#country_id').val() :
                '{{ old('country_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
            $.get("{{ route('frontend.frontGetState') }}", {
                country_id: countryIdVal
            }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                $('option', $('#state_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                $('#state_id').append($('<option selected hidden></option>').val('').html('المحافظة'));
                $.each(data, function(val, text) {
                    let selectedVal = text.id == '{{ old('state_id') }}' ? "selected" : "";
                    $("#state_id").append($('<option ' + selectedVal + '></option>').val(text
                        .id).html(text.name));
                });
            }, "json")
        }

        function populateGetCities() {
            let stateIdVal = $('#state_id').val() != null ? $('#state_id').val() :
                '{{ old('state_id') }}'; //عملت متغير يحمل قيمة رقم الدوله و في حالة بعت البيانات في الفورم و في حاجه غلط يرجع القيم اللي كنت مختارها قبل ما الفورم تتبعت
            $.get("{{ route('frontend.frontGetCity') }}", {
                state_id: stateIdVal
            }, function(data) { //هعمل فانكشن واديها قيمه الدوله كمتغير فيها
                $('option', $('#city_id')).remove(); //هحذف كل الاوبشن اللي موجدود في السيلكت
                $('#city_id').append($('<option selected hidden></option>').val('').html('المدينة'));
                $.each(data, function(val, text) {
                    let selectedVal = text.id == '{{ old('city_id') }}' ? "selected" : "";
                    $("#city_id").append($('<option ' + selectedVal + '></option>').val(text.id)
                        .html(text.name));
                });
            }, "json")
        }
    });
</script> --}}
