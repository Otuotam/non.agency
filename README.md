# non.agency

Stworzyłem shortcode [shipping_price_calculator], który w połączeniu z mechanizmem admin-ajax.php umożliwia przesyłanie danych z frontendu do backendu. Tam są one przetwarzane i przesyłane do zewnętrznego API. Aby uniknąć niepotrzebnego obciążania zewnętrznego API błędnymi zapytaniami, walidację wykonałem po stronie serwera.

Dodatkowo, w panelu WordPressa, w lewym menu, dodałem nową stronę opcji o nazwie "Shipping Price". Dzięki niej można łatwo skonfigurować wszystkie ustawienia bez potrzeby grzebania w kodzie.