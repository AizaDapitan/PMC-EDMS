<table width="100%" style="font-style:Arial;font-size:14px;">
	<tr>
			<td colspan="5" align="center" style="font-style:Arial;font-size:16px;font-weight:bold;"><br><br>Downtime Report Pareto Chart</td>
		</tr>
		<tr>
			<td colspan="5" align="center">{{ date('F d Y') }}  -  {{ date('F d Y') }}<br><br><br></td>
		</tr>			
	</tr>
	<tr style="font-weight:bold;color:blue;">
		<td>Unit</td>
		<td>Mins</td>
		<td>Accumulative Amount</td>
		<td>Cummulative %</td>
 	</tr>	
 	<tr><td colspan="5"><hr></td></tr>							
 	@foreach( $displayData as $data )

		<tr>
			<td>{{ $data['unit'] }} </td>
			<td>{{ $data['mins'] }} </td>
			<td>{{ array_key_exists( 'downtime' , $data ) ? $data['downtime'] : "-" }} </td>
			<td>{{ array_key_exists( 'percentage' , $data ) ? $data['percentage'] : "" }}</td>
		</tr>

	@endforeach
	<tr><td colspan="5"><hr></td></tr>
</table>