<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Subject</title>
    </head>
    <body>
        <h1>Add Subject</h1>
        <form action="/home/store" method="POST">
            @csrf
            <p>Subject Code:<br><input type="text" name="code" value="" size="20"></p>
            <p>Title:<br><input type="text" name="title" value="" size="20"></p>
            <p>Credit Value:<br><input type="text" name="credit" value="" size="20"></p>
            <p>Year of Study:<br><input type="text" name="year" value="" size="20"></p>
            <input type="submit" value="Add" name="Add">
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>
