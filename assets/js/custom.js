require(['core/first', 'jquery', 'jqueryui', 'core/ajax','core/str'],
    function(core, $, bootstrap, ajax, str) {

    //chart config
    var xValues = [];
    var yValues = [];
    var barColors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',]
    ;

    var doughtnutChartData = [];

    // -----------------------------
    $(document).ready(function() {
        $('#courseinfo').hide();
        $('#doughnut').hide();
            // get current value then call ajax to get new data
            ajax.call([{
                methodname: 'tool_coursestatistics_get_grades',
                args: {},
            }])[0].done(function(response) {
                // clear out old values
                let res = $.parseJSON(response);
                console.log(res);
                $.each( res.passed, function( key, r ) {
                    xValues.push(r.shortname);
                    yValues.push(r.passed);
                    $.each( res.failed, function( key, r ) {

                    });
                });

                var ts = str.get_strings([
                    {key: 'coursestatistics', component: 'tool_coursestatistics'},
                ]);

                new Chart("myChart", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            label: M.util.get_string('coursestatistics_passed', 'tool_coursestatistics'),
                            backgroundColor: barColors,
                            borderColor: 'rgba(0,0,0,0.5)',
                            borderWidth: 1,
                            data: yValues
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            display: true,
                            text: M.util.get_string('coursestatistics_passed', 'tool_coursestatistics')
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    //sanitize y-axis label
                                    callback: (label) => parseInt(label) < label ? '' : label
                                }
                            }]
                        }
                    }
                });

                xValues = [];
                yValues = [];

                $.each( res.failed, function( key, r ) {
                    xValues.push(r.shortname);
                    yValues.push(r.failed);
                });

                new Chart("failed", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            label: M.util.get_string('coursestatistics_failed', 'tool_coursestatistics'),
                            backgroundColor: barColors,
                            borderColor: 'rgba(0,0,0,0.5)',
                            borderWidth: 1,
                            data: yValues
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            display: true,
                            text: M.util.get_string('coursestatistics_failed', 'tool_coursestatistics')
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    //sanitize y-axis label
                                    callback: (label) => parseInt(label) < label ? '' : label
                                }
                            }]
                        }
                    }
                });

                return;
            }).fail(function(err) {
                console.log('error');
                //notification.exception(new Error('Failed to load data'));
                return;
            });


        $('#id_courses').change(function(){
            var selectedid = $('#id_courses').val();
            ajax.call([{
                methodname: 'tool_coursestatistics_getgradesbycourse',
                args: {'courseid': selectedid},
            }])[0].done(function(response) {
                console.log($.parseJSON(response));
                var chartdata = $.parseJSON(response);
                if(Object.values(chartdata).every(o => o === null)){
                    $('#courseinfo').hide();
                    $('#doughnut').hide();
                    return false;
                }

                const data = {
                    labels: [
                        M.util.get_string('coursestatistics_passed', 'tool_coursestatistics'),
                        M.util.get_string('coursestatistics_failed', 'tool_coursestatistics')
                    ],
                    datasets: [{
                        label: M.util.get_string('coursestatistics', 'tool_coursestatistics'),
                        data: [chartdata.passed, chartdata.failed],
                        backgroundColor: [
                            'rgb(46, 204, 113)',
                            'rgb(231, 76, 60)'
                        ],
                        hoverOffset: 4
                    }]
                };

                const config = {
                    type: 'doughnut',
                    data: data,
                };

                new Chart(document.getElementById("doughnut"), config);

                $('#courseinfo').show();
                $('#courseinfo').html(chartdata.course);
                $('#doughnut').show();

                return;
            }).fail(function(err) {
                $('#doughnut').hide();
                console.log('error');
                return;
            });
        });
    });
});
