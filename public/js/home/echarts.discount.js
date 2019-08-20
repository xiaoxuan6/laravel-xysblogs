$(document).ready(function() {
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    var num = $('.num').val();
    var pub_date = $('.pub_date').val();

    // 指定图表的配置项和数据
    var option = {
        tooltip: {
            trigger: 'axis'
        },
        xAxis: [{
            type: 'category',
            data: pub_date.split(','),
            axisLine: {
                lineStyle: {
                    color: "#999"
                }
            }
        }],
        yAxis: [{
            type: 'value',
            splitNumber: 3,
            splitLine: {
                lineStyle: {
                    type: 'dashed',
                    color: '#DDD'
                }
            },
            axisLine: {
                show: false,
                lineStyle: {
                    color: "#333"
                },
            },
            nameTextStyle: {
                color: "#999"
            },
            splitArea: {
                show: false
            }
        }],
        series: [{
            name: '活跃量',
            type: 'line',
            data: num.split(','),
            lineStyle: {
                normal: {
                    width: 3,
                    color: {
                        type: 'linear',
                        colorStops: [{
                            offset: 0,
                            color: '#cccccc' // 0% 处的颜色
                        }, {
                            offset: 1,
                            color: 'black' // 100% 处的颜色
                        }],
                        globalCoord: false // 缺省为 false
                    },
                    shadowColor: 'rgba(153,153,153, 0.3)',
                    shadowBlur: 10,
                    shadowOffsetY: 20
                }
            },
            itemStyle: {
                normal: {
                    color: '#fff',
                    borderWidth: 3,
                    /*shadowColor: 'rgba(72,216,191, 0.3)',
                    shadowBlur: 100,*/
                    borderColor: "black"
                }
            },
            smooth: true
        }]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
});