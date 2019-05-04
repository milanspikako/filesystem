<?php
$data_post = $_POST;
$data_get = $_GET;
$path = '';
$message = [];
$folder = "";
$subfolder = "";
include 'functions.php';

if (isset($data_get['path'])) {
    $path = $data_get['path'];
    $subfolder = substr($path, 0, strrpos($path, "/"));
    $subsubfolder = substr($subfolder, 0, strrpos($subfolder, "/"));
    $folder = substr($path, strrpos($path, "/") + 1, strlen($path));


//Validation if exist
    if (!file_exists($path)) {
        $message[] = "Fajl ili folder ne postoji";
    }
} else {
    $message[] = "Nemamo podatke gde je stari fajl.";
}
if (isset($data_post['new_path']) && !empty($data_post['new_path'])) {
    $new_path = $data_post['new_path'];
//Validation 1

    if (!in_array($new_path, print_dirs())) {
        $message[] = "Putanja ne postoji";
    }
} else {
    if (!empty($data_post)) {
        $message[] = "Mora postojati new_path";
    }
}
if (empty($message) && $path != "" && isset($new_path)) {


    if (is_dir($path)) {

        if (!dir_is_empty($path)) {


            mkdir($new_path . "/" . $folder, 0700);

            foreach (print_files_and_dirs($path) as $value) {

                if (is_dir($value)) {

                    mkdir($path . "/" . $value, 0700);
                } else {
                    $file_name = substr($value, strrpos($value, "/") + 1, strlen($value));
                    rename($value, $new_path . "/" . $folder . "/" . $file_name);
                }
            }
            rmdir($path);
        } else {
            mkdir($new_path . "/" . $folder, 0700);
            rmdir($path);
        }
    } elseif (is_file($path)) {

        rename($path, $new_path . "/" . $folder);
    }

    $message[] = "uspesno ste premestili folder";
}
?>

<html>
    <head>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

    </head>

    <body>
        <?php /* $folder je krace ime fajla ili folder bez patha */ ?>
        <h1 >Premesti ime fajla ili foldera <?php echo $folder; ?></h1><br>
        <form method="post" action="">
            <label> Premesti u: </label> 
            <?php
            $counter = 0;
            foreach (print_dirs() as $key => $value) {
                ?>

                <select style="display: none;" name="<?php
                echo $counter === 0 ? "dropdownlist" : $key;
                $counter++;
                ?>" id="new_path">
                    <option value="default" id="option"> Izaberi folder</option>
                    <option value="back" id="option"> Back</option>
                    <?php
                    foreach ($value as $pathF => $oneFolder) {
                        //if (is_dir($value) && $value !== $data_get['path'] && $value !== $folder) {
                        ?>
                        <option value="<?php echo $oneFolder; ?>" id="option"> <?php echo $oneFolder; ?>

                        </option>
                        <?php
                    }
                    ?>


                </select>  
                <?php
//}
            }
            ?>


            <div id="ajvar"> </div>


            <script>

//        $("*").ready(function () {
                $("#new_path:first").css("display", "block");
//        });

                //files/pera/majmun
                //on n occurance of substring in string return string2
                function occurrences(string, substring){
                var n = 0;
                var pos = 0;
                while (true){
                pos = string.indexOf(substring, pos);
                if (pos != - 1){ n++; pos += substring.length; }
                else{break; }
                }
                return(n);
                }


                function pos(n, substring, string) {
                var max = string.length;
                for (var i = max; i > 0; i--) {
                if (string.charAt(i) == substring)
                {
                 return i;
                }
                }


                }
                
                function position(n, substring, string) {
                var max = string.length;
                var occurance = 0;
                for (var i = 0; i < max; i++) {
                if (string.charAt(i) == substring)
                {
                    occurance++;
                    if(occurance == n)
                    {
                        return i;
                    }
      
                }
                }


                }
                

                

               

                $("select").change(function () {
                //$(this).html()
                //$("a[target='_blank']")
                var x = $(this).val();
                $("select[name='" + x + "']").css("display", "block");
                $("select[name*='" + x + "']").css("display", "block");
                $("select").not("[name*='" + x + "']").css("display", "none");
                alert(x);
                if (x == "back")
                {
                   var str = 
                }
                });





            </script>

            <br>
            <input type="submit" name="submit" value="Premesti"><br>
<?php
if (!empty($message)) {
    ?>
                <b style="color: red"><?php
    foreach ($message as $value) {
        echo $value . "<br>";
    }
    ?></b>
                    <?php
                }
                ?>

            <a href="index.php?dir=<?php echo!empty($subfolder) ? $subfolder : "files"; ?>">Nazad</a>
        </form>
    </body>
</html> 