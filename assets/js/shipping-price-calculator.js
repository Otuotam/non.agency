(function($) {
    $('#spc-calculator-form').on('submit', function(e) {
        e.preventDefault();

        // Pobierz wartości z pól formularza
        let length = $('#spc-length').val();
        let width = $('#spc-width').val();
        let height = $('#spc-height').val();

        // Sprawdź, czy wartości są poprawnymi liczbami całkowitymi i dodatnimi
        if (!isPositiveInteger(length) || !isPositiveInteger(width) || !isPositiveInteger(height)) {
            $('#spc-result').html('<p>Błąd: Wszystkie wymiary muszą być dodatnimi liczbami całkowitymi.</p>');
            return;
        }

        $.ajax({
            url: spc_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'calculate_shipping_price', //nazwa funkcji obsługującej po stronie serwera
                length: length,
                width: width,
                height: height
            },
            success: function(response) {
                console.log(response); //pełna odpowiedź w konsoli

                if (response.success && response.data.shipping_cost != null) {
                    $('#spc-result').html('<p>Cena przesyłki: ' + response.data.shipping_cost + ' PLN</p>'); //poprawna odpowiedź
                } else {
                    $('#spc-result').html('<p>Błąd w odpowiedzi: ' + JSON.stringify(response) + '</p>'); //błąd z serwera API
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var response = jqXHR.responseJSON;
                if (response && response.data && response.data.message) {
                    $('#spc-result').html('<p>Błąd: ' + response.data.message + '</p>'); //błędy z serwera
                } else {
                    $('#spc-result').html('<p>Wystąpił błąd podczas obliczania ceny. Spróbuj ponownie później.</p>'); //nieprzewidziane błędy
                }
            }
        });
    });

    // Funkcja sprawdzająca, czy wartość jest dodatnią liczbą całkowitą
    function isPositiveInteger(value) {
        var num = Number(value);
        return Number.isInteger(num) && num > 0;
    }
})(jQuery);

