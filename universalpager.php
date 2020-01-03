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
		
		//function checkRequest($requestkey) {if(isset($_REQUEST[$requestkey])) {return $_REQUEST[$requestkey];} else {return 1;}}
		function outputLink($prevlink, $prevpge, $sep, $presep="") {echo "$presep<a href='$prevlink'>$prevpge</a>&nbsp;&nbsp;$sep";}
		
		function pageToggle($dir, $totpages, $thecurpge, $baseURL) {		
			if($dir=='left') {
				if(frstPage($thecurpge, 1)==false) {
					$prevP=$thecurpge-1;
					$prevlink = $baseURL.$prevP;
					echo "<strong><a href='$prevlink' class='bpagetog bptoA'>< </a></strong>";
				}
			}
			if($dir=='right') {
				if($thecurpge!=$totpages) {
				  $nextP=$thecurpge+1;
				  $nextlink = $baseURL.$nextP;
				  echo "&nbsp;&nbsp;<strong><a href='$nextlink' class='bpagetog bptoB'> ></a></strong>";
				}
			}
		}

		function uniPager($totalResults, $numRecords_per_page, $suburl, $qurfront="?", $key="page=") {
			
			    $requestURL = $_SERVER['REQUEST_URI'];		    
			    $thecurpge =  1;

			    if($qurfront == "?" && isset($_GET["page"]) && is_numeric($_GET["page"])) {$thecurpge = $_GET["page"];}
			    if($qurfront == "/" && preg_match("/page/", $requestURL)!=false) {
			     $urlparts = explode("page/", $requestURL); $urlparts = explode("/", $urlparts[1]);
			     $thecurpge = $urlparts[0];
			    }
			    
			    $prevpge = 1; // previous page
			    $totpages = ceil($totalResults/$numRecords_per_page); //total pages	
			    
			    $baseURL = $suburl.$qurfront.$key;
			    
			    /* Only show pager above a certain amount of results */
				if($totalResults > $numRecords_per_page) { 

					
					/* output pagination links */
					echo '<div class="seapager curved">';
					pageToggle('left', $totpages, $thecurpge, $baseURL);
					
				   /* PREVIOUS LINKS */	
				   if(frstPage(1, $thecurpge)==false) {
						$prevpge = $thecurpge-1;
						$prevpge_2 = $thecurpge-2;
						$prevpge_3 = $thecurpge-3;
						
						/* to show start link we must check if we are more than 5 away from curpage */
						$sep=''; if($thecurpge>5) {$sep='... ';}
						if($thecurpge>=5) { outputLink($baseURL."1", 1, $sep);}	
						if($prevpge_3>=1) { outputLink($baseURL.$prevpge_3, $prevpge_3, "");}
						if($prevpge_2>=1) { outputLink($baseURL.$prevpge_2, $prevpge_2, "");}
						if($prevpge>=1) { outputLink($baseURL.$prevpge, $prevpge, "");}
				   }
				   
				   /* CURRENT PAGE */
				   if($totpages > 1) {
				    $link=$baseURL.$thecurpge;
				    echo "<strong><a class='isel' href='$link'>$thecurpge</a></strong>&nbsp;&nbsp;";	
				   }
				   
				   /* NEXT LINKS */
				   if(lstPage(1,$totpages)==false) {
					   $nextpge = $thecurpge+1;
					   $nextpge_2 = $thecurpge+2;
					   $nextpge_3 = $thecurpge+3;
					   
					   if($nextpge<=$totpages) { outputLink($baseURL.$nextpge, $nextpge, ""); }
					   if($nextpge_2<=$totpages) {outputLink($baseURL.$nextpge_2, $nextpge_2, "");}
					   if($nextpge_3<=$totpages) {outputLink($baseURL.$nextpge_3, $nextpge_3, "");}
					   
					   $sep=''; if($thecurpge < ($totpages-4)) {$sep='... ';}
					   if($thecurpge <=($totpages-4)) { outputLink($baseURL.$totpages, $totpages, "", $sep);}
				   }
					   
                    pageToggle('right', $totpages, $thecurpge, $baseURL);
					echo "<br />Total Page: $totpages / Current Page: $thecurpge";
					echo '</div>';
				}
		}
		
		
		/** END PAGINATION CODES **/
		
		/** TESTS **/
		
		uniPager(500, 20, "/universalpager/universalpager_v3.php"); //pass 1/2/2020
		//uniPager(50, 10, "/universalpager/universalpager_v3.php", "/", "page/"); pass 1/2/2020
?>