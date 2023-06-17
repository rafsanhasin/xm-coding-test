@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <canvas id="myChart" ></canvas>
        </div>
    </div>
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered border text-nowrap mb-0 data-table" id="new-edit">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Open</th>
                                <th>High</th>
                                <th>Low</th>
                                <th>Close</th>
                                <th>Volume</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pricesWithinDateRange as $price)
                                <tr>
                                    <td>{{ $price['date']  }}</td>
                                    <td>{{ $price['open'] }}</td>
                                    <td>{{ $price['high'] }}</td>
                                    <td>{{ $price['low'] }}</td>
                                    <td>{{ $price['close'] }}</td>
                                    <td>{{ $price['volume'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@stop

<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script>
    $( document ).ready(function() {
        var table = $('.data-table').DataTable({
            order: [[0, 'desc']],
        });

        let prices = <?php echo json_encode($pricesWithinDateRange); ?>;

        const xAxis = [];
        let open = [];
        let close = [];

        for (let i = 0; i < prices.length; i++) {
            xAxis.push(prices[i]['date']);
            open.push(prices[i]['open']);
            close.push(prices[i]['close']);
        }

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xAxis,
                datasets: [{
                    data: open,
                    borderColor: "green",
                    fill: false,
                    label: "Open",
                }, {
                    data: close,
                    borderColor: "red",
                    fill: false,
                    label: "Close",
                }]
            },
            options: {
                legend: {
                    display: true,
                }
            }
        });
    });
</script>
