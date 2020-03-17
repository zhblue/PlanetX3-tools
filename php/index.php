<html>

<head>
<title>Cheat tools & Savegame.dat Map Editor for PlanetX3 </title>
<style> </style>
<link rel="stylesheet" type="text/css" href="map.css?v=0.4" />
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
	<input type="button" onclick="army()" value="Army!">
	<input type="button" onclick="download()" value="Save it!">
	
	</div>
<div id="pattern" > </div><br>
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
<br><br><br><br>
<script src="jquery.min.js" ></script>
<script src="FileSaver.min.js" ></script>
<script>

var mymap=new Uint8Array([
<?php 
 for($i=0;$i<36884;$i++){
	echo hexdec(bin2hex($data[$i]));
	if ($i<36883) echo ",";
 }
?>]);
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
	for(var i=0;i<256;i++){
		$("#pattern").append('<span title="'+i+'" id="mypen" class="p'+i+'" style="width:16px;height:16px" onclick="changePen2('+i+')" >&nbsp;&nbsp;&nbsp;&nbsp;</span>');
		if(i%8==7){
			$("#pattern").append('<br>');
		}
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
	function army(){
		var pos=0x8000;
		for(pos=0x8002;pos<0x8013;pos++){
		     mymap[pos]=0x03; //heavy tank
		}
		pos=0x8100;
		var x= mymap[pos];
		pos=0x8200;
		var y= mymap[pos];
		for(pos=0x8102;pos<0x8113;pos++){
		     x++;
		     setXYwithPen(x,y,140);
		     mymap[pos]=x;
		
		}
		for(pos=0x8202;pos<0x8213;pos++){
		     mymap[pos]=y;
		}
		cheat();	
	}
	function cheat(){
		var pos=36867;
		mymap[pos+0]=mymap[pos+1]=mymap[pos+2]=255;
		for(pos=0x8700;pos<0x873f;pos++){
		     mymap[pos]=0xff;
		}
	
	}
var drawing=false;
const big=[36,38,104,106,108,120,122,124,126,136,138,184,186,188,190,204,206,216,218,232];
const ECT=0x8080; // enemy construction type
const ECX=0x8180; // enemy construction X
const ECY=0x8280;// enemy construction Y
const ECH=0x8780;// enemy construction Health
	
const CT=0x8014; //  construction type
const CX=0x8114; //  construction X
const CY=0x8214;//  construction Y
const CH=0x8714;//  construction Health
const MS=0x8910;//  Missile fill up

	
const UT=0x8000;//unit type
const UX=0x8100;//unit x
const UY=0x8200;//unit y
const UH=0x8700;//unit health

function setXYwithPen(x,y,pen){
	setIndexWithPen(x+y*256,pen);
}
function setIndexWithPen(index,pen){
	$("td[index="+(index)+"]").attr("class","p"+pen);	
	mymap[index]=pen;

}
function nextNum(base){
	var num=0;
	while(mymap[base+num]>0) num++;
        return num;
}
function X(index) { return index % 256};
function Y(index) { return Math.floor(index / 256) };
var nextHQ=0;
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
		var i=parseInt($(this).attr("index"));
		setIndexWithPen(i,currentPen);
		if(big.includes(currentPen)){
		   setIndexWithPen(i+1,currentPen+1);
		   setIndexWithPen(i+256,currentPen+8);
		   setIndexWithPen(i+257,currentPen+9);
		}
		if(currentPen==204){ // add new enemy HQ 
		   var num=nextHQ++ %3;
	           mymap[ECT+num]=21;
	           mymap[ECX+num]=X(i);
	           mymap[ECY+num]=Y(i);
	           mymap[ECH+num]=0xFA;
		}
		
		if(currentPen==140){ // add new heavy tank
		   var num=nextNum(UT);
	           mymap[UT+num]=0x03;
	           mymap[UX+num]=X(i);
	           mymap[UY+num]=Y(i);
	           mymap[UH+num]=0xFF;
		}
		if(currentPen==138){ // add new missile silo
		   var num=nextNum(CT);
	           mymap[CT+num]=0x1A;
	           mymap[CX+num]=X(i);
	           mymap[CY+num]=Y(i);
	           mymap[CH+num]=0xFF;
		   mymap[MS+num]=0x01;  // missile fill up
		}
		
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
