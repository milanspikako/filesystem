<?php
$data_post = $_POST;
$data_get = $_GET;
$old_name = '';
$message = [];
$folder = "";
$subfolder = "";


if (isset($data_get['old_name']))
{
    $old_name = $data_get['old_name'];
    $subfolder = substr($old_name, 0 , strrpos($old_name, "/") + 1);
$folder = substr($old_name, strrpos($old_name, "/") + 1 , strlen($old_name));

//Validation if exist
if (!file_exists($old_name))
{
    $message[] = "Fajl ili folder ne postoji";
    
}


} else {
 $message[] = "Nemamo podatke gde je stari fajl.";
}
if (isset($data_post['new_name']))
{
    $new_name = $data_post['new_name'];
//Validation 1

if (strlen($data_post['new_name']) > 100)
{
    $message[] = "Morate uneti manje od 100 karaktera";
}

//Validation 2 ekstenzija
if (isset($old_file) && is_file($old_file)) {
    echo "ovo je fajl";
   
if (strpos($data_post['new_name'], ".") == false)
{
  $message[] = "Morate uneti ekstenziju";  
   
}
}
//Validation 3
if (strlen($data_post['new_name']) < 3)
{
    $message[] = "Naziv mora imati vise od 3 karaktera";
}


}  else  {
    if (!empty($data_post)) {
  $message[] = "Mora postojati new_name";
    }
    

}
    if(empty($message) && $old_name != "" && isset($new_name))
{
    rename($old_name, $subfolder . $new_name);
    $message[] = "uspesno ste promenili naziv";
}


?>

 <html>
 <head>
     
 </head>

<body>
    <?php
/* $folder je krace ime fajla ili folder bez patha */ ?>
    <h1>Izmeni ime fajla ili foldera <?php echo $folder; ?></h1><br>
<form method="post" action="">
    <label> Novo ime: </label>
    <input type="text" name="new_name" value="<?php echo $folder; ?>"><br>
    <input type="submit" name="submit" value="Sacuvaj"><br>
    <?php
    if (!empty($message))
    {
    ?>
    <b style="color: red"><?php foreach ($message as $value) {
        echo $value . "<br>";
    
}?></b>
    <?php
    }
    ?>
    
    <a href="<?php echo "index.php?dir=" . $subfolder; ?>">Nazad</a>
</form>
</body>
</html> 