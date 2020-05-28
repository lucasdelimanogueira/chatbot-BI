<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		
		<title>BI - Bot</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- plotly - link cdn -->
		<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">
			$(document).ready(function(){
				
				//se btn ask clicado
				$("#btn_ask").click(function(){
					
					//verificar se campo texto está digitado
					if($("#txt_ask").val().length > 0){
					
						$.ajax({
							url: "controller/QueryController.php/",
							type: "POST",
							data: $("#form_ask").serialize(),

							success: function(data){
								$("#txt_ask").val('');
								$("#graph").html(data);
							}
						});
					}

				});

			});
		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	         
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	    	<div id="tweets_users_amount" class="col-md-3">
	    		
	    	</div>
	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">

	    				<form id="form_ask">
		    				<div class="input-group">
		    					<input type="text" class="form-control" id="txt_ask" name="query" placeholder="Faça um pedido" maxlength="140" name="">
		    					<span class="input-group-btn">
		    						<button class="btn btn-default" id="btn_ask" type="button">Pedir</button>
		    					</span>
		    				</div>
		    			</form>
	    			</div>
	    		</div>
	    	</div>
			<div class="col-md-3">
				
			</div>

			<div class="clearfix"></div>

		</div>

		<div id="graph">
	    			
	    </div>

	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>