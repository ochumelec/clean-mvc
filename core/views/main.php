<?php require_once(dirname(__FILE__).'/page_parts/header.php')?>
<?php require_once(dirname(__FILE__).'/page_parts/navigation.php')?>
<?php require_once(dirname(__FILE__).'/page_parts/center.php')?>
<?php require_once(dirname(__FILE__).'/page_parts/footer.php')?>

<?php
function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

//echo convert(memory_get_peak_usage(true));
?>