<?php

session_start();

include_once('connect/connect.php');

//Tratando dados do formulário

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['name_company'])){

	$name 			= mysqli_escape_string($conn, $_POST['name']);
	$email 			= mysqli_escape_string($conn, strtolower ($_POST['email']));
	$tel 			= mysqli_escape_string($conn, $_POST['tel']);
	$name_company 	= mysqli_escape_string($conn, $_POST['name_company']);

	$verificar_usuario = mysqli_query($conn, "
								SELECT id 
								FROM users 
								WHERE email = '$email'
								") 
	or die(mysqli_error($conn));

	$num_rows = mysqli_num_rows($verificar_usuario);
	if ($num_rows > 0){
		echo "cadastrado";

		$atualiza_usuario = mysqli_query($conn, "
								UPDATE users 
								SET  name = '$name', tel = '$tel', 
									company = '$name_company', updated_at = NOW()
								WHERE email = '$email'								
									") 
		or die(mysqli_error($conn));
		$verificar_usuario = mysqli_query($conn, "
								SELECT id 
								FROM users 
								WHERE email = '$email'
								") 
		or die(mysqli_error($conn));

		$resultado_verificar_usuario = mysqli_fetch_assoc($verificar_usuario);
		$_SESSION['id'] = $resultado_verificar_usuario['id'];

	}else{
		echo "não cadastrado";

		$cadastra_usuario = mysqli_query($conn, "
								INSERT INTO users (name, email, tel, company,created_at)
								VALUES 
									('$name','$email','$tel','$name_company',NOW())
									") 
		or die(mysqli_error($conn));
		$verificar_usuario = mysqli_query($conn, "
								SELECT id 
								FROM users 
								WHERE email = '$email'
								") 
		or die(mysqli_error($conn));

		$resultado_verificar_usuario = mysqli_fetch_assoc($verificar_usuario);
		$_SESSION['id'] = $resultado_verificar_usuario['id'];
	
	}
	/*
	$resultado_verificar_usuario = mysqli_fetch_assoc($verificar_usuario);
	$cadastra_residuos = mysqli_query($conn, "
								INSERT INTO calculation (amount, destination_value, user_id, sub_category_id,created_at)
								VALUES 
									('$amount','$destination','".$resultado_verificar_usuario['id']."','$subcategory',NOW())
									") 
	or die(mysqli_error($conn));
	
*/
	header('Location:calcular.php');
} else {
	echo "Preencha todos os campos!";
	
	header('Location:index.php');
} 
