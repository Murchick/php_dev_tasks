$(document).ready(function() {
    $('#phone').mask("380 (99)999-99-99");
    $('#form_test').submit(function(){
        // убираем класс ошибок с инпутов
        $('input').each(function(){
            $(this).removeClass('error_input');
        });
        // прячем текст ошибок
        $('.error').hide();
         
        // получение данных из полей
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
         
        $.ajax({
            // метод отправки 
            type: "POST",
            // путь до скрипта-обработчика
            url: "form.php",
            // какие данные будут переданы
            data: {
                'name': name, 
                'email': email,
                'phone': phone
            },
            // тип передачи данных
            dataType: "json",
            // действие, при ответе с сервера
            success: function(data){
                // в случае, когда пришло success. Отработало без ошибок
                if(data.result == 'success'){   
                    $('#succes').text('Данные успешно отправлены')
                    $("#form_test").trigger('reset')
                // в случае ошибок в форме
                }else{
                    // перебираем массив с ошибками
                    for(var errorField in data.text_error){
                        // выводим текст ошибок 
                        $('#'+errorField+'_error').html(data.text_error[errorField]);
                        // показываем текст ошибок
                        $('#'+errorField+'_error').show();
                        // обводим инпуты красным цветом
                        $('#'+errorField).addClass('error_input');                      
                    }
                }
            }
        });
        // останавливаем сабмит, чтоб не перезагружалась страница
        return false;
    });
});