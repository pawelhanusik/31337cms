<?php
include("header.php");
include("menu.php");
?>

<?php

$filePath = "../stats.log";

$data_raw = file_get_contents($filePath);
$data_raw = explode("\n", $data_raw);
$data = [];
foreach($data_raw as $line){
	$line = explode("\t", $line);
	if(count($line) === 2){
		$timestamp = $line[0];
		$ip = $line[1];
		
		$data[] = Array(
			'timestamp' => $timestamp,
			'ip' => $ip
		);
	}
}

$totalVisits = count($data);
$uniqueVisits = count(array_unique(array_column($data, 'ip')));

$todayVisitsRows = [];
foreach($data as $row){
	if( date('Ymd', $row['timestamp']) === date('Ymd') ){
		$todayVisitsRows[] = $row;
	}
}
$todayVisits = count($todayVisitsRows);
$todayUniqueVisits = count(array_unique(array_column($todayVisitsRows, 'ip')));

?>

<div id="content">
	<h2>Statistics</h2>
	<table>
		<tr>
			<td>Total visits:</td>
			<td><?php echo $totalVisits; ?></td>
		</tr>
		<tr>
			<td>Unique visits:</td>
			<td><?php echo $uniqueVisits; ?></td>
		</tr>
		<tr>
			<td>Today visits:</td>
			<td><?php echo $todayVisits; ?></td>
		</tr>
		<tr>
			<td>Today unique visits:</td>
			<td><?php echo $todayUniqueVisits; ?></td>
		</tr>
	</table>
</div>
<?php
include("footer.php");
?>