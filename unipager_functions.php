<?php
        error_reporting(E_ALL);

        // START PAGINATION CODES
		function frstPage($pageNumber, $expctd_first_page) {
			if( (isset($pageNumber) && $pageNumber==$expctd_first_page) || (!isset($pageNumber)) ) {return true;} return false;
		}
		function lstPage($pageNumber, $total_pages) {
			if( (isset($pageNumber) && $pageNumber==$total_pages)) {return true;} return false;
		}
		
		function curPage($pageNumber, $current_pageNumber) {if(isset($pageNumber)) {$current_pageNumber = $pageNumber;} return $current_pageNumber;}	
		function checkRequest($requestkey) {if(isset($_REQUEST[$requestkey])) {return $_REQUEST[$requestkey];} else {return false;}}
		function constructLink($qurfront, $nextprev_pageNumber) {$link=$qurfront."page=$nextprev_pageNumber"; return $link;}
		
		function pageToggle($dir, $totpages, $thecurpge, $qurfront, $pageNumber) {		
			if($dir=='left') {
				if(frstPage($pageNumber, 1)==false) {
					$prevP=$thecurpge-1;
					$prevlink = constructLink($qurfront, $prevP);
					echo "<a href='$prevlink' class='bpagetog bptoA'><i class='fa fa-arrow-circle-left' aria-hidden='true'></i>< </a>";
				}
			}
			if($dir=='right') {
				if($thecurpge!=$totpages) {
				  $nextP=$thecurpge+1;
				  $nextlink = constructLink($qurfront, $nextP);
				  echo "&nbsp;&nbsp;<a href='$nextlink' class='bpagetog bptoB'><i class='fa fa-arrow-circle-right' aria-hidden='true'></i>></a>";
				}
			}
		}
		
		function uniPager($pageNumber, $current_pageNumber, $totpages, $pager_threshold, $totalResults, $numRecords) { 
			    $thecurpge = curPage($pageNumber, $current_pageNumber); // current page
			    $prevpge = 1; // previous page
			    $qurfront = "?"; // to reconstruct next and prev links
			    //$pager_threshold = 49; // when to show pagination
			    //$totalResults = $_SESSION['total-results'];
			    //$numRecords = 12; // number of items to show per page
			    $totpages = ceil($totalResults/$numRecords); //total pages

				if($totalResults > $pager_threshold) {  
					
					if(checkRequest('search')) {
						// without page
						if( checkRequest('page')==false ) { $qurfront = $_SERVER['REQUEST_URI']."&";}
						// with page
						if( checkRequest('page')!=false ) { $urlparts = explode('&page', $_SERVER['REQUEST_URI'] ); $qurfront = $urlparts[0]."&";}
					}
					
					/* output pagination links */
					echo '<div class="seapager curved">';
					pageToggle('left', $totpages, $thecurpge, $qurfront, $pageNumber);
					
					   // PREVIOUS LINKS					   
					   if(frstPage($pageNumber, $current_pageNumber)==false) {
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
					   if(lstPage($pageNumber,$totpages)==false) {
						   $nextpge = $thecurpge+1;
						   $nextpge_2 = $thecurpge+2;
						   $nextpge_3 = $thecurpge+3;
						   
						   if($nextpge<=$totpages) {$nextlink=$qurfront."page=$nextpge"; echo "<a href='$nextlink'>$nextpge</a>&nbsp;&nbsp;";}
						   if($nextpge_2<=$totpages) {$nextlink=$qurfront."page=$nextpge_2"; echo "<a href='$nextlink'>$nextpge_2</a>&nbsp;&nbsp;";}
						   if($nextpge_3<=$totpages) {$nextlink=$qurfront."page=$nextpge_3"; echo "<a href='$nextlink'>$nextpge_3</a>&nbsp;&nbsp;";}
						   
						   $sep=''; if($thecurpge < ($totpages-4)) {$sep='... ';}
						   if($thecurpge <=($totpages-4)) { $prevlink=$qurfront."page=$totpages"; echo "$sep<a href='$prevlink'>$totpages</a>";}
					   }
					   
                    pageToggle('right', $totpages, $thecurpge, $qurfront, $pageNumber);
					//echo "<br />Total Page: $totpages / Current Page: $thecurpge";
					echo '</div>';
				}
		}
		// END PAGINATION CODES
		
		
		// TESTS
		// if(lstPage(2, 1)==true) {echo 'pass';} else {echo 'fail';} // pass
		// echo curPage(checkRequest('page'), 1); // pass
		// pageToggle(checkRequest('page'), 'left', 26, 5, '?'); // pass
		uniPager(checkRequest('page'), 5, 26, 5, 14, 12); pass	
?>
