<?php
// Exibir erros de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../inc/dbinfo.inc"; 
?>

<html>
<body>
<h1>Corinthians 2012</h1>

<?php

  // Conecte-se ao MySQL e selecione o banco de dados
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();  // Adiciona esta linha para sair se houver um erro de conexão
  }

  $database = mysqli_select_db($connection, DB_DATABASE);

  // Verifique se a tabela existe
  VerifyTable($connection, DB_DATABASE);

  // Se os campos de entrada estiverem preenchidos, adicione uma linha à tabela
  $nome = htmlentities($_POST['NOME']);
  $posicao = htmlentities($_POST['POSICAO']);
  $gols = htmlentities($_POST['GOLS']);
  $data_nascimento = htmlentities($_POST['DATA_NASCIMENTO']);

  if (strlen($nome) || strlen($posicao)) {
    AddPlayer($connection, $nome, $posicao, $gols, $data_nascimento);
  }
?>

<!-- Formulário de entrada -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>Nome</td>
      <td>Posição</td>
      <td>Gols</td>
      <td>Data de Nascimento</td>
    </tr>
    <tr>
      <td><input type="text" name="NOME" maxlength="50" size="30" /></td>
      <td><input type="text" name="POSICAO" maxlength="20" size="20" /></td>
      <td><input type="number" name="GOLS" min="0" /></td>
      <td><input type="date" name="DATA_NASCIMENTO" /></td>
      <td><input type="submit" value="Adicionar Jogador" /></td>
    </tr>
  </table>
</form>

<!-- Exibir dados da tabela. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>Jogador_ID</td>
    <td>Nome</td>
    <td>Posição</td>
    <td>Gols</td>
    <td>Data de Nascimento</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM Corinthians_2012");

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

<!-- Limpeza -->
<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>


<?php

/* Adicionar um jogador à tabela. */
function AddPlayer($connection, $nome, $posicao, $gols, $data_nascimento) {
   $n = mysqli_real_escape_string($connection, $nome);
   $p = mysqli_real_escape_string($connection, $posicao);
   $g = mysqli_real_escape_string($connection, $gols);
   $d = mysqli_real_escape_string($connection, $data_nascimento);

   $query = "INSERT INTO Corinthians_2012 (Nome, Posição, Gols, Data_Nascimento) VALUES ('$n', '$p', '$g', '$d');";

   if(!mysqli_query($connection, $query)) echo("<p>Erro ao adicionar dados do jogador.</p>");
}

/* Verifique se a tabela existe e, se não, crie-a. */
function VerifyTable($connection, $dbName) {
  if(!TableExists("Corinthians_2012", $connection, $dbName)) {
     $query = "CREATE TABLE Corinthians_2012 (
         Jogador_ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         Nome VARCHAR(50) NOT NULL,
         Posição VARCHAR(20) NOT NULL,
         Gols INT,
         Data_Nascimento DATE
       )";

     if(!mysqli_query($connection, $query)) echo("<p>Erro ao criar a tabela.</p>");
  }
}

/* Verificar a existência de uma tabela. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>