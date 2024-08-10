<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<form id="spc-calculator-form" method="post">
    <label for="spc-length">Długość (cm):</label>
    <input type="number" id="spc-length" name="length" required>

    <label for="spc-width">Szerokość (cm):</label>
    <input type="number" id="spc-width" name="width" required>

    <label for="spc-height">Wysokość (cm):</label>
    <input type="number" id="spc-height" name="height" required>

    <button type="submit">Oblicz cenę przesyłki</button>
</form>

<div id="spc-result"></div>
