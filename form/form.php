<?php
	// Функция очистки данных от ненужных тегов и элементов
	function clean($value = "") {
	    $value = trim($value);
	    $value = stripslashes($value);
	    $value = strip_tags($value);
	    $value = htmlspecialchars($value);
	    
	    return $value;
	}
	//Функция проверки длинны строки
	function check_length($value = "", $min, $max) {
	    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
	    return !$result;
	}
	$pattern = "#^[-+0-9()\s]+$#"; 
	$name = clean($_POST['name']);
	$email = clean($_POST['email']);
	$phone = clean($_POST['phone']);

	// массив для хранения ошибок
	$errorContainer = array();
	// полученные данные
	// $arrayFields = array(
	//     'name' => clean($_POST['name']),
	//     'email' => clean($_POST['email']),
	//     'phone' => clean($_POST['phone'])
	// );
	 
	// // проверка всех полей на пустоту
	// foreach($arrayFields as $fieldName => $oneField){
	//     if($oneField == '' || !isset($oneField)){
	//         $errorContainer[$fieldName] = 'Поле обязательно для заполнения';
	//     }
	// }
	if(empty($name)){
		$errorContainer['name'] = 'Поле обязательно для заполнения';
	}else if (!empty($name) && !check_length($name, 6, 12)) {
		$errorContainer['name'] = 'Введено некорректное имя';
	}

	if(empty($email)){
		$errorContainer['email'] = 'Поле обязательно для заполнения';
	}else if(!empty($email) && !$email_validate = filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errorContainer['email'] = 'Неверно введен email';
	}

	if(empty($phone)){
		$errorContainer['phone'] = 'Поле обязательно для заполнения';
	}else if(!empty($phone) && !preg_match($pattern, $phone, $out)){
		$errorContainer['phone'] = 'Неверно введен номер телефона';
	}


	// if(!empty($name) && !empty($surname) && !empty($email) && !empty($message)) {
	//     $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL); 

	//     if(check_length($name, 2, 25) && check_length($surname, 2, 50) && check_length($message, 2, 1000) && $email_validate) {
	//         echo "Спасибо за сообщение";
	//     } else { // добавили сообщение
	//         echo "Введенные данные некорректные";
	//     }
	// } else { // добавили сообщение
	//     echo "Заполните пустые поля";
	// }

	// делаем ответ для клиента
	if(empty($errorContainer)){
	    // если нет ошибок сообщаем об успехе
	    echo json_encode(array('result' => 'success'));
	}else{
	    // если есть ошибки то отправляем
	    echo json_encode(array('result' => 'error', 'text_error' => $errorContainer));
	}
?>