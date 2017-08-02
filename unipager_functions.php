<?php
        // START PAGINATION CODES
		function frstPage() {
			if( (isset($_GET['page']) && $_GET['page']==1) || (!isset($_GET['page'])) ) {return true;} return false;
		}
		function lstPage($totpages) {
			if( (isset($_GET['page']) && $_GET['page']==$totpages)) {return true;} return false;
		}
		
		function curPage() {$thecurpge = 1; if(isset($_GET['page'])) {$thecurpge = $_GET['page'];} return $thecurpge;}
		
		function pageToggle($dir, $totpages, $thecurpge, $qurfront) {
			if($dir=='left') {
				if(frstPage()==false) {
					$prevP=$thecurpge-1;
					$prevlink=$qurfront."page=$prevP";
					echo "<a href='$prevlink' class='bpagetog bptoA'><i class='fa fa-arrow-circle-left' aria-hidden='true'></i></a>";
				}
			}
			if($dir=='right') {
				if($thecurpge!=$totpages) {
				  $nextP=$thecurpge+1;
				  $nextlink=$qurfront."page=$nextP";
				  echo "&nbsp;&nbsp;<a href='$nextlink' class='bpagetog bptoB'><i class='fa fa-arrow-circle-right' aria-hidden='true'></i></a>";
				}
			}
		}
		
		function uniPager() {
			    $thecurpge = curPage(); // current page
			    $prevpge = 1; // previous page
			    $pager_threshold = 49; // when to show pagination
			    $totalResults = $_SESSION['total-results'];
			    $qurfront = "?"; // to reconstruct next and prev links
			    $numRecords = 12; // number of items to show per page
			    $totpages = ceil($totalResults/$numRecords); //total pages

				if($totalResults > $pager_threshold) {  
					
					if(isset($_GET['Search'])) {
						// without page
						if( !isset($_GET['page']) ) { $qurfront = $_SERVER['REQUEST_URI']."&";}
						// with page
						if( isset($_GET['page']) ) { $urlparts = explode('&page', $_SERVER['REQUEST_URI'] ); $qurfront = $urlparts[0]."&";}
					}
					
					/* output pagination links */
					echo '<div class="seapager curved">';
					pageToggle('left', $totpages, $thecurpge, $qurfront);
					
					   // PREVIOUS LINKS					   
					   if(frstPage()==false) {
					    $prevpge = $thecurpge-1;
					    $prevpge_2 = $thecurpge-2;
					    $prevpge_3 = $thecurpge-3;
					    
					    // to show start link we must check if we are more than 5 away from curpage
					    $sep=''; if($thecurpge>5) {$sep='... ';}
					    if($thecurpge>=5) { $prevlink=$qurfront."page=1"; echo "<a href='$prevlink'>1</a>&nbsp;&nbsp;$sep";}
					    
					    if($prevpge_3>=1) { $prevlink=$qurfront."page=$prevpge_3"; echo "<a href='$prevlink'>$prevpge_3</a>&nbsp;&nbsp;";}
					    if($prevpge_2>=1) { $prevlink=$qurfront."page=$prevpge_2"; echo "<a href='$prevlink'>$prevpge_2</a>&nbsp;&nbsp;";}
					    if($prevpge>=1) { $prevlink=$qurfront."page=$prevpge"; echo "<a href='$prevlink'>$prevpge</a>&nbsp;&nbsp;";}
					   }
					   
					   // CURRENT PAGE
					   $link=$qurfront."page=$thecurpge";
					   echo "<a class='isel' href='$link'>$thecurpge</a>&nbsp;&nbsp;";				   				   
					   
					   // NEXT LINKS
					   if(lstPage($totpages)==false) {
						   $nextpge = $thecurpge+1;
						   $nextpge_2 = $thecurpge+2;
						   $nextpge_3 = $thecurpge+3;
						   
						   if($nextpge<=$totpages) {$nextlink=$qurfront."page=$nextpge"; echo "<a href='$nextlink'>$nextpge</a>&nbsp;&nbsp;";}
						   if($nextpge_2<=$totpages) {$nextlink=$qurfront."page=$nextpge_2"; echo "<a href='$nextlink'>$nextpge_2</a>&nbsp;&nbsp;";}
						   if($nextpge_3<=$totpages) {$nextlink=$qurfront."page=$nextpge_3"; echo "<a href='$nextlink'>$nextpge_3</a>&nbsp;&nbsp;";}
						   
						   $sep=''; if($thecurpge < ($totpages-4)) {$sep='... ';}
						   if($thecurpge <=($totpages-4)) { $prevlink=$qurfront."page=$totpages"; echo "$sep<a href='$prevlink'>$totpages</a>";}
					   }
					   
                    pageToggle('right', $totpages, $thecurpge, $qurfront);
					//echo "<br />Total Page: $totpages / Current Page: $thecurpge";
					echo '</div>';
				}
		}
		// END PAGINATION CODES
?>