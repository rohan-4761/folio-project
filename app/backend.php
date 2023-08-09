<?php
$data = [];
$filedata = [];
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$random_characters = substr(str_shuffle($characters), 0, 6);
$indexfile = $_POST['name'] . '.html';
$newDir = $_POST['name'] . $random_characters;
$uploads_dir = $newDir . '/';
$assets_Dir = $uploads_dir . 'assets/';
$images_dir = $assets_Dir . 'img/';
mkdir($newDir);
mkdir($assets_Dir);
mkdir($images_dir);

class ExtendedZip extends ZipArchive
{


    public function addTree($dirname, $localname = '')
    {
        if ($localname)
            $this->addEmptyDir($localname);
        $this->_addTree($dirname, $localname);
    }


    protected function _addTree($dirname, $localname)
    {
        $dir = opendir($dirname);
        while ($filename = readdir($dir)) {
            // Discard . and ..
            if ($filename == '.' || $filename == '..')
                continue;

 
            $path = $dirname . '/' . $filename;
            $localpath = $localname ? ($localname . '/' . $filename) : $filename;
            if (is_dir($path)) {

                $this->addEmptyDir($localpath);
                $this->_addTree($path, $localpath);
            } else if (is_file($path)) {

                $this->addFile($path, $localpath);
            }
        }
        closedir($dir);
    }

    // MAIN ZIPPING FUNCTION
    public static function zipTree($dirname, $zipFilename, $flags = 0, $localname = '')
    {
        $zip = new self();
        $zip->open($zipFilename, $flags);
        $zip->addTree($dirname, $localname);
        $zip->close();
    }
}

// Example

// TO GET THE DETAILS
foreach ($_POST as $key => $value) {
    if (isset($_POST[$key]) && !empty($_POST[$key])) {
        $data[$key] = $value;
    }
}
// TO GET THE NAMES OF THE FILE
foreach ($_FILES as $key => $value) {
    if (isset($_FILES[$key]) && !empty($_FILES[$key]) && is_uploaded_file($value['tmp_name'])) {
        $file_name = $_FILES[$key]['name'];
        $last_separator_position = strrpos($file_name, DIRECTORY_SEPARATOR);
        $base_name = substr($file_name, $last_separator_position);
        $filedata[$key] = $base_name;
    }
}

// TO MOVE IT TO IMAGE FOLDER
$targetDirectory = '../tempImages/';
foreach ($_FILES as $key => $value) {
    if (isset($_FILES[$key]) && !empty($_FILES[$key])) {
        $source = $_FILES[$key]['tmp_name'];
        $destination = $images_dir . $_FILES[$key]['name'];
        move_uploaded_file($source, $destination);
    }
}

//TO COPY ALL THE NO NEED TO EDIT FOLDERS
function copyFolder($src, $dst)
{
    $dir = opendir($src);
    if (!is_dir($dst)) {
        mkdir($dst);
    }
    while ($file = readdir($dir)) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        if (is_dir($src . '/' . $file)) {
            copyFolder($src . '/' . $file, $dst . '/' . $file);
        } else {
            copy($src . '/' . $file, $dst . '/' . $file);
        }
    }
    closedir($dir);
}

$str = '../editableTemplates/' . $_POST['form-source'];

// TO WRITE THE FILE
foreach (scandir($str) as $file) {
    if ($file == 'assets') {

        foreach (scandir($str . '/' . $file) as $folder) {
            if ($folder != 'img' && $folder != '.' && $folder != '..') {

                copyFolder($str . '/' . $file, $newDir . '/' . $file);
            }
        }
    } else if ($file == 'index.html') {
        $editfile = fopen($str . '/' . $file, "r");
        $newfile = fopen($indexfile, "w");
        while (!feof($editfile)) {
            $line = fgets($editfile);
            if (strpos($line, '$')) {
                foreach ($data as $key => $content) {
                    $search = '$' . $key;
                    if (strpos($line, $search)) {
                        $line = str_replace($search, $content, $line);
                    }
                }
                foreach ($filedata as $name => $content) {
                    $search = '$' . $name;
                    if (strpos($line, $search)) {
                        $line = str_replace($search, $content, $line);
                    }
                }
            }
            fwrite($newfile, $line);
        }
        fclose($newfile);
        fclose($editfile);
        rename($indexfile, $newDir . '/' . $indexfile);
    }
}
$zip_file_name = $newDir . '.zip';

ExtendedZip::zipTree($newDir, $zip_file_name, ZipArchive::CREATE);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
    <link rel="stylesheet" href="../static/styles.css" />
</head>

<body>
    <div class="bodycontainer">
        <div class="finalContainer">
            <div>Your Website is ready.</div>
            <a download href="<?php echo $zip_file_name ?>">Download here</a>
            <a href="<?php echo $newDir.'/'.$indexfile ?>" target="_blank">Preview</a>
        </div>
    </div>
</body>

</html>