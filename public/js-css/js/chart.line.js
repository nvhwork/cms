function showChartLine(proxyid){

  $.ajax({
    url: 'getinfoproxy/'+proxyid,
      success: function(data) {
        var display = data.display;
        var data = data.data;

        var ram =[];
        var cpu =[];
        var label =[];
        for(var i=0; i < data.length; i++){
          ram.push(data[i].ram);
          cpu.push(data[i].cpu);
          label.push('');
        }

        var data = {
          type: 'line',
          data: {
            labels: label,
            datasets: [{
              label: 'Ram (%)',
              data: ram,
              pointBackgroundColor: "#b4d2ff",
              borderColor: "#aec8f5",
              backgroundColor: "rgba(151,187,205,0.15)",
              borderWidth: 2
            }, {
              label: 'Cpu (%)',
              data: cpu,
              pointBackgroundColor: "#c5ffbb",
              borderColor: "#b7d8b2",
              backgroundColor: "rgba(220,220,220,0.15)",
              borderWidth: 2
            }]
          },
          options: {
            maintainAspectRatio: false,
          }
        }
        if(display == 1){
          Chart.defaults.global.defaultFontColor = "#fff";
        }
        else{
          Chart.defaults.global.defaultFontColor = "#404040";
        }

        Chart.defaults.global.responsive = true;

        // Get the context of the canvas element we want to select
        var ctx = document.getElementById("myChart").getContext("2d");
        ctx.height = 200;
        // Instantiate a new chart using 'data' (defined above)
        var myChart = new Chart(ctx, data);

        // end chart line //////////////////////////////////
      }
    });
}


function showChartLineNvr(nvrid){
  $.ajax({
    url: 'getinfonvr/'+nvrid,
      success: function(data) {
        var display = data.display;
        var data = data.data;

        var ram =[];
        var cpu =[];
        var label =[];
        for(var i=0; i < data.length; i++){
          ram.push(data[i].ram);
          cpu.push(data[i].cpu);
          label.push('');
        }

        var data = {
          type: 'line',
          data: {
            labels: label,
            datasets: [{
              label: 'Ram (%)',
              data: ram,
              pointBackgroundColor: "#b4d2ff",
              borderColor: "#aec8f5",
              backgroundColor: "rgba(151,187,205,0.15)",
              borderWidth: 2
            }, {
              label: 'Cpu (%)',
              data: cpu,
              pointBackgroundColor: "#c5ffbb",
              borderColor: "#b7d8b2",
              backgroundColor: "rgba(220,220,220,0.15)",
              borderWidth: 2
            }]
          },
          options: {
            maintainAspectRatio: false,
          }
        }
        if(display == 1){
          Chart.defaults.global.defaultFontColor = "#fff";
        }
        else{
          Chart.defaults.global.defaultFontColor = "#404040";
        }

        Chart.defaults.global.responsive = true;

        // Get the context of the canvas element we want to select
        var ctx = document.getElementById("myChart").getContext("2d");
        ctx.height = 200;
        // Instantiate a new chart using 'data' (defined above)
        var myChart = new Chart(ctx, data);

        // end chart line //////////////////////////////////
      }
    });
}