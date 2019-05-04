<?php
include_once 'functions.php';
$dataGet = $_GET;
if(isset($dataGet['dir'])) {
    $dataGet['dir'] = cleanPath($dataGet['dir']);
}

?>
<h1>Fajlovi</h1>

    <?php
    if (isset($dataGet['operation'])) {
        if ($dataGet['operation'] == "delete")
        {
        if (isset($dataGet['file'])) {

            unlink($dataGet['file']);
            ?>
    <b style="color: red;">Fajl uspesno obrisan.</b><br>
            <?php
        } else {
            
            $prom = $dataGet['dir'];
            if(dir_is_empty($prom)) {
                   array_map('unlink', glob("$prom/*.*"));
            rmdir($prom);
            } else {
                
               delete_subs($prom);
               rmdir($prom);
      
            }
         
            ?>
            <b style="color: red;">Folder uspesno obrisan.</b><br>
            <?php
        }
    }
    
    if($dataGet['operation'] === "mkdir" && isset($dataGet['foldername']) && !empty($dataGet['foldername']))
    {
        if(isset($dataGet['dir']))
        {
$newfolder = $dataGet['dir'] . $dataGet['foldername'];
        } else {
$newfolder = "files/" . $dataGet['foldername'];            
            
        }    
           if(!file_exists($newfolder))
           { 
               if(mkdir($newfolder))
               {
               ?>
            <b style="color: red;"> Uspesno kreiran folder </b><br><br>
              <?php
               } else {
                   ?>
              Greska <br><br>
              <?php
               }
              
           } else {
               ?>
             
              <b style="color: red;">Folder vec postoji</b> <br>
              <?php
           }
        
    }
    }
    
    
    if (isset($dataGet['dir'])) {
        $folder = $dataGet['dir'];
        foreach (folder_lists($folder) as $value) {
            
       
        
        ?>
        <a href="index.php?dir=<?php echo $value; ?>"> -Nazad na <?php echo $value; ?></a><br>
        <?php
         }
    } else {
        $folder = "files";
    }
?>
        <hr>
        <ul>
        <?php

        if (!count(load_arr($folder)) > 0 && !isset($dataGet['operation'])) 
        {
                ?>
            <b style="color: red;">Nema fajlova ni foldera.</b><br>
            <a href="?operation=mkdir<?php if(isset($dataGet['dir'])) { echo "&dir=" . $dataGet['dir'] . "/"; } ?>">Kreiraj folder</a><br>
            <?php
            
        }
        
                if(isset($dataGet['operation']) && $dataGet['operation'] === "mkdir")
        {
                    if(!isset($dataGet['foldername']))
                    {
                    ?>
            <form action="" method="get">
                <label> Unesi ime novog foldera : </label><br>
                <input type="text" name="foldername" value=""><br>
                 <input type="submit" name="submit" value="Dodaj"><br>
                 <input type="hidden" name="operation" value="mkdir">
                 <input type="hidden" name="dir" value="<?php echo $dataGet['dir']; ?>">
            </form>
            
            <?php
                    }   
            
        } else {

    foreach (load_arr($folder) as $key => $value) {

        if (is_dir($key)) {
            ?>  
            <li><a href="index.php?dir=<?php echo substr($key, strpos($key, "files/")); ?>">
            <?php echo substr($key, strpos($key, "files/")); ?>
                </a>
                <a href ="index.php?dir=<?php echo $key; ?>&operation=delete">[X]</a>
                <a href ="rename.php?old_name=<?php echo $key; ?>">[R]</a>
                <a href ="move.php?path=<?php echo $key; ?>">[M]</a>

            </li>

        <?php
    } else {
        ?>
                            <?php
                if (isset($dataGet['dir']))
                {
                    $directory = $dataGet['dir'] . "/";
                } else {
                    $directory = "files/";
                }
                ?>
            <li><a href="<?php echo $directory . $value; ?>">
            <?php echo $value; ?>
                </a>

                <a href ="index.php?file=<?php echo $directory . $value; ?>&operation=delete">[X]</a>
                <a href ="rename.php?old_name=<?php echo $directory . $value; ?>">[R]</a>
                <a href ="move.php?path=<?php echo $directory . $value ?>">[M]</a>
            </li>
                    <?php
                }
            }
        }
            ?>

</ul>





