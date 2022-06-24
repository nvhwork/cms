var gaugeChart = function(elm, params) {
    var colors = {
        'pink': '#E1499A',
        'yellow': '#f0ff08',
        'green': '#47e495'
    };

    var sizeRatio = $(elm).width() / 153;
    var radius = 72;
    var border = 10 * sizeRatio;
    var padding = 30;
    var startPercent = 0;
    var endPercent = 0.85;

    radius = $(elm).width() / 2;


    var twoPi = Math.PI * 1;
    var formatPercent = d3.format('.0%');
    var boxSize = (radius + padding) * 2;

    var count = Math.abs((endPercent - startPercent) / 0.01);
    var step = endPercent < startPercent ? -0.01 : 0.01;

    var arc = d3.svg.arc()
        .startAngle(-(Math.PI / 2) - Math.PI / 4)
        .innerRadius(radius)
        .outerRadius(radius - border);

    var parent = d3.select(elm[0]);

    var svg = parent.append('svg')
        .attr('width', '100')
        .attr('height', '100');

    var defs = svg.append('svg:defs')

    var red_gradient = defs.append('svg:linearGradient')
        .attr('id', 'gradient')
        .attr('x1', '0%')
        .attr('y1', '0%')
        .attr('x2', '0%')
        .attr('y2', '100%')
        .attr('spreadMethod', 'pad');

    // red_gradient.append('svg:stop')
    //     .attr('offset', '0%')
    //     .attr('stop-color', ')
    //     .attr('stop-opacity', 1);

    red_gradient.append('svg:stop')
        .attr('offset', '0%')
        .attr('stop-color', 'rgb(237, 207, 12)')
        .attr('stop-opacity', 1);

    red_gradient.append('svg:stop')
        .attr('offset', '100%')
        .attr('stop-color', 'rgb(41,178,130)')
        .attr('stop-opacity', 1);

    var red_gradient2 = defs.append('svg:linearGradient')
        .attr('id', 'gradient2')
        .attr('x1', '0%')
        .attr('y1', '0%')
        .attr('x2', '0%')
        .attr('y2', '100%')
        .attr('spreadMethod', 'pad');

    red_gradient2.append('svg:stop')
        .attr('offset', '0%')
        .attr('stop-color', 'rgb(237, 207, 12)')
        .attr('stop-opacity', 1);

    red_gradient2.append('svg:stop')
        .attr('offset', '100%')
        .attr('stop-color', 'rgb(247,136,51)')
        .attr('stop-opacity', 1);

    var g = svg.append('g')
        .attr('transform', 'translate(' + 50 + ',' +
            50 + ')');

    var meter = g.append('g')
        .attr('class', 'progress-meter');

    var circle = meter.append('path')
        .attr('d', d3.svg.arc()
            .startAngle(0)
            .innerRadius(radius + 4 * sizeRatio)
            .outerRadius(radius + 5 * sizeRatio)
            .endAngle(360)
        )
        .attr('fill', 'rgb(232, 232, 232)')
        .attr('fill-opacity', 1);

    var front = meter.append('path')
        .attr('d', arc.endAngle(0))
        .attr('class', 'arc')
        .attr('fill', 'url(#gradient)')
        .attr('fill-opacity', 1);

    var ar = d3.svg.arc()
        .startAngle(0)
        .innerRadius(radius)
        .outerRadius(radius - border);

    var back = meter.append('path')
        .attr('d', ar.endAngle(Math.PI / 2 + Math.PI / 4))
        .attr('fill', 'url(#gradient2)')
        .attr('fill-opacity', 1);

    var convertValue = function(value) {
        return value * .75 * 2 * Math.PI;
    };

    var numberText = meter.append('text')
        .attr('fill', 'rgb(67, 174, 168)')
        .attr('font-size', 25 * sizeRatio)
        .attr('font-family', 'arial')
        .attr('text-anchor', 'middle')
        .attr('dy', '.35em');
    var unitText = meter.append('text')
        .attr('fill', 'rgb(67, 174, 168)')
        .attr('font-size', 14 * sizeRatio)
        .attr('font-family', 'arial')
        .attr('text-anchor', 'middle')
        .attr('dy', '3em');
    // var maxText = meter.append('text')
    //     .attr('fill', 'rgb(149, 149, 149)')
    //     .attr('font-size', 14 * sizeRatio)
    //     .attr('font-family', 'arial')
    //     .attr('text-anchor', 'left')
    //     .attr('dy', 65 * sizeRatio)
    //     .attr('dx', 65 * sizeRatio)
    //     .text(window.Laravel.proxyName);
    // var maxValueText = meter.append('text')
    //     .attr('fill', 'rgb(149, 149, 149)')
    //     .attr('font-size', 14 * sizeRatio)
    //     .attr('font-family', 'arial')
    //     .attr('text-anchor', 'left')
    //     .attr('dy', 80 * sizeRatio)
    //     .attr('dx', 65 * sizeRatio);

    var loadTriangle = function(degree) {
        var n = d3.svg.arc()
            .startAngle(0)
            .innerRadius(radius)
            .outerRadius(radius - border);

        var ar = d3.svg.arc()
            .startAngle(convertValue(degree) - 0.02)
            .innerRadius(radius)
            .outerRadius(radius - border);

        var needle = meter.append('path')
            .attr('d', ar.endAngle(convertValue(degree)))
            .attr('fill', 'white')
            .attr('fill-opacity', 1);

        var topx = 0;
        var topy = -6 * sizeRatio;
        var leftx = -6 * sizeRatio;
        var lefty = 12 * sizeRatio;
        var rightx = 12 * sizeRatio;
        var righty = 0;
        var triangle = meter.append('path')
            .style('fill', 'rgb(225, 225, 225)')
            .attr('d', 'M ' + topx + ' ' + (topy+'') + ' l ' + (leftx + ' ') + lefty + ' l ' + rightx + ' ' + righty + ' z')
            .attr('transform', 'translate(' + Math.cos(
                    convertValue(degree) - Math.PI / 2) *
                55 * sizeRatio + ',' +
                Math.sin(convertValue(degree) - Math.PI / 2) *
                55 * sizeRatio + ')rotate(' + (convertValue(degree) *
                    180 / Math.PI) + ')');
        return triangle;
    };

    var half = params.max / 2;
    var ratio = params.value / half;
    var value = -0.5;
    if(ratio >= 1){
        value = (ratio - 1) * 0.5;
    }else{
        value = ratio * -0.5;
    }
    if(ratio === 0){
        value = -0.5;
    }
    if(ratio >= 2){
        value = 0.5;
    }

    loadTriangle(value);

    function updateProgress(params) {
        if(params.value == 0){
            params.value = 'Loading...'
        }
        else {
            params.value = Math.round(parseFloat((params.value)/(params.max))*1000)/10 + '%';
        }
        numberText.text(params.value);
        unitText.text('RAM');
        // maxValueText.text(params.max);
    }
    updateProgress(params);
};

gaugeChart($('.gauge-chart'), {max: 3000, value: 0});
function getChartRam(ram){
    $('.gauge-chart').html('');
    gaugeChart($('.gauge-chart'), {max: ram.totalMemMb, value: ram.freeMemMb});
};



// end chart Ram //////////////////////////////////////////////////////////////////


function getChartCpu(cpu){
    var svg = document.querySelector('.circle-chart-circle');
      $('.circle-chart-circle').attr('stroke-dasharray', cpu + ",100");
      text = document.querySelector('text.circle-chart-percent');

    if (cpu === '100') {
      text.textContent = 'full';
      }
    else {
      text.textContent = cpu + '%';
    }

}

// end chart CPU /////////////////////////////////////////////////////////////////
