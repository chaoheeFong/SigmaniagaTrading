@extends('layouts.app')

@section('content')

<style>
	tr:hover {
		background-color: #F8FAFD;
	}
</style>

<body>
<div class="container">
    <div class="row justify-content-center">

		<div class="header">
			<div class="centered-header">Masnur Sales Analysis</div>
		</div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header centered-text">Search Date</div>
                    <div class="card-body">

						@csrf
                            <div class="body-header">
                                <div class="item">
                                    <label class="header">Date</label>
                                    <input type="date" id="terminated_date" name="terminated_date" class="form-control"  required  placeholder="Select date"></input>
									@error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                	@enderror
                                </div>
                                <div class="centered-text">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>  

                    </div>            
                </div>
            </div>


            <div style="display: grid; grid-template-columns: 1fr auto;">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary d-block mr-0 ml-auto" onclick="window.location.href='/subscriber/transaction/create'" style="justify-self: end;">
					Add Transaction
				</button>
			</div>
			
			<div class="table-container">
			<table id="on-going-transaction-table" class="table table-hover centered-table">
				<thead>
					<tr>
						<th colspan="18" style="background-color:#DAF5FF">Date</th>

						<th colspan="1" style="background-color:#DAF5FF">Action </th>
					</tr>
					<tr>
						<th style="background-color:#DAF5FF">Ref ID</th>
						<th style="background-color:#DAF5FF">Start Date</th>
						<th style="background-color:#DAF5FF">QM Sell (RM/g)</th>
						<th style="background-color:#DAF5FF">Downpayment (RM)</th>
						<th style="background-color:#DAF5FF">Downpayment Covert (RM)</th>
						<th style="background-color:#DAF5FF">Convert Grammage</th>
						<th style="background-color:#DAF5FF">Holding Grammage</th>
						<th style="background-color:#DAF5FF">Retained Amount (RM)</th>


						<th style="background-color:#B0DAFF">Termination Date</th>
						<th style="background-color:#B0DAFF">QM Buy (RM/g)</th>
						<th style="background-color:#B0DAFF">Current Value</th>
						<th style="background-color:#B0DAFF">Days</th>

						<th style="background-color:#B0DAFF">Total Management Fee   (RM) </th>
						<th style="background-color:#B0DAFF">Nett Cash Out (RM) </th>
						<th style="background-color:#B0DAFF">Profit / Loss (RM)</th>
						<th style="background-color:#B0DAFF">% of Profit / Loss (RM)</th>
						
						<th style="background-color:#DAF5FF">Terminate</th>
					</tr>
				</thead>
			</table>
			</div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

@endsection