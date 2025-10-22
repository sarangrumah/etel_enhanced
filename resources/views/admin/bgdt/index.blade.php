@extends('layouts.landing.main')
@section('content')
<style>
    .content-inner{
        background-color: linear-gradient(0deg, #FFFFFF 44.93%, #A5A5A5 100%);
        background-image: url("/global_assets/images/landing/landing_background.svg");
        background-repeat: no-repeat;
        background-size: contain;
    }
    .btn-primary{
      background-color: #0166FE;
      padding: 12px 60px;
    }
    iframe {border:0; overflow:hidden;}
</style>
<div style="padding: 60px 0;margin-top: 20%;">
    <div style="background-color: #ECECEC; padding: 30px 40px; border-radius: 15px">
    <div class="header-elements-lg-inline">
        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            <div class="breadcrumb">
                <h4 style="display: flex;"><a href="{{ url('/') }}" class="breadcrumb-item">
                        <i class="icon-home4 mr-2"></i> 
                        <span class="font-weight-semibold">HASIL SURVEY</span>
                    </a>
                    <span class="breadcrumb-item active">{{$title}}</span>
                </h4>
            </div>
        </div>
        <div style="margin-top: -8px; display:flex">
          <div class="dropdown">
            <button class="btn btn-lg btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                Filter
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="changeFilter(1)">Quartal I</a>
                <a class="dropdown-item" href="#" onclick="changeFilter(2)">Quartal II</a>
                <a class="dropdown-item" href="#" onclick="changeFilter(3)">Quartal III</a>
                <a class="dropdown-item" href="#" onclick="changeFilter(4)">Quartal IV</a>
            </div>
            </div>
          <a class="btn btn-lg btn-primary" href={{url('/admin/bgdt-download')}}>DOWNLOAD</a>
        </div>
    </div>
    <h1 class="title-informasi"></h1>
    <div>
     <div id="scatter" style="height: 100%;display: flex;justify-content: center;"></div>   
     <iframe src="{{$iframe}}" frameborder="0" width="100%" style="height: 100vh;" id="yourIframe"></iframe>
    </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://raw.githubusercontent.com/alrusdi/jquery-plugin-query-object/master/jquery.query-object.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection
@section('custom-js')
<script>
    function changeFilter(params) {
        let url = new URL('{{$iframe}}');
        url.searchParams.set('var-quartal', params)
        console.log(url.toString());
        $('#yourIframe').attr('src', url+'&kiosk');  
    }

    Highcharts.chart('scatter', {
        title: {
            text: 'Quadran'
        },
        chart: {
            type: 'scatter',
            events: {
            load: function() {
                const chart = this;

                // chart.series[0].points.forEach(point => {
                // if (point.x > 0 && point.y > 0) { // top right quarter
                //     point.update({
                //     color: 'red'
                //     });
                // } else if (point.x >= 0 && point.y < 0) { // bottom right quarter
                //     point.update({
                //     color: '#f7c908'
                //     });
                // } else if (point.x < 0 && point.y < 0) { // bottom left quarter
                //     point.update({
                //     color: '#0cf30c'
                //     });
                // } else if (point.x < 0 && point.y >= 0) { // top left quarter
                //     point.update({
                //     color: '#209cdf'
                //     });
                // }
                // });

                const offset = 70;
                chart.renderer.text('Quadran 2', chart.chartWidth - offset, offset).add();
                chart.renderer.text('Quadran 4', chart.chartWidth - offset, chart.chartHeight - offset).add();
                chart.renderer.text('Quadran 3', offset, chart.chartHeight - offset).add();
                chart.renderer.text('Quadran 1', offset, offset).add();
            }
            }
        },
        xAxis: {
            // gridLineWidth: 1,
            tickInterval: 2,
            min: -4,
            max: 4,
            lineWidth: 2,
            lineColor: 'black',
            offset: -155,
            title: {
            text: null
            }
        },
        yAxis: {
            tickInterval: 2,
            min: -4,
            max: 4,
            lineWidth: 2,
            lineColor: 'black',
            offset: -505,
            title: {
            text: null
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
            dataLabels: {
                enabled: false
            }
            }
        },
        tooltip: {
            pointFormat: 'Kinerja: {point.x}<br/>Harapan: {point.y}'
        },
        series: [
            @foreach ($quadran as $item)
            {
                name: '{{$item->question_name}}',
                data: [{
                    x: {{$item->kinerja ?? 0}},
                    y: {{$item->harapan ?? 0}}
                }]
            },
            @endforeach
        ]
        });

</script>
@endsection