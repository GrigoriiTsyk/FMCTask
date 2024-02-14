export function ajaxFunction(price, currentValute, nextValute){
    $.ajax({
        url: "/CurrencyConverter.php",
        type: "POST",
        dataType: "html",
        data: {price, currentValute, nextValute},
        //beforeSend:functionBefore,
        success:functionSuccess
    });
}

export function functionBefore(){
    $("#value").text("Ожидание данных...");
}

export function functionSuccess(data){
    $("#value").text(data);
}