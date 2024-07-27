<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP File Upload to AWS S3 Bucket - Laratutorials.com</title>
</head>
<body>
    <form action="upload2.php" method="post" enctype="multipart/form-data">
        <h2>PHP Upload File</h2>
        <label for="file_name">Filename:</label>
        <input type="file" name="anyfile" id="anyfile">
        <input type="submit" name="submit" value="Upload">
    </form>
</body>
</html>