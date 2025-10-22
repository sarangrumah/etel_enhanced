@extends('layouts.backend.main')
@section('js')
<script src="../../../../global_assets/js/plugins/visualization/d3/d3.min.js"></script>
<script src="../../../../global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
<script src="../../../../global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script src="../../../../global_assets/js/plugins/pickers/daterangepicker.js"></script>
<script src="../../../../global_assets/js/demo_pages/dashboard.js"></script>
<script src="../../../../global_assets/js/demo_pages/dashboard.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/streamgraph.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/sparklines.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/lines.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/areas.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/donuts.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/bars.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/progress.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/heatmaps.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/pies.js"></script>
<script src="../../../../global_assets/js/demo_charts/pages/dashboard/light/bullets.js"></script>

<script src="../../../../global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>

<script src="../../../../global_assets/js/demo_charts/echarts/light/scatter/scatter_basic.js"></script>
<script src="../../../../global_assets/js/demo_charts/echarts/light/scatter/scatter_size.js"></script>
<script src="../../../../global_assets/js/demo_charts/echarts/light/scatter/scatter_scale.js"></script>
<script src="../../../../global_assets/js/demo_charts/echarts/light/scatter/scatter_roaming.js"></script>
<script src="../../../../global_assets/js/demo_charts/echarts/light/scatter/scatter_category.js"></script>
<script src="../../../../global_assets/js/demo_charts/echarts/light/scatter/scatter_punch.js"></script>

<script src="../../../../global_assets/js/demo_charts/echarts/light/pies/pie_rose_labels.js"></script>
<script src="../../../../global_assets/js/demo_charts/echarts/light/pies/pie_rose.js"></script>
<!-- /theme JS files -->
@endsection
@section('content')


<div>

    <!-- Progress counters -->
    <div class="row">
        <div class="col-sm-6">

            <!-- Available hours -->
            <div class="card text-center">
                <div class="card-body">
                    <!-- Progress counter -->
                    <div class="svg-center position-relative" id="ikm">12</div>
                    <!-- /progress counter -->
                </div>
            </div>
            <!-- /available hours -->

        </div>

        <div class="col-sm-6">

            <!-- Productivity goal -->
            <div class="card text-center">
                <div class="card-body">
                    <!-- Progress counter -->
                    <div class="svg-center position-relative" id="iipp">12</div>
                    <!-- /progress counter -->
                </div>
            </div>
            <!-- /productivity goal -->

        </div>
    </div>
    <!-- /progress counters -->

</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Sebaran Data Survei</h5>
    </div>

    <div class="card-body">
        <div class="chart-container">
            <div class="chart has-fixed-height" id="scatter_bubble_size"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Sebaran Usia Responder</h5>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="pie_rose_labels"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-6">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Sebaran Pekerjaan Responder</h5>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="pie_rose"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection