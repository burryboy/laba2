<?php
require_once __DIR__ . "/vendor/autoload.php";


function localStor($text)
{
    $script = "<script >localStorage.setItem('savedText','$text')</script>";
    echo $script;
}

function getWardByNurse($id_nurse)
{
    $collection = (new MongoDB\Client)->lb2var3->duty; 
    $filter=array("fid_nurse" => floatval($id_nurse));
    $cursor = $collection->find($filter);

    $wards_fid = array();

    foreach ($cursor as $document)
    {      
        array_push($wards_fid, $document['fid_ward']);
    }
    
    $collection = (new MongoDB\Client)->lb2var3->ward; 

    $filter=array("id_ward" => array('$in'=>$wards_fid));

    $cursor = $collection->find($filter);

    $html ="<table border=1>";    
    $html = $html."<tr><td><b>Палата</b></td></tr>";
    foreach ($cursor as $document)
    {
        $html = $html."<tr><td>".$document['name']."</td></tr>";                 
    }
        $html = $html."</table>";
        echo  $html;
    
        localStor($html);
}

function getNurseByDepartment($department)
{ 
    $collection = (new MongoDB\Client)->lb2var3->duty; 
    $filter=array("department" => $department); 
    $cursor = $collection->find($filter);
    
    $nurse_fid = array();

    foreach ($cursor as $document)
    {      
        array_push($nurse_fid, $document['fid_nurse']);
    }

    $collection = (new MongoDB\Client)->lb2var3->nurse; 

    $filter=array("id_nurse" => array('$in'=>$nurse_fid));

    $cursor = $collection->find($filter);


    $html ="<table border=1 inset >"; 
    
    foreach ($cursor as $document)
    {
        $html = $html."<tr><td>".$document['name']."</td></tr>";      
    }

    $html = $html."</table>";
    echo  $html;
    localStor($html);
}

function getNurse($id)
{
    $filter=array("id_nurse" => $id);
    $collection = (new MongoDB\Client)->lb2var3->nurse; 
    $cursor = $collection->find($filter); 

    foreach ($cursor as $document)
    {
        return $document['name'];
    }
}


function getWard($id)
{
    $filter=array("id_ward" => $id);
    $collection = (new MongoDB\Client)->lb2var3->ward; 
    $cursor = $collection->find($filter); 

    foreach ($cursor as $document)
    {
        return $document['name'];
    }
}


function getDutyInfoByShiftAndDepartment($shift, $department)
{
    $exsistFlag = false;

    $filter=array("shift" => $shift,  "department" => $department); 
    $collection = (new MongoDB\Client)->lb2var3->duty; 
    $cursor = $collection->find($filter); 
     
    $html ="<table border=1 solid >";    
    $html = $html."<tr><td>Медсестра</td><td>Дата</td><td>Зміна</td><td>Відділення</td><td>Палата</td></tr>";
    foreach ($cursor as $document)
    {
        $exsistFlag = true;
        $html = $html."<tr>  <td>".getNurse($document['fid_nurse'])."</td><td>".$document['date']."</td><td>".$document['shift']."</td><td>".$document['department']."</td><td>".getWard($document['fid_ward'])."</td></tr>";      
    }
    if ( $exsistFlag == false)
    {
        $html = $html."В даному відділенні немає чергувань для цієї зміни";
    }

    $html = $html."</table>";
    echo  $html;

    localStor($html);
}


if(array_key_exists('button1',$_POST))
{    
    getWardByNurse($_POST['nurse']);     
}
else if (array_key_exists('button2',$_POST))
{
    getNurseByDepartment($_POST['department']); 
}
else if (array_key_exists('button3',$_POST))
{        
    getDutyInfoByShiftAndDepartment($_POST['shift'],$_POST['department']); 
}

