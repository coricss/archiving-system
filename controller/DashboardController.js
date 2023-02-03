$(function(){
  $.ajax({
    url: '../../model/DashboardModel.php?action=countData',
    type: 'GET',
    dataType: 'json',
    beforeSend: function(){
      // $('#total-users').html('<i class="fa fa-spinner fa-spin"></i>');
      // $('#total-file-archives').html('<i class="fa fa-spinner fa-spin"></i>');
      // $('#total-approved-requests').html('<i class="fa fa-spinner fa-spin"></i>');
      // $('#total-rejected-requests').html('<i class="fa fa-spinner fa-spin"></i>');
      $('.overlay.dark').show();
    },
    success: function(data){
      $('.overlay.dark').hide();
      $('#total-users').html(data.total_users);
      $('#total-file-archives').html(data.total_files);
      $('#total-approved-requests').html(data.approved_files);
      $('#total-rejected-requests').html(data.rejected_files);
    }
  });

  //BAR GRAPH

  const file_archive = document.getElementById('card-file-bar-graph');
  
  var currentYear = new Date().getFullYear();
  var yearEstablished = 2017;
  var yearDiff = currentYear - yearEstablished;

  var years = [];

  for(var i = 0; i <= yearDiff; i++){
    years.push(yearEstablished + i);
  }

  $.ajax({
    url: '../../model/DashboardModel.php?action=countFileArchivesPerBatch',
    type: 'GET',
    dataType: 'json',
    data: {years: years},
    success: function(data){
      new Chart(file_archive, {
        type: 'bar',
        data: {
          labels: years,
          datasets: [{
            minBarLength: 10,
            label: '# of File Archive per batch',
            data: data,
            borderWidth: 1,
            backgroundColor : '#28a745b0',
            hoverBackgroundColor : '#28a745',
          }]
        },
        options: {
          // maintainAspectRatio : false,
          // aspectRatio: 1,
          // responsive : false,
          title: {
            display: true,
            text: 'File Archives per Batch',
            fontSize: 12,
            fontColor: '#000',
            fontStyle: 'bold',
            padding: 20,
    
          },
          legend: {
            display: true,
            position: 'bottom',
            labels: {
                boxWidth: 10,
                fontSize: 10,
                padding: 10
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                  beginAtZero: true,

              }
            }],
            xAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 10
                }
            }]
          }
        }
      });
    }
  })

  

  //PIE GRAPH

  const file_type = document.getElementById('card-file-pie-graph');

  $.ajax({
    url: '../../model/DashboardModel.php?action=countFileTypes',
    type: 'GET',
    dataType: 'json',
    success: function(data){
      new Chart(file_type, {
        type: 'pie',
        data: {
          labels: data.file_type,
          datasets: [{
              data: data.total_file_type,
              backgroundColor : [
                  '#28a745',
                  '#17a2b8',
                  '#ffc107',
                  '#6f42c1',
                  '#dc3545'
              ],
          }]
        },
        options: {
          title: {
              display: true,
              text: 'No. of File Types Requested',
              fontSize: 12,
              fontColor: '#000',
              fontStyle: 'bold',
              padding: 20,
    
          },
          legend: {
              display: true,
              position: 'bottom',
              labels: {
                  boxWidth: 10,
                  fontSize: 10,
                  padding: 10
              }
          }
        }
      });
    }
  })
});