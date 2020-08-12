@extends('layouts.app')

@section('template_title')
    {{ Auth::user()->name }}'s' Timesheets
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    <div class="container">

        <h3>Edit Timesheet</h3>

        <div class="jumbotron">
            <div class="row">
                <div class="col-6 text-center">
                    <h4>Start Date</h4>{{ $timesheet->start }}
                </div>
                <div class="col-6 text-center">
                    <h4>End Date</h4>{{ $timesheet->end }}
                </div>
            </div>
        </div>

        @foreach(new DatePeriod(new DateTime($timesheet->start), DateInterval::createFromDateString('1 day'), new DateTime($timesheet->day_after->format('Y-m-d'))) as $dt)

            <div class="jumbotron">
                <div class="row mt-2">
                    <div class="col-4 text-center">
                        <h4>{{ $dt->format("l, F j, Y") }}</h4>
                        <button class="btn" data-toggle="modal" data-target="#modal_{{ $dt->format("Y-m-d") }}" data-backdrop="static">Add Entry</button>
                    </div>
                    <div class="col-8">Entries go here.</div>
                </div>
            </div>

            <!-- The Modal -->
            <div class="modal" id="modal_{{ $dt->format("Y-m-d") }}">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <form>

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title"><h2>Add Entry for: {{ $dt->format("l, F j, Y") }}</h2></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                                @csrf
                                <input type="hidden" name="timesheet_id" value="{{ $timesheet->id }}" />
                                <input type="hidden" name="entry_date" value="{{ $dt->format("Y-m-d") }}" />

                                <div class="row">
                                    <div class="col-6">
                                        <h4>Clock In</h4>
                                    </div>
                                    <div class="col-6">
                                        <input id="clock_in{{ $dt->format("Y-m-d") }}" name="clock_in" width="276" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <h4>Clock Out</h4>
                                    </div>
                                    <div class="col-6">
                                        <input id="clock_out{{ $dt->format("Y-m-d") }}" name="clock_out" width="276" />
                                    </div>
                                </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Entry</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

@section('footer_scripts')
    <script>
        @foreach(new DatePeriod(new DateTime($timesheet->start), DateInterval::createFromDateString('1 day'), new DateTime($timesheet->day_after->format('Y-m-d'))) as $dt)
        $('#clock_in{{ $dt->format("Y-m-d") }}').timepicker();
        $('#clock_out{{ $dt->format("Y-m-d") }}').timepicker();

        $("#clock_out{{ $dt->format(\"Y-m-d\") }}").change(function(){
            if($('#clock_out{{ $dt->format("Y-m-d") }}').val() <= $('#clock_in{{ $dt->format("Y-m-d") }}').val()) {
                alert('You must clock out AFTER you clock in.');
            }
        });

        @endforeach
    </script>
@endsection
