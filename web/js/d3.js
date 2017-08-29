
/* global d3 */

$(document).on('ready', function () {

    var appendTo = '#d3-grafic';

    var margin = {top: 40, right: 20, bottom: 30, left: 40},
            width = 960 - margin.left - margin.right,
            height = 500 - margin.top - margin.bottom;

    var formatPercent = d3.format("0");

    var x = d3.scale.ordinal()
            .rangeRoundBands([0, width], .1);

    var y = d3.scale.linear()
            .range([height, 0]);

    var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");

    var yAxis = d3.svg.axis()
            .scale(y)
            .orient("left")
            .tickFormat(formatPercent);

    var tip = d3.tip()
            .attr('class', 'd3-tip')
            .offset([-10, 0])
            .html(function (d) {
                return "<span class='bolded'>Number of results: <span style='color:red'>" + getFormattedCurrency(d.frequency) + "</span></span>";
            });

    var svg = d3.select(appendTo).append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    svg.call(tip);

    var data = createData();

    // The following code was contained in the callback function.
    x.domain(data.map(function (d) {
        return d.letter;
    }));
    y.domain([0, d3.max(data, function (d) {
            return d.frequency;
        })]);

    svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

    svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", 6)
            .attr("dy", ".71em")
            .style("text-anchor", "end")
            .text("Number of results");

    svg.selectAll(".bar")
            .data(data)
            .enter().append("rect")
            .attr("class", "bar")
            .attr("x", function (d) {
                return x(d.letter);
            })
            .attr("width", x.rangeBand())
            .attr("y", function (d) {
                return y(d.frequency);
            })
            .attr("height", function (d) {
                return height - y(d.frequency);
            })
            .on('mouseover', tip.show)
            .on('mouseout', tip.hide);
});

function type(d) {
    d.frequency = +d.frequency;
    return d;
}

function createData() {

    var wikipedia_selector = '#d3-wikipedia';
    var crossref_selector = '#d3-crossref';
    var youtube_selector = '#d3-youtube';

    var dataPrepared = [];

    if ($(wikipedia_selector).length) {
        if ($(wikipedia_selector).val() !== '') {
            var results = $(wikipedia_selector).val();
            var element = [
                {
                    letter: 'Wikipedia',
                    frequency: parseInt(results)
                }
            ];
            dataPrepared = dataPrepared.concat(element);
        }
    }

    if ($(crossref_selector).length) {
        if ($(crossref_selector).val() !== '') {
            var results = $(crossref_selector).val();
            var element = [
                {
                    letter: 'Crossref',
                    frequency: parseInt(results)
                }
            ];
            dataPrepared = dataPrepared.concat(element);
        }
    }

    if ($(youtube_selector).length) {
        if ($(youtube_selector).val() !== '') {
            var results = $(youtube_selector).val();
            var element = [
                {
                    letter: 'YouTube',
                    frequency: parseInt(results)
                }
            ];
            dataPrepared = dataPrepared.concat(element);
        }
    }

    return dataPrepared;

}

function getFormattedCurrency(num) {
    
    var numOuput = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    
    if (num >= 1000000) {
        numOuput += '+';
    }
    
    return numOuput;
}