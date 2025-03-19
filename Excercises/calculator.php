<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from form submission
    $num1 = isset($_POST['number1']) ? $_POST['number1'] : 0;
    $num2 = isset($_POST['number2']) ? $_POST['number2'] : 0;
    $operation = isset($_POST['operation']) ? $_POST['operation'] : '+';
    
    // Perform calculation based on selected operation
    switch ($operation) {
        case '+':
            $result = $num1 + $num2;
            break;
        case '-':
            $result = $num1 - $num2;
            break;
        case '*':
            $result = $num1 * $num2;
            break;
        case '/':
            if ($num2 != 0) {
                $result = $num1 / $num2;
            } else {
                $result = "Cannot divide by zero.";
            }
            break;
        default:
            $result = "Invalid operation.";
    }
}
?>