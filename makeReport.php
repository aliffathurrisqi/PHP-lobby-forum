<?php

function makeReport($reportUser, $reportTipe, $reportSuspect, $reportAlasan)
{
    include "config.php";
    mysqli_query($conn, "INSERT INTO laporan VALUES(NULL,'$reportUser','$reportTipe','$reportSuspect','$reportAlasan',NOW(),'Tidak')");
}

// makeReport('aliffathurrisqi', 'Post', '2', 'Percobaan');
