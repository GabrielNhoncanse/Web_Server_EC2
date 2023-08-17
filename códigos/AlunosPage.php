<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Alunos page</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the ALUNO table exists. */
  VerifyAlunoTable($connection, DB_DATABASE);

  /* If input fields are populated, add a row to the ALUNO table. */
  $aluno_name = htmlentities($_POST['ALUNO_NAME']);
  $aluno_curso = htmlentities($_POST['ALUNO_CURSO']);
  $aluno_media = floatval($_POST['ALUNO_MEDIA']);
  $aluno_ano_formatura = intval($_POST['ALUNO_ANO_FORMATURA']);

  if (strlen($aluno_name) || strlen($aluno_curso) || $aluno_media > 0 || $aluno_ano_formatura > 0) {
    AddAluno($connection, $aluno_name, $aluno_curso, $aluno_media, $aluno_ano_formatura);
  }

  /* Process Aluno deletion */
  $delete_id = intval($_POST['DELETE_ID']);

  if ($delete_id > 0) {
    DeleteAlunoByID($connection, $delete_id);
  }
?>

<!-- Input form for aluno data -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>Aluno NAME</td>
      <td>Aluno CURSO</td>
      <td>Aluno MEDIA</td>
      <td>Aluno ANO FORMATURA</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="ALUNO_NAME" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="ALUNO_CURSO" maxlength="45" size="30" />
      </td>
      <td>
        <input type="number" step="0.01" name="ALUNO_MEDIA" size="10" />
      </td>
      <td>
        <input type="number" name="ALUNO_ANO_FORMATURA" size="10" />
      </td>
      <td>
        <input type="submit" value="Add Aluno Data" />
      </td>
    </tr>
  </table>
</form>

<!-- Delete Aluno by ID -->
<h2>Delete Aluno by ID</h2>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <label for="delete_id">Enter ID to delete:</label>
  <input type="number" name="DELETE_ID" id="delete_id" />
  <input type="submit" value="Delete Aluno" />
</form>

<!-- Display aluno table data -->
<h2>Aluno Table</h2>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>CURSO</td>
    <td>MEDIA</td>
    <td>ANO FORMATURA</td>
  </tr>
<?php
$result = mysqli_query($connection, "SELECT * FROM ALUNO");
while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td>",$query_data[3], "</td>",
       "<td>",$query_data[4], "</td>";
  echo "</tr>";
}
?>
</table>

<!-- Clean up. -->
<?php
  mysqli_free_result($result);
  mysqli_close($connection);
?>
</body>
</html>

<?php
/* Add a aluno to the table. */
function AddAluno($connection, $name, $curso, $media, $ano_formatura) {
   $n = mysqli_real_escape_string($connection, $name);
   $c = mysqli_real_escape_string($connection, $curso);
   $m = floatval($media);
   $af = intval($ano_formatura);

   $query = "INSERT INTO ALUNO (NAME, CURSO, MEDIA, ANO_FORMATURA) VALUES ('$n', '$c', $m, $af);";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding aluno data.</p>");
}

/* Delete a aluno by ID */
function DeleteAlunoByID($connection, $id) {
   $id = intval($id);

   $query = "DELETE FROM ALUNO WHERE ID = $id";

   if(!mysqli_query($connection, $query)) echo("<p>Error deleting aluno data.</p>");
}

/* Check whether the aluno table exists and, if not, create it. */
function VerifyAlunoTable($connection, $dbName) {
  if(!TableExists("ALUNO", $connection, $dbName))
  {
     $query = "CREATE TABLE ALUNO (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         CURSO VARCHAR(45),
         MEDIA FLOAT,
         ANO_FORMATURA INT
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating aluno table.</p>");
  }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>
