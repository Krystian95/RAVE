
/* global d3 */

$(document).on('ready', function () {

    /* Population */

    var margin = {top: 20, right: 80, bottom: 230, left: 80},
            width = 3450 - margin.left - margin.right,
            height = 800 - margin.top - margin.bottom;
    var x0 = d3.scale.ordinal()
            .rangeRoundBands([0, width], .1);
    var x1 = d3.scale.ordinal();
    var y = d3.scale.linear()
            .range([height, 0]);
    var colorRange = d3.scale.category10();
    var color = d3.scale.ordinal()
            .range(colorRange.range());
    var xAxis = d3.svg.axis()
            .scale(x0)
            .orient("bottom");
    var yAxis = d3.svg.axis()
            .scale(y)
            .orient("left")
            .tickFormat(d3.format(".2s"));
    var divTooltip = d3.select("#d3-grafic-population").append("div").attr("class", "toolTip");
    var svg = d3.select("#d3-grafic-population").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    dataset = [
        {label: "Afghanistan", "Population in 1960": 8996351, "Population in 2016": 34656032},
        {label: "Albania", "Population in 1960": 1608800, "Population in 2016": 2876101},
        {label: "Algeria", "Population in 1960": 11124888, "Population in 2016": 40606052},
        {label: "Andorra", "Population in 1960": 13411, "Population in 2016": 77281},
        {label: "Angola", "Population in 1960": 5643182, "Population in 2016": 28813463},
        {label: "Antigua and Barbuda", "Population in 1960": 55339, "Population in 2016": 100963},
        {label: "Argentina", "Population in 1960": 20619075, "Population in 2016": 43847430},
        {label: "Armenia", "Population in 1960": 1874120, "Population in 2016": 2924816},
        {label: "Australia", "Population in 1960": 10276477, "Population in 2016": 24127159},
        {label: "Austria", "Population in 1960": 7047539, "Population in 2016": 8747358},
        {label: "Azerbaijan", "Population in 1960": 3895396, "Population in 2016": 9762274},
        {label: "Bahamas", "Population in 1960": 109528, "Population in 2016": 391232},
        {label: "Bahrain", "Population in 1960": 162427, "Population in 2016": 1425171},
        {label: "Bangladesh", "Population in 1960": 48199747, "Population in 2016": 162951560},
        {label: "Barbados", "Population in 1960": 230939, "Population in 2016": 284996},
        {label: "Belarus", "Population in 1960": 8198000, "Population in 2016": 9507120},
        {label: "Belgium", "Population in 1960": 9153489, "Population in 2016": 11348159},
        {label: "Belize", "Population in 1960": 92064, "Population in 2016": 366954},
        {label: "Benin", "Population in 1960": 2431622, "Population in 2016": 10872298},
        {label: "Bhutan", "Population in 1960": 223288, "Population in 2016": 797765},
        {label: "Bolivia", "Population in 1960": 3693449, "Population in 2016": 10887882},
        {label: "Bosnia and Herzegovina", "Population in 1960": 3225668, "Population in 2016": 3516816},
        {label: "Botswana", "Population in 1960": 524552, "Population in 2016": 2250260},
        {label: "Brazil", "Population in 1960": 72207554, "Population in 2016": 207652865},
        {label: "Brunei Darussalam", "Population in 1960": 81745, "Population in 2016": 423196},
        {label: "Bulgaria", "Population in 1960": 7867374, "Population in 2016": 7127822},
        {label: "Burkina Faso", "Population in 1960": 4829288, "Population in 2016": 18646433},
        {label: "Burundi", "Population in 1960": 2786106, "Population in 2016": 10524117},
        {label: "Cabo Verde", "Population in 1960": 202310, "Population in 2016": 539560},
        {label: "Cambodia", "Population in 1960": 5722370, "Population in 2016": 15762370},
        {label: "Cameroon", "Population in 1960": 5176268, "Population in 2016": 23439189},
        {label: "Canada", "Population in 1960": 17909009, "Population in 2016": 36286425},
        {label: "Central African Republic", "Population in 1960": 1503508, "Population in 2016": 4594621},
        {label: "Chad", "Population in 1960": 3001593, "Population in 2016": 14452543},
        {label: "Chile", "Population in 1960": 7716625, "Population in 2016": 17909754},
        {label: "China", "Population in 1960": 667070000, "Population in 2016": 1378665000},
        {label: "Colombia", "Population in 1960": 16480383, "Population in 2016": 48653419},
        {label: "Comoros", "Population in 1960": 191121, "Population in 2016": 795601},
        {label: "Congo", "Population in 1960": 1037220, "Population in 2016": 5125821},
        {label: "Costa Rica", "Population in 1960": 1333040, "Population in 2016": 4857274},
        {label: "Cote d'Ivoire", "Population in 1960": 3558988, "Population in 2016": 23695919},
        {label: "Croatia", "Population in 1960": 4140000, "Population in 2016": 4170600},
        {label: "Cuba", "Population in 1960": 7141135, "Population in 2016": 11475982},
        {label: "Cyprus", "Population in 1960": 572930, "Population in 2016": 1170125},
        {label: "Czech Republic", "Population in 1960": 9602006, "Population in 2016": 10561633},
        {label: "North Korea", "Population in 1960": 11424176, "Population in 2016": 25368620},
        {label: "Democratic Republic of the Congo", "Population in 1960": 15248251, "Population in 2016": 78736153},
        {label: "Denmark", "Population in 1960": 4579603, "Population in 2016": 5731118},
        {label: "Djibouti", "Population in 1960": 83636, "Population in 2016": 942333},
        {label: "Dominica", "Population in 1960": 60011, "Population in 2016": 73543},
        {label: "Dominican Republic", "Population in 1960": 3294042, "Population in 2016": 10648791},
        {label: "Ecuador", "Population in 1960": 4545550, "Population in 2016": 16385068},
        {label: "Egypt", "Population in 1960": 26996533, "Population in 2016": 95688681},
        {label: "El Salvador", "Population in 1960": 2762899, "Population in 2016": 6344722},
        {label: "Equatorial Guinea", "Population in 1960": 255323, "Population in 2016": 1221490},
        {label: "Eritrea", "Population in 1960": 1397491, "Population in 2016": 6527689},
        {label: "Estonia", "Population in 1960": 1211537, "Population in 2016": 1316481},
        {label: "Ethiopia", "Population in 1960": 22151278, "Population in 2016": 102403196},
        {label: "Fiji", "Population in 1960": 393386, "Population in 2016": 898760},
        {label: "Finland", "Population in 1960": 4429634, "Population in 2016": 5495096},
        {label: "France", "Population in 1960": 46814237, "Population in 2016": 66896109},
        {label: "Gabon", "Population in 1960": 499184, "Population in 2016": 1979786},
        {label: "Gambia", "Population in 1960": 367928, "Population in 2016": 2038501},
        {label: "Georgia", "Population in 1960": 3645600, "Population in 2016": 3719300},
        {label: "Germany", "Population in 1960": 72814900, "Population in 2016": 82667685},
        {label: "Ghana", "Population in 1960": 6652287, "Population in 2016": 28206728},
        {label: "Greece", "Population in 1960": 8331725, "Population in 2016": 10746740},
        {label: "Grenada", "Population in 1960": 89869, "Population in 2016": 107317},
        {label: "Guatemala", "Population in 1960": 4210747, "Population in 2016": 16582469},
        {label: "Guinea", "Population in 1960": 3577409, "Population in 2016": 12395924},
        {label: "Guinea-Bissau", "Population in 1960": 616409, "Population in 2016": 1815698},
        {label: "Guyana", "Population in 1960": 571819, "Population in 2016": 773303},
        {label: "Haiti", "Population in 1960": 3866159, "Population in 2016": 10847334},
        {label: "Honduras", "Population in 1960": 2038637, "Population in 2016": 9112867},
        {label: "Hungary", "Population in 1960": 9983967, "Population in 2016": 9817958},
        {label: "Iceland", "Population in 1960": 175574, "Population in 2016": 334252},
        {label: "India", "Population in 1960": 449480608, "Population in 2016": 1324171354},
        {label: "Indonesia", "Population in 1960": 87792515, "Population in 2016": 261115456},
        {label: "Iran", "Population in 1960": 21906903, "Population in 2016": 80277428},
        {label: "Iraq", "Population in 1960": 7289761, "Population in 2016": 37202572},
        {label: "Ireland", "Population in 1960": 2828600, "Population in 2016": 4773095},
        {label: "Israel", "Population in 1960": 2114020, "Population in 2016": 8547100},
        {label: "Italy", "Population in 1960": 50199700, "Population in 2016": 60600590},
        {label: "Jamaica", "Population in 1960": 1628252, "Population in 2016": 2881355},
        {label: "Japan", "Population in 1960": 92500572, "Population in 2016": 126994511},
        {label: "Jordan", "Population in 1960": 932257, "Population in 2016": 9455802},
        {label: "Kazakhstan", "Population in 1960": 9714260, "Population in 2016": 17797032},
        {label: "Kenya", "Population in 1960": 8105440, "Population in 2016": 48461567},
        {label: "Kiribati", "Population in 1960": 41233, "Population in 2016": 114395},
        {label: "Kuwait", "Population in 1960": 269618, "Population in 2016": 4052584},
        {label: "Kyrgyzstan", "Population in 1960": 2172300, "Population in 2016": 6082700},
        {label: "Laos", "Population in 1960": 2120896, "Population in 2016": 6758353},
        {label: "Latvia", "Population in 1960": 2120979, "Population in 2016": 1960424},
        {label: "Lebanon", "Population in 1960": 1804926, "Population in 2016": 6006668},
        {label: "Lesotho", "Population in 1960": 851591, "Population in 2016": 2203821},
        {label: "Liberia", "Population in 1960": 1120313, "Population in 2016": 4613823},
        {label: "Libya", "Population in 1960": 1448417, "Population in 2016": 6293253},
        {label: "Liechtenstein", "Population in 1960": 16495, "Population in 2016": 37666},
        {label: "Lithuania", "Population in 1960": 2778550, "Population in 2016": 2872298},
        {label: "Luxembourg", "Population in 1960": 313970, "Population in 2016": 582972},
        {label: "Madagascar", "Population in 1960": 5099373, "Population in 2016": 24894551},
        {label: "Malawi", "Population in 1960": 3618595, "Population in 2016": 18091575},
        {label: "Malaysia", "Population in 1960": 8157106, "Population in 2016": 31187265},
        {label: "Maldives", "Population in 1960": 89887, "Population in 2016": 417492},
        {label: "Mali", "Population in 1960": 5263733, "Population in 2016": 17994837},
        {label: "Malta", "Population in 1960": 326550, "Population in 2016": 436947},
        {label: "Marshall Islands", "Population in 1960": 14662, "Population in 2016": 53066},
        {label: "Mauritania", "Population in 1960": 858168, "Population in 2016": 4301018},
        {label: "Mauritius", "Population in 1960": 659351, "Population in 2016": 1263473},
        {label: "Mexico", "Population in 1960": 38174112, "Population in 2016": 127540423},
        {label: "Micronesia", "Population in 1960": 44537, "Population in 2016": 104937},
        {label: "Monaco", "Population in 1960": 22452, "Population in 2016": 38499},
        {label: "Mongolia", "Population in 1960": 955505, "Population in 2016": 3027398},
        {label: "Montenegro", "Population in 1960": 480579, "Population in 2016": 622781},
        {label: "Morocco", "Population in 1960": 12328532, "Population in 2016": 35276786},
        {label: "Mozambique", "Population in 1960": 7388695, "Population in 2016": 28829476},
        {label: "Myanmar", "Population in 1960": 20986123, "Population in 2016": 52885223},
        {label: "Namibia", "Population in 1960": 602544, "Population in 2016": 2479713},
        {label: "Nauru", "Population in 1960": 4433, "Population in 2016": 13049},
        {label: "Nepal", "Population in 1960": 10063011, "Population in 2016": 28982771},
        {label: "Netherlands", "Population in 1960": 11486631, "Population in 2016": 17018408},
        {label: "New Zealand", "Population in 1960": 2371800, "Population in 2016": 4692700},
        {label: "Nicaragua", "Population in 1960": 1774699, "Population in 2016": 6149928},
        {label: "Niger", "Population in 1960": 3388764, "Population in 2016": 20672987},
        {label: "Nigeria", "Population in 1960": 45137812, "Population in 2016": 185989640},
        {label: "Norway", "Population in 1960": 3581239, "Population in 2016": 5232929},
        {label: "Oman", "Population in 1960": 551740, "Population in 2016": 4424762},
        {label: "Pakistan", "Population in 1960": 44908293, "Population in 2016": 193203476},
        {label: "Palau", "Population in 1960": 9642, "Population in 2016": 21503},
        {label: "Panama", "Population in 1960": 1132921, "Population in 2016": 4034119},
        {label: "Papua New Guinea", "Population in 1960": 2010677, "Population in 2016": 8084991},
        {label: "Paraguay", "Population in 1960": 1902875, "Population in 2016": 6725308},
        {label: "Peru", "Population in 1960": 10061515, "Population in 2016": 31773839},
        {label: "Philippines", "Population in 1960": 26273025, "Population in 2016": 103320222},
        {label: "Poland", "Population in 1960": 29637450, "Population in 2016": 37948016},
        {label: "Portugal", "Population in 1960": 8857716, "Population in 2016": 10324611},
        {label: "Qatar", "Population in 1960": 47384, "Population in 2016": 2569804},
        {label: "South Korea", "Population in 1960": 25012374, "Population in 2016": 51245707},
        {label: "Moldova", "Population in 1960": 2544000, "Population in 2016": 3552000},
        {label: "Romania", "Population in 1960": 18406905, "Population in 2016": 19705301},
        {label: "Russia", "Population in 1960": 119897000, "Population in 2016": 144342396},
        {label: "Rwanda", "Population in 1960": 2933428, "Population in 2016": 11917508},
        {label: "Saint Kitts and Nevis", "Population in 1960": 51195, "Population in 2016": 54821},
        {label: "St. Lucia", "Population in 1960": 89897, "Population in 2016": 178015},
        {label: "St. Vincent and the Grenadines", "Population in 1960": 80949, "Population in 2016": 109643},
        {label: "Samoa", "Population in 1960": 108646, "Population in 2016": 195125},
        {label: "San Marino", "Population in 1960": 15397, "Population in 2016": 33203},
        {label: "Sao Tome and Principe", "Population in 1960": 64253, "Population in 2016": 199910},
        {label: "Saudi Arabia", "Population in 1960": 4086539, "Population in 2016": 32275687},
        {label: "Senegal", "Population in 1960": 3206749, "Population in 2016": 15411614},
        {label: "Serbia", "Population in 1960": 7556730, "Population in 2016": 7057412},
        {label: "Seychelles", "Population in 1960": 41700, "Population in 2016": 94677},
        {label: "Sierra Leone", "Population in 1960": 2297110, "Population in 2016": 7396190},
        {label: "Singapore", "Population in 1960": 1646400, "Population in 2016": 5607283},
        {label: "Slovakia", "Population in 1960": 4068095, "Population in 2016": 5428704},
        {label: "Slovenia", "Population in 1960": 1584720, "Population in 2016": 2064845},
        {label: "Solomon Islands", "Population in 1960": 117866, "Population in 2016": 599419},
        {label: "Somalia", "Population in 1960": 2755947, "Population in 2016": 14317996},
        {label: "South Africa", "Population in 1960": 17396367, "Population in 2016": 55908865},
        {label: "South Sudan", "Population in 1960": 2955152, "Population in 2016": 12230730},
        {label: "Spain", "Population in 1960": 30455000, "Population in 2016": 46443959},
        {label: "Sri Lanka", "Population in 1960": 9896000, "Population in 2016": 21203000},
        {label: "Sudan", "Population in 1960": 7544491, "Population in 2016": 39578828},
        {label: "Suriname", "Population in 1960": 289966, "Population in 2016": 558368},
        {label: "Swaziland", "Population in 1960": 349174, "Population in 2016": 1343098},
        {label: "Sweden", "Population in 1960": 7484656, "Population in 2016": 9903122},
        {label: "Switzerland", "Population in 1960": 5327827, "Population in 2016": 8372098},
        {label: "Syria", "Population in 1960": 4573512, "Population in 2016": 18430453},
        {label: "Tajikistan", "Population in 1960": 2087038, "Population in 2016": 8734951},
        {label: "Tanzania", "Population in 1960": 10074507, "Population in 2016": 55572201},
        {label: "Thailand", "Population in 1960": 27397175, "Population in 2016": 68863514},
        {label: "Macedonia", "Population in 1960": 1488667, "Population in 2016": 2081206},
        {label: "Timor-Leste", "Population in 1960": 499950, "Population in 2016": 1268671},
        {label: "Togo", "Population in 1960": 1580513, "Population in 2016": 7606374},
        {label: "Tonga", "Population in 1960": 61601, "Population in 2016": 107122},
        {label: "Trinidad and Tobago", "Population in 1960": 848479, "Population in 2016": 1364962},
        {label: "Tunisia", "Population in 1960": 4176266, "Population in 2016": 11403248},
        {label: "Turkey", "Population in 1960": 27472331, "Population in 2016": 79512426},
        {label: "Turkmenistan", "Population in 1960": 1603258, "Population in 2016": 5662544},
        {label: "Tuvalu", "Population in 1960": 6104, "Population in 2016": 11097},
        {label: "Uganda", "Population in 1960": 6788214, "Population in 2016": 41487965},
        {label: "Ukraine", "Population in 1960": 42662149, "Population in 2016": 45004645},
        {label: "United Arab Emirates", "Population in 1960": 92634, "Population in 2016": 9269612},
        {label: "United Kingdom", "Population in 1960": 52400000, "Population in 2016": 65637239},
        {label: "United States", "Population in 1960": 180671000, "Population in 2016": 323127513},
        {label: "Uruguay", "Population in 1960": 2538651, "Population in 2016": 3444006},
        {label: "Uzbekistan", "Population in 1960": 8549493, "Population in 2016": 31848200},
        {label: "Vanuatu", "Population in 1960": 63699, "Population in 2016": 270402},
        {label: "Venezuela", "Population in 1960": 8146847, "Population in 2016": 31568179},
        {label: "Vietnam", "Population in 1960": 34743000, "Population in 2016": 92701100},
        {label: "Yemen", "Population in 1960": 5172135, "Population in 2016": 27584213},
        {label: "Zambia", "Population in 1960": 3044846, "Population in 2016": 16591390},
        {label: "Zimbabwe", "Population in 1960": 3747369, "Population in 2016": 16150362}
    ];
    var options = d3.keys(dataset[0]).filter(function (key) {
        return key !== "label";
    });
    dataset.forEach(function (d) {
        d.valores = options.map(function (name) {
            return {name: name, value: +d[name]};
        });
    });
    x0.domain(dataset.map(function (d) {
        return d.label;
    }));
    x1.domain(options).rangeRoundBands([0, x0.rangeBand()]);
    y.domain([0, d3.max(dataset, function (d) {
            return d3.max(d.valores, function (d) {
                return d.value;
            });
        })]);
    svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis)
            .selectAll("text")
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", "-.55em")
            .attr("transform", "rotate(-90)");
    svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", 6)
            .attr("dy", ".71em")
            .style("text-anchor", "end")
            .text("Population");
    var bar = svg.selectAll(".bar")
            .data(dataset)
            .enter().append("g")
            .attr("class", "rect")
            .attr("transform", function (d) {
                return "translate(" + x0(d.label) + ",0)";
            });
    bar.selectAll("rect")
            .data(function (d) {
                return d.valores;
            })
            .enter().append("rect")
            .attr("width", x1.rangeBand())
            .attr("x", function (d) {
                return x1(d.name);
            })
            .attr("y", function (d) {
                return y(d.value);
            })
            .attr("value", function (d) {
                return d.name;
            })
            .attr("height", function (d) {
                return height - y(d.value);
            })
            .style("fill", function (d) {
                return color(d.name);
            });
    bar
            .on("mousemove", function (d) {
                divTooltip.style("left", d3.event.pageX + 10 + "px");
                divTooltip.style("top", d3.event.pageY - 25 + "px");
                divTooltip.style("display", "inline-block");
                var x = d3.event.pageX, y = d3.event.pageY
                var elements = document.querySelectorAll(':hover');
                l = elements.length
                l = l - 1
                elementData = elements[l].__data__
                divTooltip.html("<strong>" + (d.label) + "</strong><br>" + elementData.name + ": <strong>" + numberWithCommas(elementData.value) + "</strong>");
            });
    bar
            .on("mouseout", function (d) {
                divTooltip.style("display", "none");
            });
    var legend = svg.selectAll(".legend")
            .data(options.slice())
            .enter().append("g")
            .attr("class", "legend")
            .attr("transform", function (d, i) {
                return "translate(" + "-3100," + i * 20 + ")";
            });
    legend.append("rect")
            .attr("x", width - 18)
            .attr("width", 18)
            .attr("height", 18)
            .style("fill", color);
    legend.append("text")
            .attr("x", width - 24)
            .attr("y", 9)
            .attr("dy", ".35em")
            .style("text-anchor", "end")
            .text(function (d) {
                return d;
            });
    /* States */

    var data = [{label: "",
            x: [1945, 1946, 1947, 1948, 1949, 1950, 1955, 1956, 1957, 1958, 1960, 1961, 1962, 1963, 1964, 1965, 1966, 1968, 1970, 1971, 1973, 1974, 1975, 1976, 1977, 1978, 1979, 1980, 1981, 1983, 1984, 1990, 1991, 1992, 1993, 1994, 1999, 2000, 2002, 2006, 2011, 2017],
            y: [50, 54, 56, 57, 58, 59, 75, 79, 81, 82, 99, 103, 108, 110, 113, 116, 120, 123, 124, 129, 131, 134, 140, 143, 145, 147, 148, 150, 153, 154, 155, 157, 164, 177, 183, 184, 187, 189, 191, 192, 193, 193]},
    ];
    var xy_chart = d3_xy_chart()
            .width(1300)
            .height(700)
            .xlabel("Years")
            .ylabel("Number of nations");
    var svg = d3.select("#d3-grafic-members").append("svg")
            .datum(data)
            .call(xy_chart);
});

function d3_xy_chart() {
    var width = 640,
            height = 480,
            xlabel = "X Axis Label",
            ylabel = "Y Axis Label";
    function chart(selection) {
        selection.each(function (datasets) {
            //
            // Create the plot. 
            //
            var margin = {top: 20, right: 80, bottom: 30, left: 80},
                    innerwidth = width - margin.left - margin.right,
                    innerheight = height - margin.top - margin.bottom;
            var x_scale = d3.scale.linear()
                    .range([0, innerwidth])
                    .domain([d3.min(datasets, function (d) {
                            return d3.min(d.x);
                        }),
                        d3.max(datasets, function (d) {
                            return d3.max(d.x);
                        })]);
            var y_scale = d3.scale.linear()
                    .range([innerheight, 0])
                    .domain([d3.min(datasets, function (d) {
                            return d3.min(d.y);
                        }),
                        d3.max(datasets, function (d) {
                            return d3.max(d.y);
                        })]);
            var color_scale = d3.scale.category10()
                    .domain(d3.range(datasets.length));
            var x_axis = d3.svg.axis()
                    .scale(x_scale)
                    .orient("bottom");
            var y_axis = d3.svg.axis()
                    .scale(y_scale)
                    .orient("left");
            var x_grid = d3.svg.axis()
                    .scale(x_scale)
                    .orient("bottom")
                    .tickSize(-innerheight)
                    .tickFormat("");
            var y_grid = d3.svg.axis()
                    .scale(y_scale)
                    .orient("left")
                    .tickSize(-innerwidth)
                    .tickFormat("");
            var draw_line = d3.svg.line()
                    .interpolate("basis")
                    .x(function (d) {
                        return x_scale(d[0]);
                    })
                    .y(function (d) {
                        return y_scale(d[1]);
                    });
            var svg = d3.select(this)
                    .attr("width", width)
                    .attr("height", height)
                    .append("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
            svg.append("g")
                    .attr("class", "x grid")
                    .attr("transform", "translate(0," + innerheight + ")")
                    .call(x_grid);
            svg.append("g")
                    .attr("class", "y grid")
                    .call(y_grid);
            svg.append("g")
                    .attr("class", "x axis")
                    .attr("transform", "translate(0," + innerheight + ")")
                    .call(x_axis)
                    .append("text")
                    .attr("dy", "-.71em")
                    .attr("x", innerwidth)
                    .style("text-anchor", "end")
                    .text(xlabel);
            svg.append("g")
                    .attr("class", "y axis")
                    .call(y_axis)
                    .append("text")
                    .attr("transform", "rotate(-90)")
                    .attr("y", 6)
                    .attr("dy", "0.71em")
                    .style("text-anchor", "end")
                    .text(ylabel);
            var data_lines = svg.selectAll(".d3_xy_chart_line")
                    .data(datasets.map(function (d) {
                        return d3.zip(d.x, d.y);
                    }))
                    .enter().append("g")
                    .attr("class", "d3_xy_chart_line");
            data_lines.append("path")
                    .attr("class", "line")
                    .attr("d", function (d) {
                        return draw_line(d);
                    })
                    .attr("stroke", function (_, i) {
                        return color_scale(i);
                    });
            data_lines.append("text")
                    .datum(function (d, i) {
                        return {name: datasets[i].label, final: d[d.length - 1]};
                    })
                    .attr("transform", function (d) {
                        return ("translate(" + x_scale(d.final[0]) + "," +
                                y_scale(d.final[1]) + ")");
                    })
                    .attr("x", 3)
                    .attr("dy", ".35em")
                    .attr("fill", function (_, i) {
                        return color_scale(i);
                    })
                    .text(function (d) {
                        return d.name;
                    });
        });
    }

    chart.width = function (value) {
        if (!arguments.length)
            return width;
        width = value;
        return chart;
    };
    chart.height = function (value) {
        if (!arguments.length)
            return height;
        height = value;
        return chart;
    };
    chart.xlabel = function (value) {
        if (!arguments.length)
            return xlabel;
        xlabel = value;
        return chart;
    };
    chart.ylabel = function (value) {
        if (!arguments.length)
            return ylabel;
        ylabel = value;
        return chart;
    };
    return chart;
}

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(".");
}