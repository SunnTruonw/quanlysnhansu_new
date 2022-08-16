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
=======
<section class="content">

    <style>
        .nav.nav-pills.ranges li{
            margin:  0 15px;
        }

        .nav.nav-pills.ranges li a{
            font-weight: 700;
            font-size: 18px;
        }
    </style>
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Tổng số nhân viên</span>
              <span class="info-box-number">
                {{$totalUser}}
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
              <span class="info-box-number">{{$totalRoom}}/ phòng</span>
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
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Đang cập nhật</span>
              <span class="info-box-number">...</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbs-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Đang cập nhật</span>
              <span class="info-box-number">....</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="card card-outline card-primary">
             <div class="card-header">
                <h3 class="card-title">Thống nhân viên xin nghỉ trong 5 nă gần đây</h3>
             </div>
             <!-- /.card-header -->
             <div class="card-body table-responsive p-0" style="height: 100vh ;">
                   <ul class="list-news-home list-group">


                    <canvas id="myChart" width="400" height="400"></canvas>

                       {{-- @foreach ($postNews as $item)
                       <li class="list-group-item">
                           <a href="{{route('admin.post.edit',['id'=>$item->id])}}"> <i class="fas fa-caret-right"></i> {{ $item->name }}</a>
                       </li>
                       @endforeach --}}

                   </ul>
             </div>
             <!-- /.card-body -->
          </div>
       </div>
       <div class="col-md-6">
           <div class="card card-outline card-primary">
               <div class="card-header">
                   <h3 class="card-title">Thống kê nhân viên nghỉ theo phòng ban</h3>
               </div>
               <div class="card-body table-responsive p-0" style="height: 100vh ;">
                   <ul class="list-news-home list-group">
                    <ul class="nav nav-pills ranges">
                        <li class="active"><a href="#" data-range='7'>7 Days</a></li>
                        <li><a href="#" data-range='30'>30 Days</a></li>
                        <li><a href="#" data-range='60'>60 Days</a></li>
                        <li><a href="#" data-range='90'>90 Days</a></li>
                      </ul>

                        <div div id="stats-container" style="height: 250px;"></div>
                        <div id="chart" style="height: 250px;"></div>
                       {{-- @foreach ($productNews as $item)
                       <li class="list-group-item">
                           <a href="{{route('admin.product.edit',['id'=>$item->id])}}"> <i class="fas fa-caret-right"></i> {{ $item->name }}</a>
                       </li>
                       @endforeach --}}
                   </ul>
               </div>
               <!-- /.card-body -->
           </div>
       </div>
      </div>

    </div><!--/. container-fluid -->
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

<script>
    Morris.Bar({
      element: 'chart',
      data: [
        { date: '04-02-2014', value: 3 },
        { date: '04-03-2014', value: 10 },
        { date: '04-04-2014', value: 5 },
        { date: '04-05-2014', value: 17 },
        { date: '04-06-2014', value: 6 }
      ],
      xkey: 'date',
      ykeys: ['value'],
      labels: ['Orders']
    });

</script>

@endsection
