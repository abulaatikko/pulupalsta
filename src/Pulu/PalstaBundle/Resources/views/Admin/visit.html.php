<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container"></div>
<script type="text/javascript">
const chart = Highcharts.chart('container', {
    chart: {height: '1000px'},
    xAxis: {type: 'datetime'},
    plotOptions: {
        line: {
            marker: {enabled: false}
        }
    }
});

const run = () => fetch('api/visit', {
    credentials: 'same-origin'  
})
.then(res => res.json())
.then(data => {
    data.forEach((serie) => {
        let values = []
        let cumulativeVisits = 0

        serie.visits.forEach((row) => {
            cumulativeVisits += row.visits
            values.push({
                x: new Date(row.month),
                y: cumulativeVisits
            })
        })

        chart.addSeries({
            name: serie.article,
            data: values
        }, false)
  
    })
    chart.redraw();
})

run()
</script>

<style>
#container {
    height: 100%;
}
</style>



