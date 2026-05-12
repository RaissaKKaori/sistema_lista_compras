    <?php
    $servername = "127.0.0.1";
    $database = "listaCompras";
    $username = "root";
    $password = "";
    // Create connection
    global $global_conexao_mysqli;
    $global_conexao_mysqli = mysqli_connect($servername, $username, $password, $database);
    
    if (! $global_conexao_mysqli) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //mysqli_close($conn);
    ?>