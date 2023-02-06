<?php
$admin_session = $this->session->userdata('admin');
$role = $admin_session['role'];
?>

<div class="row">
  <div class="col-lg-12 mt-4">
    <div class="card">
      <div class="card-header form-card-header">
        <h4 class="m-b-0 text-light text-center"><?php echo $role;?></h4>
      </div>
	<?php 
	if($role == "Super Admin"){
    $totalTicketCount = Modules::run("admin/counter/tickets","");
    $openTicketCount = Modules::run("admin/counter/ticketStatus","1");
    $pendingTicketCount = Modules::run("admin/counter/ticketStatus","2");
    $resolvedTicketCount = Modules::run("admin/counter/ticketStatus","3");
    $closedTicketCount = Modules::run("admin/counter/ticketStatus","4");
    $dataTickets = Modules::run("admin/counter/getChartData","");
    $openDataTickets = Modules::run("admin/counter/getOpenTicketData","");
    $pendingDataTickets = Modules::run("admin/counter/getPendingTicketData","");
    $resolvedDataTickets = Modules::run("admin/counter/getResolvedTicketData","");
    $closedDataTickets = Modules::run("admin/counter/getClosedTicketData","");
	//echo '<pre>'; print_r($resolvedDataTickets); 
	?>
    <div class="card-body">
					<div class="main-content">
					<div>
					<div>
					<div class="header pb-6 pb-8 pt-5 pt-md-8 bg-gradient-success bg-success">
					<div class="container-fluid">
					<div class="header-body">
					<div class="row">
					
					<div class="col-md-6 col-xl-3">
					<div class="card card-stats mb-4" show-footer-line="true">
					<div class="card-body">
					<div class="row">
					<div class="col">
					<h5 class="card-title text-uppercase text-muted mb-0">Total Tickets</h5>
					<span class="h2 font-weight-bold mb-0"><?php echo $totalTicketCount;?></span>
					</div>
					</div>
					</div>
					</div>
					</div>
					
					<div class="col-md-6 col-xl-3">
					<div class="card card-stats mb-4" show-footer-line="true">
					<div class="card-body">
					<div class="row">
					<div class="col">
					<h5 class="card-title text-uppercase text-muted mb-0">Open Tickets</h5>
					<span class="h2 font-weight-bold mb-0"><?php echo $openTicketCount;?></span>
					</div>
					</div>
					</div>
					</div>
					</div>
					
					<div class="col-md-6 col-xl-3">
					<div class="card card-stats mb-4" show-footer-line="true">
					<div class="card-body">
					<div class="row">
					<div class="col">
					<h5 class="card-title text-uppercase text-muted mb-0">Pending Tickets</h5>
					<span class="h2 font-weight-bold mb-0"><?php echo $pendingTicketCount;?></span></div>
					</div>
					</div>
					</div>
					</div>
					
					<div class="col-md-6 col-xl-3">
					<div class="card card-stats mb-4" show-footer-line="true">
					<div class="card-body">
					<div class="row">
					<div class="col">
					<h5 class="card-title text-uppercase text-muted mb-0">Resolved Tickets</h5>
					<span class="h2 font-weight-bold mb-0"><?php echo $resolvedTicketCount;?></span>
					</div>
					<div class="col-auto">
					<div class="icon icon-shape text-white rounded-circle shadow bg-gradient-info"><i class="ni ni-chart-bar-32"></i></div></div>
					</div>
					</div>
					</div>
					</div>
					
					<div class="col-md-6 col-xl-3">
					<div class="card card-stats mb-4" show-footer-line="true">
					<div class="card-body"><div class="row"><div class="col"><h5 class="card-title text-uppercase text-muted mb-0">Closed Tickets</h5><span class="h2 font-weight-bold mb-0"><?php echo $closedTicketCount;?></span></div><div class="col-auto"><div class="icon icon-shape text-white rounded-circle shadow bg-gradient-info"><i class="ni ni-chart-bar-32"></i></div></div></div></div></div>
					</div>					
					</div>
					</div>
					</div>
					</div>
					<!--
					<div class="mt--7 container-fluid">
					<div class="row">
					<div class="mb-5 mb-xl-0 col-xl-8">
					<div class="card bg-default">
					
					<div class="card-body"><div class=""><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
					
					<canvas id="line-chart" width="918" height="437" style="display: block; height: 350px; width: 735px;" class="chartjs-render-monitor"></canvas>
					</div></div>
					</div>
					</div></div>
					</div>-->
					</div></div></div>
	</div>
<?php } ?>
</div></div></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<script>var CI_ROOT = '<?php echo base_url()?>';</script>
<!--<script>
$(document).ready(function(){	 
		function showGraph()
		{ 
		$.ajax({
			type:"POST",
			url:CI_ROOT+"admin/counter/getChartData",
			dataType: 'json',
			beforeSend:function() { 
				showLoader();
			},
			success : function(result){ alert(result);
				hideLoader();
				if(result == 1){
					window.location.reload();
				}else{
					//alert(result);
					window.location.reload();
				}
			}
		});
		}
		
		showGraph();
		
	});
</script>-->
<script>
			<?php
			foreach($dataTickets as $tkt){
				$date[] = $tkt->created_date; 
			}
			foreach($openDataTickets as $opentkt){
				$opentkts[] = $opentkt->countx; 
			}
			foreach($pendingDataTickets as $pendingkt){
				$pendingtkts[] = $pendingkt->countx; 
			}
			foreach($resolvedDataTickets as $resolvedtkt){
				$resolvedtkts[] = $resolvedtkt->countx; 
			}
			foreach($closedDataTickets as $closedtkt){
				$closedtkts[] = $closedtkt->countx; 
			}
			?>
new Chart(document.getElementById("line-chart"), {
  type: 'line',
  data: {
			labels: [<?php
			foreach($date as $dates){
				echo $ss = "'".$dates."',";
			}?>],
    //labels: ['2023-01-23 12:46:04', '2023-01-24 12:46:04', '2023-01-25 12:46:04','2023-01-26 12:46:04'],
	datasets: [{ 
        data: [<?php
			foreach($opentkts as $open){
				echo $open = $open.",";
			}?>],
        label: "Open",
        borderColor: "#00c292",
        fill: false
		}, { 
        data: [<?php
			foreach($pendingtkts as $pending){
				echo $pending = $pending.",";
			}?>],
        label: "Pending",
        borderColor: "#fec107",
        fill: false
		},
		{ 
        data: [<?php
			foreach($resolvedtkts as $resolved){
				echo $resolved = $resolved.",";
			}?>],
        label: "Resolved",
        borderColor: "#03a9f3",
        fill: false
		},
		{ 
        data: [<?php
			foreach($closedtkts as $closed){
				echo $closed = $closed.",";
			}?>],
        label: "Closed",
        borderColor: "#e46a76",
        fill: false
		}
    ]
	
    /*datasets: [{ 
        data: [86,500,400],
        label: "Open",
        borderColor: "#00c292",
        fill: false
		}, { 
        data: [282],
        label: "Pending",
        borderColor: "#fec107",
        fill: false
		},
		{ 
        data: [28],
        label: "Resolved",
        borderColor: "#03a9f3",
        fill: false
		},
		{ 
        data: [5267],
        label: "Closed",
        borderColor: "#e46a76",
        fill: false
		}
    ] */
  },
  options: {
    title: {
      display: true,
      text: 'Opened tickets this week'
    }
  }
});
</script>