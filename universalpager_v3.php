<?php
        error_reporting(E_ALL);
        // START PAGINATION CODES
        function getURL_up() {$x=explode("/", $_SERVER['REQUEST_URI']);return $x;} $theurls = getURL_up();

        /**
         * Check if we are on the first page or pagination not activated
         * @param int $pagenumber - 
         */
		function frstPage($pageNumber, $expctd_first_page) {
			if( (isset($pageNumber) && $pageNumber==$expctd_first_page) || (!isset($pageNumber)) ) {return true;} return false;
		}
		function lstPage($pageNumber, $total_pages) {
			if( (isset($pageNumber) && $pageNumber==$total_pages)) {return true;} return false;
		}
		function curPage($pageNumber, $current_pageNumber) {if(isset($pageNumber)) {$current_pageNumber = $pageNumber;} return $current_pageNumber;}	
		
		function checkRequest($requestkey) {if(isset($_REQUEST[$requestkey])) {return $_REQUEST[$requestkey];} else {return 1;}}
		function constructLink($suburl, $qurfront, $key, $nextprev_pageNumber) {$link= $suburl.$qurfront.$key.$nextprev_pageNumber; return $link;}
		
		function pageToggle($dir, $totpages, $thecurpge, $qurfront, $key, $suburl) {		
			if($dir=='left') {
				if(frstPage($thecurpge, 1)==false) {
					$prevP=$thecurpge-1;
					$prevlink = constructLink($suburl, $qurfront, $key, $prevP);
					echo "<a href='$prevlink' class='bpagetog bptoA'><img src='/wp-content/themes/kept-secret/images/page_prev.png' alt='<' /></a>";
				}
			}
			if($dir=='right') {
				if($thecurpge!=$totpages) {
				  $nextP=$thecurpge+1;
				  $nextlink = constructLink($suburl, $qurfront, $key, $nextP);
				  echo "&nbsp;&nbsp;<a href='$nextlink' class='bpagetog bptoB'> <img src='/wp-content/themes/kept-secret/images/page_next.png' alt='>' /></a>";
				}
			}
		}

		function uniPager($totalResults, $numRecords_per_page, $qurfront="?", $key="page=") {
			    			    
			    $suburl =  "/apps/unipager/universalpager.php"; //"/".explode("/", $_SERVER['REQUEST_URI'])[1];
			    $thecurpge =  1;
			    
			    if(preg_match("$qurfront$key",$_SERVER['REQUEST_URI'])) {
			       $thecurpge = substr(explode("$qurfront$key",$_SERVER['REQUEST_URI'])[1], 0, -1); // current page
			    }
			    
			    $prevpge = 1; // previous page
			    $qurfront = $qurfront; // to reconstruct next and prev links
			    $totpages = ceil($totalResults/$numRecords_per_page); //total pages			    
			    
			    /* Only show pager above a certain amount of results */
				if($totalResults > $numRecords_per_page) { 

					/* without page */
					//if( checkRequest('page')==false ) { $qurfront = $_SERVER['REQUEST_URI']."?";}
					/* with page */
					//if( checkRequest('page')!=false ) { $urlparts = explode('?page', $_SERVER['REQUEST_URI'] ); $qurfront = $urlparts[0]."?";}
					
					/* output pagination links */
					echo '<div class="seapager curved">';
					pageToggle('left', $totpages, $thecurpge, $qurfront, $key, $suburl);
					
				   /* PREVIOUS LINKS */	
				   if(frstPage(1, $thecurpge)==false) {
						$prevpge = $thecurpge-1;
						$prevpge_2 = $thecurpge-2;
						$prevpge_3 = $thecurpge-3;
						
						/* to show start link we must check if we are more than 5 away from curpage */
						$sep=''; if($thecurpge>5) {$sep='... ';}
						if($thecurpge>=5) { $prevlink=$suburl.$qurfront.$key."1"; echo "<a href='$prevlink'>1</a>&nbsp;&nbsp;$sep";}
						
						if($prevpge_3>=1) { $prevlink=$suburl.$qurfront.$key.$prevpge_3; echo "<a href='$prevlink'>$prevpge_3</a>&nbsp;&nbsp;";}
						if($prevpge_2>=1) { $prevlink=$suburl.$qurfront.$key.$prevpge_2; echo "<a href='$prevlink'>$prevpge_2</a>&nbsp;&nbsp;";}
						if($prevpge>=1) { $prevlink=$suburl.$qurfront.$key.$prevpge; echo "<a href='$prevlink'>$prevpge</a>&nbsp;&nbsp;";}
				   }
				   
				   /* CURRENT PAGE */
				   if($totpages > 1) {
				    $link=$suburl.$qurfront.$key.$thecurpge;
				    echo "<a class='isel' href='$link'>$thecurpge</a>&nbsp;&nbsp;";	
				   }
				   
				   /* NEXT LINKS */
				   if(lstPage(1,$totpages)==false) {
					   $nextpge = $thecurpge+1;
					   $nextpge_2 = $thecurpge+2;
					   $nextpge_3 = $thecurpge+3;
					   
					   if($nextpge<=$totpages) {$nextlink=$suburl.$qurfront.$key.$nextpge; echo "<a href='$nextlink'>$nextpge</a>&nbsp;&nbsp;";}
					   if($nextpge_2<=$totpages) {$nextlink=$suburl.$qurfront.$key.$nextpge_2; echo "<a href='$nextlink'>$nextpge_2</a>&nbsp;&nbsp;";}
					   if($nextpge_3<=$totpages) {$nextlink=$suburl.$qurfront.$key.$nextpge_3; echo "<a href='$nextlink'>$nextpge_3</a>&nbsp;&nbsp;";}
					   
					   $sep=''; if($thecurpge < ($totpages-4)) {$sep='... ';}
					   if($thecurpge <=($totpages-4)) { $prevlink=$suburl.$qurfront.$key.$totpages; echo "$sep<a href='$prevlink'>$totpages</a>";}
				   }
					   
                    pageToggle('right', $totpages, $thecurpge, $qurfront, $key, $suburl);
					//echo "<br />Total Page: $totpages / Current Page: $thecurpge";
					echo '</div>';
				}
		}
		
		
		/** END PAGINATION CODES **/
		
		/** TESTS **/
		/* if(lstPage(2, 1)==true) {echo 'pass';} else {echo 'fail';} // pass */
		/* echo curPage(checkRequest('page'), 1); // pass */
		/* pageToggle(checkRequest('page'), 'left', 26, 5, '?'); // pass */
		//uniPager(checkRequest('page'), 5, 26, 5, 14, 12); /* pass */
		uniPager(50, 10);
?>