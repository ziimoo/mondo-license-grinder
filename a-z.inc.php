<?php
$initials=$db->getInitialsForNavigation();
if($initials){
    $j=empty($_GET['initial'])?'':$_GET['initial'];
    foreach($initials as $initial){
        $i=$initial['initial'];
        if($i!=$j){
            $nav[]='<a href="browse.php?initial='.$i.'">'.$i.'</a>';
        }else{
            $nav[]="<strong>$j</strong>";
        }
    }
    $nav=implode(' ',$nav);
    echo "<div id=\"az\">$nav</div>";
}