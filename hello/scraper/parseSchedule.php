<?php

include('simple_html_dom.php');

//urls to scrape/parse
$cis = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=CIS&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$chem = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=CH&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$math = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=MATH&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$phys = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=PHYS&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$bi = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=BI&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&sel_cred=4&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$psy = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=PSY&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$geog = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=GEOG&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$geol = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=GEOL&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";
$wr = "http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in=201303&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&submit_btn=Submit&sel_subj=WR&sel_crse=&sel_crn=&sel_camp=%25&sel_levl=UG&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a";

//open/create text file to write to
$file = 'fall.txt';
$current = file_get_contents($file);
$spring = 3;
$a = 0;

function getCurrentCIS($url){
// Create DOM from URL or file
$html = new simple_html_dom();
$html = file_get_html($url);
//global $fp;
global $current;
global $a;
// get the table
foreach($html->find('td.dddead[width=323]') as $element){ 
       $item = $element->plaintext;
       //first split removes >3 and >4 from course name
       $split = explode(" >", $item);
       $numb = preg_replace("/[^0-9]/","",$split[0]);
       //first split removes >3 and >4 from course name
       $sp = preg_replace("/&nbsp;&nbsp;/","",$split[0]);
       $lines = file('cis2.csv', FILE_IGNORE_NEW_LINES);
       foreach($lines as $line){
          $cis = str_getcsv($line,",",'','');
          if($cis[1] == $sp){
              $a = $cis[0];
              $description = $cis[2];
              $credits = $cis[3];
              $str = "3," . $a . "\n";
              $current .= $str; 
          }
       }
         
   }
   $html->clear();
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
       $numb = preg_replace("/[^0-9]/","",$split[0]);
       if($numb > 226){
        break;
       }else{
       //we only want the courses in below array
       $classes = array("111", "113", "221", "222", "223", "224", "225", "226");
       if(in_array($numb, $classes)){
       $sp = preg_replace("/&nbsp;&nbsp;/","",$split[0]);
       $lines = file('ch.csv', FILE_IGNORE_NEW_LINES);
       foreach($lines as $line){
          $ch = str_getcsv($line,",",'','');
          if($ch[1] == $sp){
              $c = $ch[0];
              $description = $ch[2];
              $credits = $ch[3];
              $str = "3," . $c . "\n";
              $current .= $str; 
          }
       } 
     }
     }
    
   }
   $html->clear();
}

function getCurrentMATH($url){
// Create DOM from URL or file
$html = new simple_html_dom();
$html = file_get_html($url);
global $current;
// get the table
foreach($html->find('td.dddead[width=323]') as $element){ 
       $item = $element->plaintext;
       //first split removes >3 and >4 from course name
       $split = explode(" >", $item);
       $numb = preg_replace("/[^0-9]/","",$split[0]);
       //we only want the courses in below array
       $classes = array("111", "112", "231", "232", "233", "246", "247", "251", 
                            "252", "253", "256", "261", "262", "263", "281", "282", 
                            "307", "315", "341", "342", "343", "346", "351", "391", 
                            "392", "393", "411", "412", "413", "414", "415", "420", 
                            "421", "422", "425", "431", "432", "433", "441", "444", 
                            "445", "446", "456", "457", "461", "462", "463");
       if(in_array($numb, $classes)){
       $sp = preg_replace("/&nbsp;&nbsp;/","",$split[0]);
       $lines = file('math.csv', FILE_IGNORE_NEW_LINES);
       foreach($lines as $line){
          $math = str_getcsv($line,",",'','');
          if($math[1] == $sp){
              $m = $math[0];
              $description = $math[2];
              $credits = $math[3];
              $str = "3," . $m . "\n";
              $current .= $str; 
          }
       }
     }
    
   }
   $html->clear();
}

function getCurrentSCIWR($url, $code){
//code 0 = phys, 1 = bi, 2 = psy, 3 = geog, 4 = geol, 5 =wr
// Create DOM from URL or file
$html = new simple_html_dom();
$html = file_get_html($url);
global $current;
// get the table
foreach($html->find('td.dddead[width=323]') as $element){ 
       $item = $element->plaintext;
       //first split removes >3 and >4 from course name
       $split = explode(" >", $item);
       $numb = preg_replace("/[^0-9]/","",$split[0]);
       if($code == 0){
        $classes = array("201", "202", "203");
       }else if($code == 1){
        $classes = array("211", "212", "213");
       }else if($code == 2){
        $classes = array("201", "202", "304", "330", "348");
       }else if($code == 3){
        $classes = array("141", "321", "322", "323");
       }else if($code == 4){
        $classes = array("201", "202", "203");
       }else if($code == 5){
        $classes = array("320", "321");
       }
       if(in_array($numb, $classes)){
       $sp = preg_replace("/&nbsp;&nbsp;/","",$split[0]);
       $lines = file('sciwr.csv', FILE_IGNORE_NEW_LINES);
       foreach($lines as $line){
          $sciwr = str_getcsv($line,",",'','');
          if($sciwr[1] == $sp){
              $sw = $sciwr[0];
              $description = $sciwr[2];
              $credits = $sciwr[3];
              $str = "3," . $sw . "\n";
              $current .= $str; 
          }
       }
     }

    }
$html->clear();
}

$time_start = microtime(true); 
set_time_limit(0);
 getCurrentCIS($cis);
 getCurrentCH($chem);
 getCurrentMATH($math);
 getCurrentSCIWR($phys, 0);
 getCurrentSCIWR($bi, 1);
 getCurrentSCIWR($psy, 2);
 getCurrentSCIWR($geog, 3);
 getCurrentSCIWR($geol, 4);
 getCurrentSCIWR($wr, 5);
$time_end = microtime(true);

$time = number_format(($time_end - $time_start), 2);
 
echo '<br> This page loaded in ', $time, ' seconds';

//close and write after done
file_put_contents($file, $current)
?>