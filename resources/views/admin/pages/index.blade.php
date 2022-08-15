@extends('admin.layouts.main')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tổng số nhân viên</span>
                            <span class="info-box-number">
                                {{ $totalRoot }}
                                <small>/người</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tổng số phòng ban</span>
                            <span class="info-box-number">{{ $totalRoom }}/ phòng</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tổng số tài khoản Admin</span>
                            <span class="info-box-number">{{ $totalAdmin }}
                                <small>/người</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tổng tài khoản User</span>
                            <span class="info-box-number">{{ $totalUser }}
                                <small>/người</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê số nhân viên nghỉ trong tháng</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 100vh ;">
                            <ul class="list-news-home list-group">

                                <div>
                                    <canvas id="myChart"></canvas>
                                </div>


                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê số nhân viên nghỉ theo 10 phòng ban</h3>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 100vh ;">
                            <ul class="list-news-home list-group">

                                <div>
                                    <canvas id="myChartRoom" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 657px;" width="985" height="375" class="chartjs-render-monitor"></canvas>
                                </div>

                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!--/. container-fluid -->
    </section>
@endsection

@section('js')


    <script>
        var color = [];
        for (i = 0; i <= 19; i++) {
            color[i] = `rgb(${[1,2,3].map(x=>Math.random()*256|0)})`;
        }
        const dataDoughnut = <?= json_encode($dataRoom ?? []) ?>;
        const name = Object.keys(dataDoughnut).map((key) => String(key));
        const count = Object.keys(dataDoughnut).map((key) => dataDoughnut[key]);
        const datas = {
            labels: name,
            datasets: [{
                label: 'My First Dataset',
                data: count,
                backgroundColor: color,
                hoverOffset: 4
            }]
        };
        const configs = {
            type: 'doughnut',
            data: datas,
        };
        const myCharts = new Chart(
            document.getElementById('myChartRoom'),
            configs
        );
    </script>

    <script>
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        const labels = [
            'Tháng 1',
            'Tháng 2',
            'Tháng 3',
            'Tháng 4',
            'Tháng 5',
            'Tháng 6',
            'Tháng 7',
            'Tháng 8',
            'Tháng 9',
            'Tháng 10',
            'Tháng 11',
            'Tháng 12',
        ];

        const labelRooms = <?= json_encode($dataRoom ?? []) ?>;

        const data = {
            labels: labels,
            datasets: [{
                label: 'Thông kê số nhân viên nhiên nghỉ trong tháng',
                data: <?= json_encode($data ?? []) ?>,
                backgroundColor: getRandomColor,
                borderColor: getRandomColor,
                borderWidth: 1
            }]
        };

        const dataRoom = {
            labels: labelRooms,
            datasets: [{
                label: 'Thông kê số nhân viên nhiên nghỉ theo phòng ban',
                data: <?= json_encode($dataRoom ?? []) ?>,
                backgroundColor: getRandomColor,
                borderColor: getRandomColor,
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

        const configRoom = {
            type: 'bar',
            data: dataRoom,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );

        const myChartRoom = new Chart(
            document.getElementById('myChartRoom'),
            configRoom
        );
    </script>


    {{-- <script>
        $(function() {
            // Create a function that will handle AJAX requests
            function requestData(years, chart) {
                $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: "/apiBieuDo", // This is the URL to the API
                        data: {
                            years: years
                        }
                    })
                    .done(function(data) {
                        // When the response to the AJAX request comes back render the chart with new data
                        chart.setData(data);
                    })
                    .fail(function() {
                        // If there is no communication between the server, show an error
                        alert("error occured");
                    });
            }

            function requestDataUserRooms(chartUserRoom) {
                $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: "/user-rooms", // This is the URL to the API
                    })
                    .done(function(data) {
                        console.log(data);
                        // When the response to the AJAX request comes back render the chart with new data
                        chart.setData(data);
                    })
                    .fail(function() {
                        // If there is no communication between the server, show an error
                        alert("error occured");
                    });
            }

            var chartUserRoom = Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'stats-container-user-rooms',
                data: [0, 0], // Set initial data (ideally you would provide an array of default data)
                xkey: 'nameRoom', // Set the key for X-axis
                ykeys: ['value'], // Set the key for Y-axis
                labels: ['users'] // Set the label when bar is rolled over
            });

            var chart = Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'stats-container',
                data: [0, 0], // Set initial data (ideally you would provide an array of default data)
                xkey: 'getYear', // Set the key for X-axis
                ykeys: ['value'], // Set the key for Y-axis
                labels: ['users'] // Set the label when bar is rolled over
            });


            // Request initial data for the past 7 years:
            requestData(5, chart);
            requestDataUserRooms(chart);
            $('ul.ranges a').click(function(e) {
                e.preventDefault();
                // Get the number of years from the data attribute
                var el = $(this);
                years = el.attr('data-range');
                // Request the data and render the chart using our handy function
                requestData(years, chart);
            })
        });
    </script> --}}
@endsection
