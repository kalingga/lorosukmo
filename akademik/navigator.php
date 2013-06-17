<?php
$pagerange = 10;
$pos=$_GET['pos'];
$lastPage=$_GET['pos']-1;

echo "Halaman: $pos";
echo " Total <b>$totalpage</b> halaman (Total Data : <b>$total</b>)<br/><br/>";
echo " Link &nbsp;&nbsp;&nbsp;";
	 
if ($pos > 9 ){
	$awal=$pos - 5;
	if (($pos) < $totalpage ){
		$akhir=$pos + 4;
	} else {
		$akhir=$totalpage;
	}
} else {
	$awal=1;
	if (($awal + 9) < $totalpage ){
		$akhir=$awal + 9;
	} else{
		$akhir=$totalpage;
	}
}

if ($lastPage > 0){
	echo "<a href='./?".$URLa."&amp;pos=".$lastPage."&amp;limit=".$_REQUEST['limit']."'>&laquo;&nbsp;Prev</a>&nbsp;";
	if ($pos > $pagerange ) {
		echo "<a class='link_paging' href='./?".$URLa."&amp;pos=1&amp;limit=".$_REQUEST['limit']."'>1</a>&nbsp;...&nbsp;<a class='link_paging' href='./?".$URLa."&amp;pos=".($pos - 6)."&amp;limit=".$_REQUEST['limit']."'>".($pos - 6)."</a>";
	}
}
	
for ($i=$awal;$i<=$akhir;$i++){  
	$sel="";
	if ($_GET['pos']==$i) $sel="link_paging_curr";
	echo "<a class='link_paging $sel' href='./?".$URLa."&amp;pos=$i&amp;limit=".$_REQUEST['limit']."'>$i</a>";
}
	 
$nextPage=$_GET['pos']+1;
if ($nextPage <= $totalpage){
	if ($totalpage > $pagerange) {
		if ($pos <= $pagerange ) {
			echo "<a class='link_paging' href='./?".$URLa."&amp;pos=".($pagerange+1)."&amp;limit=".$_REQUEST['limit']."'>".($pagerange+1)."</a>&nbsp;...&nbsp;<a class='link_paging' href='./?".$URLa."&amp;pos=".$totalpage."&amp;limit=".$_REQUEST['limit']."'>".$totalpage."</a>";
		} elseif (($totalpage - 1)== $pos ) {
			echo "<a class='link_paging' href='./?".$URLa."&amp;pos=".$totalpage."&amp;limit=".$_REQUEST['limit']."'>".$totalpage."</a>";				
		} else {
			echo "<a class='link_paging' href='./?".$URLa."&amp;pos=".($pos+5)."&amp;limit=".$_REQUEST['limit']."'>".($pos+5)."</a>&nbsp;...&nbsp;<a class='link_paging' href='./?".$URLa."&amp;pos=".$totalpage."&amp;limit=".$_REQUEST['limit']."'>".$totalpage."</a>";		
		}
	}
	echo "&nbsp;<a href='./?".$URLa."&amp;pos=".($pos + 1)."&amp;limit=".$_REQUEST['limit']."'>Next&nbsp;&raquo;</a>";
}	
?>