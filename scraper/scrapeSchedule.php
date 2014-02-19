<?php

//USES THE OPEN SOURCE SIMPLE HTML DOM LIBRARY
include('simple_html_dom.php');

//urls to scrape/parse
$cis = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=CIS&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$chem = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=CH&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";

//open/create text file to write to
$file = 'springSchedule.txt';
$current = file_get_contents($file);

function getCurrentCIS($url){
// Create DOM from URL or file
$html = new simple_html_dom();
$html = file_get_html($url);
global $current;
// get the table
foreach($html->find('td.dddead[width=323]') as $element){ 
       $item = $element->plaintext;
       //first split removes >3 and >4 from course name
       $split = explode(" >", $item);
       //second split removes &nbsp;&nbsp;
       //probably prettier way to do this but for now
       $split2 = explode("&nbsp;&nbsp;", $split[0]);
       $split3 = explode(" ", $split2[1]);
      	 echo $split3[0] . ' ';//CIS
     	 echo $split3[1] . ' '; //#
         echo $split2[2] . '<br>'; //COURSE TITLE
         $current .= "$split3[0] $split3[1] $split2[2]\n";
   }
}

function getCurrentCH($url){
// Create DOM from URL or file
$html = new simple_html_dom();
$html = file_get_html($url);
global $current;
// get the table
foreach($html->find('td.dddead[width=323]') as $element){ 
       $item = $element->plaintext;
       //first split removes >3 and >4 from course name
       $split = explode(" >", $item);
       //second split removes &nbsp;&nbsp;
       //probably prettier way to do this but for now
       $split2 = explode("&nbsp;&nbsp;", $split[0]);
       $split3 = explode(" ", $split2[1]);
       //we only want the chem courses in below array
       $chemclasses = array("111", "113", "221", "222", "223", "224H", "225H", "226H");
      if(in_array($split3[1], $chemclasses)){
      	 echo $split3[0] . ' ';//CH
     	   echo $split3[1] . ' '; //#
         echo $split2[2] . '<br>'; //COURSE TITLE
         $current .= "$split3[0] $split3[1] $split2[2]\n";
     }
   }
}

getCurrentCIS($cis);
getCurrentCH($chem);

//close and write after done
file_put_contents($file, $current)
?>