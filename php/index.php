<html>

<head>
<title>Cheat tools & Savegame.dat Map Editor for PlanetX3 </title>
<style> </style>
<link rel="stylesheet" type="text/css" href="map.css?v=0.2" />
</head>



<body>
<div style="float:left">
<form action="index.php" method="post" enctype="multipart/form-data">
    <label for="file">Upload your Savegame.dat:<label>
    <input type="file" name="file" id="file">
    <input type="submit" name="submit" value="Upload">
</form>
</div>
<div>Pen:    
<span id="mypen" class="p7" style="width:16px;height:16px" onclick="changePen()" >&nbsp;&nbsp;&nbsp;&nbsp;</span> 

 Source:<a href="https://github.com/zhblue/PlanetX3-tools" target="_blank">https://github.com/zhblue/PlanetX3-tools</a>
	<input type="button" onclick="cheat()" value="Cheat!">
	<input type="button" onclick="download()" value="Save it!">
	
	</div>
<div id="pattern"> </div><br>
<?php 
$file="savegame.dat";
if(isset($_FILES["file"])){
	if ($_FILES["file"]["error"] > 0)
	{
	    echo "error:" . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
	    $file= $_FILES["file"]["tmp_name"];
	}
}
$file_pointer = fopen($file, "rb");
$data = fread($file_pointer, filesize($file));
//$file_read = fread($file_pointer, 1);
fclose($file_pointer);
//echo $file;
?>

<table id="map" border="0" cellspacing="0">

<?php 
 for($i=0;$i<128;$i++){

	echo "<tr>";
	for($j=0;$j<256;$j++){
		echo "<td index='".($i*256+$j)."' title='$j $i' class='p".hexdec(bin2hex($data[$i*256+$j]))."' />";

	}
	echo "</tr>";

 }
?>
</table>
<script src="jquery.min.js" ></script>
<script src="FileSaver.min.js" ></script>
<script>

var mymap=new Uint8Array(36884);
<?php 
 for($i=0;$i<36884;$i++){
	echo "mymap[".$i."]=".hexdec(bin2hex($data[$i])).";";
 }
?>
var currentPen=7;
function download(){
    var blob = new Blob([mymap ], {type: "application/vnd.openblox.game-binary"});
    saveAs(blob, "savegame.dat");
}
function changePen(){
  currentPen++;
  if(currentPen>255) currentPen=0;
  $("#mypen").attr("class","p"+currentPen);  
}
function changePen2(p){
  currentPen=p;
  $("#mypen").attr("class","p"+currentPen);  
}
function draw(){
	for(var i=0;i<64;i++){
		$("#pattern").append('<span id="mypen" class="p'+i+'" style="width:16px;height:16px" onclick="changePen2('+i+')" >&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;');
	}
}
function draw2(){
	var tab=$("#map");
	
	var row="";
	
	for(var i=0;i<16;i++){
		for(var j=0;j<16;j++){
			var n=i*16+j;
			$("td[index="+(i*256+j+1)+"]").attr("class","p"+n);
			mymap[i*256+j+1]=n;	
		}
	}
	
}
	function cheat(){
		var pos=36867;
		mymap[pos+0]=mymap[pos+1]=mymap[pos+2]=255;
		for(pos=0x8700;pos<0x873f;pos++){
		     mymap[pos]=0xff;
		}
	
	}
var drawing=false;
$(document).ready(function(){
	$("td").attr('unselectable', 'on');
	$("td").mousedown(function(){
		drawing=true;	
		$(this).attr("class","p"+currentPen);
		mymap[$(this).attr("index")]=currentPen;
	});
	$("td").mouseup(function(){
		drawing=false;	
	});
	$("td").mouseover(function(){
		if(drawing){
			$(this).attr("class","p"+currentPen);
			mymap[$(this).attr("index")]=currentPen;
		}
	});
	$("td").click(function(){
		$(this).attr("class","p"+currentPen);
		mymap[$(this).attr("index")]=currentPen;
		
	});

	$("td").dblclick(function(){
		$(this).attr("class","p0");
		mymap[$(this).attr("index")]=0;
		
	});
	draw();
});
	
</script>
</body>

</html>
