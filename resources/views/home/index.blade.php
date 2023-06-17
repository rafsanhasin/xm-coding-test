@extends('layouts.default')
@section('content')
    <style>
        .was-validated .custom-select:invalid + .select2 .select2-selection{
            border-color: #dc3545!important;
        }
        .was-validated .custom-select:valid + .select2 .select2-selection{
            border-color: #28a745!important;
        }
        *:focus{
            outline:0px;
        }
    </style>
    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="was-validated" action="{{ route('stats') }}">
                        {{ csrf_field() }}
                        @if (count($errors) > 0)
                            <div class = "alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6">
                                                <label class="form-label">Company Symbol</label>
                                                <select class="form-control form-select select2 custom-select" data-bs-placeholder="Select Company Symbol" name="company_symbol" id="company_symbol" required>
                                                    <option value="">Select Company Symbol</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{$company['Symbol']}}" {{ (old('company_symbol') == $company['Symbol'] ? 'selected':'') }}>{{$company['Symbol']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="{{old('email')}}" required>
{{--                                                <div class="valid-feedback">Valid.</div>--}}
                                                <div class="invalid-feedback">Valid email is required</div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <label class="form-label">Start Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <input type="text" class="form-control" id="start_date" name="start_date" value="{{old('start_date')}}" required>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <label class="form-label">End Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <input type="text" class="form-control end-date" id="end_date" name="end_date" value="{{old('end_date')}}" required>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center" style="padding-top: 15px;">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Row-->
@stop

<script
    src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
    crossorigin="anonymous"></script>

<link href="{{asset("assets/plugins/select2/select2.min.css")}}" rel="stylesheet" type="text/css"/>
<script src="{{asset("assets/plugins/select2/select2.min.js")}}"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
    $( document ).ready(function() {
        $('.select2').select2({
            language: {
                searching: function() {
                    return "Result loading...";
                }
            },
            minimumInputLength: 2,
            minimumResultsForSearch: 5,
        });

        $( "#start_date" ).datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0,
            onClose: function( selectedDate ) {
                jQuery( "#end_date" ).datepicker( "option", "minDate", selectedDate );
            },
        });

        $( "#end_date" ).datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: 0,
            onClose: function( selectedDate ) {
                jQuery( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
            },
        });

    });
</script>
