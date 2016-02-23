<?php
    $page_title = "Files Uploaded";
    $title = "Convo Portal | File Uploaded";
    include("../core/init.php");
    admin_protect();
    protect_page();
    include("../assets/inc/header.inc.php");

    // Bytes Conversion Function
    function formatBytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

        return round(pow(1024, $base - floor($base)), $precision) . " " . $suffixes[floor($base)];
    }

?>

            <h1 class="headerPages">Files Uploaded to Portal</h1>

            <h2>Files</h2>
            <div class="file_upload">   <!-- File Upload -->
                <table class="table table-bordered table-hover" id="tab_logic">
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Date</th>
                            <th>Size</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php

                function newest($a, $b) { 
                    return (filemtime($a) > filemtime($b)) ? -1 : 1; 
                } 

                $dir = glob($root . '/convo/Admin/upload_oe/*'); // put all files in an array 
                //$dir = glob($root . '/convo/Admin/upload_oe/*');
                uasort($dir, "newest"); // sort the array by calling newest() 

                foreach($dir as $file) { 
                    $fileLink = substr($file, 25);
                    echo "<tr><td width='30%'><a href='" . $linkToALL . "/" . $fileLink .  "' target='_blank'>" . basename($file) . "</a></td><td width='35%'>" . date("F d, Y g:i:s A", filemtime($file)) . "</td><td width='30%'>" .  formatBytes(filesize($file), 1) . "</td></tr>"; ; 
                } 
            ?>         
                    </tbody>
                </table>
            </div>  <!-- File Upload // -->
<?php
    include("../assets/inc/footer.inc.php");
?>