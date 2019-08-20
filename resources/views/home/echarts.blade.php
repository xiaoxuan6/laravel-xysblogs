@extends('layouts.web')

@section('title', '活跃量')

@section('css')
  <style>
    .echart span {
      display: block;
      text-align: left;
      border-radius: 5px;
      background: gray;
      margin-right: 5px;
      width: 180px;
      color: white;
      float: right;
    }
  </style>
@endsection
@section('content')
<div class="pagebg" style="background-image:url({{ asset('images/111748615.jpg') }}); background-repeat:no-repeat;background-origin: padding-box;
        background-clip: border-box;background-size: cover;
        background-position: center;"> </div>
<div class="container">
  <div class="news_infos" style="width: 100%">
    <ul>
      <div class="echart">
        <span>&nbsp;&nbsp;昨日活跃量：{{ $visits_count['yesterday'] }}/人</span>
        <span>&nbsp;&nbsp;上周活跃量：{{ $visits_count['last_week'] }}/人</span>
        <span>&nbsp;&nbsp;上月活跃量：{{ $visits_count['last_month'] }}/人</span>
        <input type="hidden" value="{{ $num }}" class="num">
        <input type="hidden" value="{{ $pub_date }}" class="pub_date">
      </div>
      <div style="clear: both">近七日访问量</div>
      <div id="main" style="width: 100%;height:400px;"></div>
    </ul>
  </div>
    <div class="news_infos" style="width: 100%">
        <ul>
            @foreach($china_data as $key=>$v)
                <li class="china{{$key}}" data-name="{{ $v['name'] }}" data-value="{{ $v['value'] }}"></li>
            @endforeach
        </ul>
        <div id="mains" style="width: 100%;height:700px;"></div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/home/echarts.min.js') }}"></script>
<script src="{{ asset('js/home/echarts.discount.js') }}"></script>
<script src="https://gallery.echartsjs.com/dep/echarts/map/js/china.js"></script>
<script type="text/javascript">

    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('mains'));

    //数据
    var data = [];
    var count = "{{ $china_count }}";
    for (var j = 0; j < count; j++) {
        var name = $('.china' + j).data('name');
        var value = $('.china' + j).data('value');
        data.push({name: name, value: value});
    }

    var yData = [];
    var barData = [];

    for (var i = 0; i < count; i++) {
        barData.push(data[i]);
        yData.push(i + data[i].name);
    }

    var option = {
        title: [{
            show: true,
            text: '访问分布情况',
            textStyle: {
                color: '#2D3E53',
                fontSize: 18
            },
            right: 180,
            top: 100
        }],
        tooltip: {
            show: true,
            formatter: function(params) {
                return params.name + '：' + params.data['value'] + '人'
            },
        },
        visualMap: {
            type: 'continuous',
            orient: 'horizontal',
            itemWidth: 10,
            itemHeight: 80,
            text: ['高', '低'],
            showLabel: true,
            seriesIndex: [0],
            min: 0,
            max: 2,
            inRange: {
                color: ['#6FCF6A', '#FFFD64', '#FF5000']
            },
            textStyle: {
                color: '#7B93A7'
            },
            bottom: 30,
            left: 'left',
        },
        grid: {
            right: 10,
            top: 135,
            bottom: 100,
            width: '20%'
        },
        xAxis: {
            show: false
        },
        yAxis: {
            type: 'category',
            inverse: true,
            nameGap: 16,
            axisLine: {
                show: false,
                lineStyle: {
                    color: '#ddd'
                }
            },
            axisTick: {
                show: false,
                lineStyle: {
                    color: '#ddd'
                }
            },
            axisLabel: {
                interval: 0,
                margin: 85,
                textStyle: {
                    color: '#455A74',
                    align: 'left',
                    fontSize: 14
                },
                rich: {
                    a: {
                        color: '#fff',
                        backgroundColor: '#FAAA39',
                        width: 20,
                        height: 20,
                        align: 'center',
                        borderRadius: 2
                    },
                    b: {
                        color: '#fff',
                        backgroundColor: '#4197FD',
                        width: 20,
                        height: 20,
                        align: 'center',
                        borderRadius: 2
                    }
                },
                formatter: function(params) {
                    if (parseInt(params.slice(0, 1)) < 3) {
                        return [
                            '{a|' + (parseInt(params.slice(0, 1)) + 1) + '}' + '  ' + params.slice(1)
                        ].join('\n')
                    } else {
                        return [
                            '{b|' + (parseInt(params.slice(0, 1)) + 1) + '}' + '  ' + params.slice(1)
                        ].join('\n')
                    }
                }
            },
            data: yData
        },
        geo: {
            // roam: true,
            map: 'china',
            left: 'left',
            right: '300',
            // layoutSize: '80%',
            label: {
                emphasis: {
                    show: false
                }
            },
            itemStyle: {
                emphasis: {
                    areaColor: '#fff464'
                }
            }
        },
        series: [{
            name: 'mapSer',
            type: 'map',
            roam: false,
            geoIndex: 0,
            label: {
                show: false,
            },
            data: data
        }, {
            name: 'barSer',
            type: 'bar',
            roam: false,
            visualMap: false,
            zlevel: 2,
            barMaxWidth: 8,
            barGap: 0,
            itemStyle: {
                normal: {
                    color: function(params) {
                        // build a color map as your need.
                        var colorList = [{
                            colorStops: [{
                                offset: 0,
                                color: '#FFD119' // 0% 处的颜色
                            }, {
                                offset: 1,
                                color: '#FFAC4C' // 100% 处的颜色
                            }]
                        },
                            {
                                colorStops: [{
                                    offset: 0,
                                    color: '#00C0FA' // 0% 处的颜色
                                }, {
                                    offset: 1,
                                    color: '#2F95FA' // 100% 处的颜色
                                }]
                            }
                        ];
                        if (params.dataIndex < 3) {
                            return colorList[0]
                        } else {
                            return colorList[1]
                        }
                    },
                    barBorderRadius: 15
                }
            },
            data: barData
        }]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
@endsection